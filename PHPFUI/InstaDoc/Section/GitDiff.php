<?php

namespace PHPFUI\InstaDoc\Section;

class GitDiff extends \PHPFUI\InstaDoc\Section
	{

	public function generate(\PHPFUI\Page $page, string $fullClassName) : \PHPFUI\Container
		{
		$repo = new \Gitonomy\Git\Repository($_SERVER['DOCUMENT_ROOT'] . '/..');
		$container = new \PHPFUI\Container();

		$sha1 = $this->controller->getParameter(\PHPFUI\InstaDoc\Controller::GIT_SHA1);
		$tabSize = str_pad('', (int)$this->controller->getParameter(\PHPFUI\InstaDoc\Controller::TAB_SIZE, 2));
		$container->add(new \PHPFUI\Header('Commit ' . $sha1, 4));

		$commit = $repo->getCommit($sha1);

		if (! $commit)
			{
			$container->add('Commit not found');

			return $container;
			}

		$localTZ = new \DateTimeZone(date_default_timezone_get());
		$date = $commit->getCommitterDate()->setTimezone($localTZ)->format('Y-m-d g:i a');

		$container->add(new \PHPFUI\MultiColumn($commit->getCommitterName(), $date));

		$targetFile = str_replace('\\', '/', $fullClassName) . '.php';
		$file = 0;
		$files = $commit->getDiff()->getFiles();

		if (empty($files))
			{
			$container->add(new \PHPFUI\Header('No diffs found for this commit.', 5));

			return $container;
			}

		foreach ($commit->getDiff()->getFiles() as $file)
			{
			if ($file->getName() == $targetFile)
				{
				break;
				}
			$file = 0;
			}
		$classes = [
			\Gitonomy\Git\Diff\FileChange::LINE_ADD => 'git-removed',
			\Gitonomy\Git\Diff\FileChange::LINE_CONTEXT => 'git-unchanged',
			\Gitonomy\Git\Diff\FileChange::LINE_REMOVE => 'git-added',
			];

		if ($file)
			{
			$hr = '';
			$codeBlock = new \PHPFUI\HTML5Element('pre');

			foreach ($file->getChanges() as $change)
				{
				$codeBlock->add($hr);
				$hr = '<hr>';

				foreach ($change->getLines() as $line)
					{
					[$type, $code] = $line;
					$span = new \PHPFUI\HTML5Element('span');
					$span->addClass($classes[$type]);
					$span->add(\PHPFUI\TextHelper::htmlentities(str_replace("\t", $tabSize, $code)));
					$codeBlock->add($span . "\n");
					}
				}
			$container->add($codeBlock);
			}
		else
			{
			$container->add("{$targetFile} not found in commit");
			}

		return $container;
		}

	}
