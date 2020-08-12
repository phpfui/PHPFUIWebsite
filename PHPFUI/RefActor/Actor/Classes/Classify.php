<?php

namespace PHPFUI\RefActor\Actor\Classes;

class Classify extends \PHPFUI\RefActor\Actor\Base
	{

	private \PhpParser\Parser $parser;
	private \PhpParser\PrettyPrinter\Standard $prettyPrinter;
	private \PHPFUI\RefActor\ClassNameParserBase $classNames;
	private array $ast = [];
	private string $className = '';
	private string $namespace = '';
	private string $projectRoot = '';
	private array $functions = [];

	public function __construct(string $projectRoot, \PHPFUI\RefActor\ClassNameParserBase $classNames)
		{
		$this->classNames = $classNames;
		$this->projectRoot = $projectRoot;
		$factory = new \PhpParser\ParserFactory();
		$this->parser = $factory->create(\PhpParser\ParserFactory::PREFER_PHP5);
		$this->prettyPrinter = new \PhpParser\PrettyPrinter\Standard(['shortArraySyntax' => true]);
		}

	public function shouldProcessFile(string $file) : bool
		{
		parent::shouldProcessFile($file);

		$this->className = $this->classNames->getClassName($file);
		$this->namespace = $this->classNames->getNamespace($file);

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
			if (isset($this->functions[$node->name->name]))
				{
				echo "We have a function {$node->name->name}\n";
				}
			}

		return;
		}

	private function processNodes(array $nodes) : array
		{
		$newNodes = [];

		foreach ($nodes as $node)
			{
			if ($node instanceof \PhpParser\Node\Stmt\Expression)
				{
				$newNodes[] = $node;
				}
			elseif ($node instanceof \PhpParser\Node\Stmt\InlineHTML)
				{
				$concat = new \PhpParser\Node\Expr\AssignOp\Concat(
						new \PhpParser\Node\Expr\Variable('retVal'),
						new \PhpParser\Node\Scalar\String_($node->value,
								['kind' => \PhpParser\Node\Scalar\String_::KIND_NOWDOC, 'docLabel' => 'HTML']));
				$newNodes[] = new \PhpParser\Node\Stmt\Expression($concat);
				}
			elseif ($node instanceof \PhpParser\Node\Stmt\Echo_)
				{
				$concat = new \PhpParser\Node\Expr\AssignOp\Concat(
						new \PhpParser\Node\Expr\Variable('retVal'),
						$node->exprs[0]);
				$newNodes[] = new \PhpParser\Node\Stmt\Expression($concat);
				}
			elseif ($node instanceof \PhpParser\Node\Stmt\Function_)
				{
				$functions[$node->name->name] = $node;
				}
			}

		return $newNodes;
		}

	public function afterTraverse(array $nodes)
		{
		foreach ($nodes as $node)
			{
			if ($node instanceof \PhpParser\Node\Stmt\Expression)
				{
				$this->ast[0]->stmts[0]->stmts[0]->stmts[] = $node;
				}
			elseif ($node instanceof \PhpParser\Node\Stmt\InlineHTML)
				{
				$concat = new \PhpParser\Node\Expr\AssignOp\Concat(
						new \PhpParser\Node\Expr\Variable('retVal'),
						new \PhpParser\Node\Scalar\String_($node->value,
								['kind' => \PhpParser\Node\Scalar\String_::KIND_NOWDOC, 'docLabel' => 'HTML']));
				$this->ast[0]->stmts[0]->stmts[0]->stmts[] = new \PhpParser\Node\Stmt\Expression($concat);
				}
			elseif ($node instanceof \PhpParser\Node\Stmt\Echo_)
				{
				$concat = new \PhpParser\Node\Expr\AssignOp\Concat(
						new \PhpParser\Node\Expr\Variable('retVal'),
						$node->exprs[0]);
				$this->ast[0]->stmts[0]->stmts[0]->stmts[] = new \PhpParser\Node\Stmt\Expression($concat);
				}
			elseif ($node instanceof \PhpParser\Node\Stmt\Function_)
				{
				$this->functions[$node->name->name] = $node;
				}
			}

		$newNodes = $this->processNodes($nodes);
		$newNodes[] = new \PhpParser\Node\Stmt\Return_(new \PhpParser\Node\Expr\Variable('retVal'));

		$this->ast[0]->stmts[0]->stmts[0]->stmts = array_merge($this->ast[0]->stmts[0]->stmts[0]->stmts, $newNodes);

		// add in functions we found
		foreach($this->functions as $name => $functionNode)
			{
			echo "function found ($name}\n";
			}

		$code = $this->prettyPrinter->prettyPrint($this->ast);

		$dir = $this->projectRoot . '/' . $this->namespace;
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

/*
(
    [0] => PhpParser\Node\Stmt\Class_ Object
        (
            [name] => PhpParser\Node\Identifier Object
                (
                    [name] => Test
                )
            [stmts] => Array
                (
                    [0] => PhpParser\Node\Stmt\ClassMethod Object
                        (
                            [flags] => 1
                            [name] => PhpParser\Node\Identifier Object
                                (
                                    [name] => method
                                )
                            [params] => Array
                                (
                                    [0] => PhpParser\Node\Param Object
                                        (
                                            [type] =>
                                            [byRef] =>
                                            [variadic] =>
                                            [var] => PhpParser\Node\Expr\Variable Object
                                                (
                                                    [name] => arg
                                                )
                                            [default] =>
                                            [flags] => 0
                                        )
                                    [1] => PhpParser\Node\Param Object
                                        (
                                            [type] =>
                                            [byRef] =>
                                            [variadic] =>
                                            [var] => PhpParser\Node\Expr\Variable Object
                                                (
                                                    [name] => arg2
                                                )
                                            [default] =>
                                            [flags] => 0
                                        )
                                )
                            [returnType] =>
                            [stmts] => Array
                                (
                                    [0] => PhpParser\Node\Stmt\Expression Object
                                        (
                                            [expr] => PhpParser\Node\Expr\Assign Object
                                                (
                                                    [var] => PhpParser\Node\Expr\Variable Object
                                                        (
                                                            [name] => retVal
                                                        )
                                                    [expr] => PhpParser\Node\Scalar\String_ Object
                                                        (
                                                            [value] =>
                                                            [attributes:protected] => Array
                                                                (
                                                                    [startLine] => 6
                                                                    [endLine] => 6
                                                                    [kind] => 2
                                                                )

                                                        )

                                                    [attributes:protected] => Array
                                                        (
                                                            [startLine] => 6
                                                            [endLine] => 6
                                                        )

                                                )

                                            [attributes:protected] => Array
                                                (
                                                    [startLine] => 6
                                                    [endLine] => 6
                                                )

                                        )

                                    [1] => PhpParser\Node\Stmt\Return_ Object
                                        (
                                            [expr] => PhpParser\Node\Expr\Variable Object
                                                (
                                                    [name] => retVal
                                                    [attributes:protected] => Array
                                                        (
                                                            [startLine] => 8
                                                            [endLine] => 8
                                                        )

                                                )

                                            [attributes:protected] => Array
                                                (
                                                    [startLine] => 8
                                                    [endLine] => 8
                                                )

                                        )

                                )

                            [attributes:protected] => Array
                                (
                                    [startLine] => 4
                                    [endLine] => 9
                                )

                        )

                )

            [attributes:protected] => Array
                (
                    [startLine] => 2
                    [endLine] => 10
                )

        )

)
 */
