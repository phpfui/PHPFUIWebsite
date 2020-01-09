<?php

namespace PHPFUI\InstaDoc\Section;

class Git extends \PHPFUI\InstaDoc\Section
	{

	private function displayTree(\PHPFUI\HTML5Element $container, \Gitonomy\Git\Tree $tree, int $indent = 0)
		{
		$tabs = str_repeat("\t", $indent);
		foreach ($tree->getEntries() as $name => $data)
			{
			list($mode, $entry) = $data;
			if ($entry instanceof \Gitonomy\Git\Tree)
				{
				$container->add($tabs.$name."/");
				$this->displayTree($container, $tree, $indent + 1);
				}
			else
				{
				$container->add($tabs.$name."\n");
				}
			}
		}

	public function generate(\PHPFUI\Page $page, string $fullClassPath) : \PHPFUI\Container
		{
		$container = new \PHPFUI\Container();

		$repo = new \Gitonomy\Git\Repository($_SERVER['DOCUMENT_ROOT'] . '/..');
		$result = $repo->run('show-branch');
		$branch = substr($result, strpos($result, '[') + 1, strpos($result, ']') - 1);
		$log = $repo->getLog($branch, $fullClassPath, 0, 10);
		$table = new \PHPFUI\Table();
		$table->setHeaders(['Title', 'Name', 'Date']);
		$localTZ = new \DateTimeZone(date_default_timezone_get());
		foreach ($log->getCommits() as $commit)
			{
			$row['Title'] = $commit->getShortMessage();
			$row['Name'] = \PHPFUI\Link::email($commit->getCommitterEmail(), $commit->getCommitterName(), 'Your commit ' . $commit->getHash());
			$row['Date'] = $commit->getCommitterDate()->setTimezone($localTZ)->format('Y-m-d g:i a');
			$table->addRow($row);
			}
		$container->add($table);

		return $container;
		}
	}
