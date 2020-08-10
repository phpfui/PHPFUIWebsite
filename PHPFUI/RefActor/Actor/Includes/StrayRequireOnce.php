<?php

namespace PHPFUI\RefActor\Actor\Includes;

class StrayRequireOnce extends \PHPFUI\RefActor\Actor\Base
	{

	public function enterNode(\PhpParser\Node $node)
		{
		if ($node instanceof \PhpParser\Node\Stmt\InlineHTML)
			{
			if (strpos($node->value, 'require_once') !== false)
				{
				$this->refActor->log('error', 'Stray require_once in ' . $this->getCurrentFile());
				}
			}
		}

	public function getDescription() : string
		{
		return 'Checks for require_once in HTML blocks';
		}

	public function getTestCases() : array
		{
		$testCases = [];

///////////// Test Case 0 ///////////////////
		$original = <<<'PHP'
PHP;

		$modified = <<<'PHP'
PHP;
		$testCases[] = [$original, $modified];

		return $testCases;
		}

	}

