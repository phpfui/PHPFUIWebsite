<?php

namespace PHPFUI\RefActor\Actor;

class NukeCommentedOutCode extends \PHPFUI\RefActor\Actor\Base
	{

	private \PhpParser\Lexer\Emulative $lexer;

	private \PhpParser\Parser $parser;

	public function setRefActor(\PHPFUI\RefActor $refActor) : self
		{
		parent::setRefActor($refActor);

		$factory = new \PhpParser\ParserFactory();
		$this->lexer = new \PhpParser\Lexer\Emulative([
				'usedAttributes' => [
						'comments',
						'startLine', 'endLine',
						'startTokenPos', 'endTokenPos',
				],
		]);
		$this->parser = $factory->create($refActor->getPHPVersion(), $this->lexer);

		return $this;
		}

	public function getDescription() : string
		{
		return 'Removes commented out PHP code from the source.  If comment text will parse as PHP, the comment is removed.  Will not nuke code in DOCBLOCKS.';
		}

	public function leaveNode(\PhpParser\Node $node)
		{
		if ($node instanceof \PhpParser\Node\Stmt\Nop)
			{
			$commentBlock = '';
			foreach ($node->getComments() as $commentObject)
				{
				// convert the comment to string
				$comment = "{$commentObject}";

				if (strpos($comment, '//') === 0)
					{
					$comment = trim($comment, ' /');
					}
				elseif ($comment[0] == '#')
					{
					$comment = trim($comment, ' #');
					}
				elseif (strpos($comment, '/**') === 0)
					{
					// docblock, skip
					return;
					}
				else // should be /* comment */
					{
					$comment = substr($comment, 2);
					$comment = str_replace('*/', '', $comment);
					}

				$commentBlock .= $comment;
				}

			try
				{
				// need to prepend the php
				$ast = $this->parser->parse('<?php ' . $commentBlock);
				if (count($ast))
					{
					$this->setPrint();
					return \PhpParser\NodeTraverser::REMOVE_NODE;
					}
				}
			catch (\Throwable $e)
				{
				}

			}

		return;
		}

	public function getTestCases() : array
		{
		$testCases = [];

		$original = <<<'PHP'
<?php
$test = 1;
// echo $test;
$test = 2;
/*
echo $test;
*/
// this comment remains
$test = 3;
// echo $test;
/*
$test += 1;
*/
echo $test;
PHP;
		$modified = <<<'PHP'
<?php
$test = 1;

$test = 2;

// this comment remains
$test = 3;


echo $test;
PHP;
		$testCases[] = [$original, $modified];

		return $testCases;
		}

	}
