<?php

namespace PHPFUI\RefActor\Actor\Includes;

class Remove extends \PHPFUI\RefActor\Actor\Base
	{

	private $callback = null;
	private \PhpParser\PrettyPrinter\Standard $prettyPrinter;

	public function __construct(?callable $callback = null)
		{
		$this->callback = $callback;
		$this->prettyPrinter = new \PhpParser\PrettyPrinter\Standard(['shortArraySyntax' => true]);
		}

	public function getDescription() : string
		{
		return 'Removes a matching include or require';
		}

	public function leaveNode(\PhpParser\Node $node)
		{
		if ($node instanceof \PhpParser\Node\Stmt\Expression && $node->expr instanceof \PhpParser\Node\Expr\Include_)
			{
			$source = $this->prettyPrinter->prettyPrintExpr($node->expr->expr);
			$callback = $this->callback;
			if (! $callback || $callback($source))
				{
				$this->setPrint(true);

				return \PhpParser\NodeTraverser::REMOVE_NODE;
				}
			}

		return;
		}

	public function getTestCases() : array
		{
		$testCases = [];

		$original = <<<'PHP'
<?php

require_once 'matchingFile.php';
PHP;

		$modified = <<<'PHP'
<?php

PHP;
		$testCases[] = [$original, $modified];

		return $testCases;
		}

	}
