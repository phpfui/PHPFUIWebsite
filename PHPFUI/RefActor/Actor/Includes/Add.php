<?php

namespace PHPFUI\RefActor\Actor\Includes;

class Add extends \PHPFUI\RefActor\Actor\Base
	{

	private array $includeStatements = [];

	public function __construct(string $phpExpression = 'autoloader.php')
		{
		$parser = (new \PhpParser\ParserFactory())->create(\PhpParser\ParserFactory::PREFER_PHP7);
		$nodes = $parser->parse('<?php ' . $phpExpression . ';');
		if (is_array($nodes))
			{
			$expression = $nodes[0]->expr;
			$this->includeStatements[] = new \PhpParser\Node\Stmt\Expression(new \PhpParser\Node\Expr\Include_($expression, \PhpParser\Node\Expr\Include_::TYPE_REQUIRE_ONCE));
			$this->includeStatements[] = new \PhpParser\Node\Stmt\Nop();
			}
		else
			{
			throw new \Exception(__CLASS__ . ": ({$phpExpression}) is not a valid PHP Expression");
			}
		}

	public function afterTraverse(array $nodes)
		{
		$this->setPrint(true);
		return array_merge($this->includeStatements, $nodes);
		}

	public function getDescription() : string
		{
		return 'Adds a require_once at the top of each file';
		}

	}

