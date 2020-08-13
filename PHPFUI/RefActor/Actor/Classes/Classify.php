<?php

namespace PHPFUI\RefActor\Actor\Classes;

class Classify extends \PHPFUI\RefActor\Actor\Base
	{

	private \PhpParser\Parser $parser;
	private \PhpParser\PrettyPrinter\Standard $prettyPrinter;
	private \PHPFUI\RefActor\ClassNameParserBase $classNames;
	private string $classRoot = '';
	private array $ast = [];
	private string $className = '';
	private string $namespace = '';
	private array $functions = [];
	private array $functionsCalled = [];

	public function __construct(string $classRoot, \PHPFUI\RefActor\ClassNameParserBase $classNames)
		{
		$this->classNames = $classNames;
		$this->classRoot = $classRoot;
		$factory = new \PhpParser\ParserFactory();
		$this->parser = $factory->create(\PhpParser\ParserFactory::PREFER_PHP5);
		$this->prettyPrinter = new \PhpParser\PrettyPrinter\Standard(['shortArraySyntax' => true]);
		}

	public function shouldProcessFile(string $file) : bool
		{
		parent::shouldProcessFile($file);

		$this->className = $this->classNames->getClassName($file);
		$this->namespace = $this->classNames->getNamespace($file);
		$this->functions = [];
		$this->functionsCalled = [];

		$code = '<?php
namespace TestNamespace;

class TestClass
	{

	public function __toString()
		{
		$retVal = "";
		}

	}';

		$code = str_replace(['TestNamespace', 'TestClass'], [$this->namespace, $this->className], $code);
		$this->ast = $this->parser->parse($code);

		return true;
		}

	public function leaveNode(\PhpParser\Node $node)
		{
		if ($node instanceof \PhpParser\Node\Stmt\Function_)
			{
			$this->functions[$node->name->name] = $node;
			}
		elseif ($node instanceof \PhpParser\Node\Stmt\Expression && $node->expr instanceof \PhpParser\Node\Expr\FuncCall)
			{
			$functionName = implode('\\', $node->expr->name->parts);
			$this->functionsCalled[$functionName][] = $node;
			}
    elseif (property_exists($node, 'stmts'))
			{
			$node->stmts = $this->processNodes($node->stmts);
			}

		return;
		}

	private function processNodes(array $nodes, array $existingNodes = []) : array
		{
		foreach ($nodes as $node)
			{
			if ($node instanceof \PhpParser\Node\Stmt\InlineHTML)
				{
				$concat = new \PhpParser\Node\Expr\AssignOp\Concat(
						new \PhpParser\Node\Expr\Variable('retVal'),
						new \PhpParser\Node\Scalar\String_($node->value,
								['kind' => \PhpParser\Node\Scalar\String_::KIND_NOWDOC, 'docLabel' => 'HTML']));
				$existingNodes[] = new \PhpParser\Node\Stmt\Expression($concat);
				}
			elseif ($node instanceof \PhpParser\Node\Stmt\Echo_)
				{
				$concat = new \PhpParser\Node\Expr\AssignOp\Concat(
						new \PhpParser\Node\Expr\Variable('retVal'),
						$node->exprs[0]);
				$existingNodes[] = new \PhpParser\Node\Stmt\Expression($concat);
				}
			elseif ($node instanceof \PhpParser\Node\Stmt\Function_)
				{
				$functions[$node->name->name] = $node;
				}
			else
				{
				$existingNodes[] = $node;
				}
			}

		return $existingNodes;
		}

	public function afterTraverse(array $nodes)
		{
		$newNodes = $this->processNodes($nodes);
		$newNodes[] = new \PhpParser\Node\Stmt\Return_(new \PhpParser\Node\Expr\Variable('retVal'));

		$this->ast[0]->stmts[0]->stmts[0]->stmts = array_merge($this->ast[0]->stmts[0]->stmts[0]->stmts, $newNodes);

		// add in functions we found
		foreach($this->functions as $name => $functionNode)
			{
			// if function was not actually used, then skip it, local unused function
			if (! isset($this->functionsCalled[$name]))
				{
				continue;
				}
			$classMethod = new \PhpParser\Node\Stmt\ClassMethod($name);
			$classMethod->flags = \PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE;
			$classMethod->params = $functionNode->params;
			$classMethod->byRef = $functionNode->byRef;
			$classMethod->returnType = $functionNode->returnType;
			$statements = [new \PhpParser\Node\Stmt\Expression(new \PhpParser\Node\Expr\Assign(new \PhpParser\Node\Expr\Variable('retVal'),
					new \PhpParser\Node\Scalar\String_('', ['kind' => \PhpParser\Node\Scalar\String_::KIND_SINGLE_QUOTED])))];

			$statements = $this->processNodes($functionNode->stmts, $statements);
			$statements[] = new \PhpParser\Node\Stmt\Return_(new \PhpParser\Node\Expr\Variable('retVal'));
			$classMethod->stmts = $statements;
			$this->ast[0]->stmts[0]->stmts[] = $classMethod;

			// Transform the $functionCallNode call into a $retVal .= $this->method() call node
			foreach ($this->functionsCalled[$name] as $functionCallNode)
				{
				$retValVar = new \PhpParser\Node\Expr\Variable('retVal');
				$thisVar = new \PhpParser\Node\Expr\Variable('this');
				$methodCall = new \PhpParser\Node\Expr\MethodCall($thisVar, $name, $functionCallNode->expr->args);
				$methodCallNode = new \PhpParser\Node\Expr\AssignOp\Concat($retValVar, $methodCall);
				$functionCallNode->expr = $methodCallNode;
				}
			}

		$code = $this->prettyPrinter->prettyPrint($this->ast);

		$dir = $this->classRoot . '/' . $this->namespace;
		if (! file_exists($dir))
			{
			mkdir($dir, 0777, true);
			}

		$file = $dir . '/' . $this->className . '.php';
		file_put_contents(str_replace('\\', '/', $file), "<?php\n\n" . $code);

		return null;
		}

	public function getDescription() : string
		{
		return 'Converts plain PHP file that outputs html to a class with a __toString method that returns the echoed output';
		}

	public function getTestCases() : array
		{
		$testCases = [];

		$original = <<<'PHP'
PHP;

		$modified = <<<'PHP'
PHP;
		$testCases[] = [$original, $modified];

		return $testCases;
		}

	}
