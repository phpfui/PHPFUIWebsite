<?php

namespace PHPFUI\RefActor\Actor\Includes;

class Add extends \PHPFUI\RefActor\Actor\Base
	{

	private array $includeStatements = [];

	public function __construct(string $phpExpression = "'autoloader.php'")
		{
		$parser = (new \PhpParser\ParserFactory())->create(\PhpParser\ParserFactory::PREFER_PHP7);
		$nodes = $parser->parse('<?php ' . $phpExpression . ';');

		if (is_array($nodes))
			{
			$includeExpression = $nodes[0]->expr;
			$expression = new \PhpParser\Node\Stmt\Expression(new \PhpParser\Node\Expr\Include_($includeExpression, \PhpParser\Node\Expr\Include_::TYPE_REQUIRE_ONCE));
			$expression->setAttributes([]);
			$this->includeStatements[] = $expression;
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

		if ($nodes[0] instanceof \PhpParser\Node\Stmt\InlineHTML)
			{
			array_splice($nodes, 1, 0, $this->includeStatements);

			return $nodes;
			}

		return array_merge($this->includeStatements, $nodes);
		}

	public function getDescription() : string
		{
		return 'Adds a require_once at the top of each file';
		}

	public function getTestCases() : array
		{
		$testCases = [];

///////////// Test Case 0 ///////////////////
		$original = <<<'PHP'
<?php

$someCode = getcwd();
PHP;

		$modified = <<<'PHP'
<?php

require_once 'autoloader.php';

$someCode = getcwd();
PHP;
		$testCases[] = [$original, $modified];

///////////// Test Case 1 ///////////////////
		$original = <<<'PHP'
<?php
$someCode = getcwd();
PHP;

		$modified = <<<'PHP'
<?php

require_once 'autoloader.php';

$someCode = getcwd();
PHP;
		$testCases[] = [$original, $modified];

///////////// Test Case 2 ///////////////////
//  		$original = <<<'PHP'
// <div>Some HTML</div>
// <?php
//
// $someCode = getcwd();
// PHP;
//
// 		$modified = <<<'PHP'
// <div>Some HTML</div>
// <?php
//
// require_once 'autoloader.php';
//
// $someCode = getcwd();
// PHP;
// 		$testCases[] = [$original, $modified];

///////////// Test Case 3 ///////////////////
		$original = <<<'PHP'
<?php

$someCode = getcwd();
?>
<div>Some HTML</div>
PHP;

		$modified = <<<'PHP'
<?php

require_once 'autoloader.php';

$someCode = getcwd();
?>
<div>Some HTML</div>
PHP;
		$testCases[] = [$original, $modified];

		return $testCases;
		}

	}
