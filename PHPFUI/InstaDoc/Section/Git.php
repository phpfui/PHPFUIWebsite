<?php

namespace PHPFUI\InstaDoc\Section;

class Git extends \PHPFUI\InstaDoc\Section
	{

	public function generate(\PHPFUI\Page $page, string $fullClassPath) : \PHPFUI\Container
		{
		$container = new \PHPFUI\Container();

		$gitPage = $this->controller->getParameter(\PHPFUI\InstaDoc\Controller::GIT_ONPAGE, 0);
		$limit = $this->controller->getParameter(\PHPFUI\InstaDoc\Controller::GIT_LIMIT, 20);

		$repo = new \Gitonomy\Git\Repository($_SERVER['DOCUMENT_ROOT'] . '/..');
		$result = $repo->run('show-branch');
		$branch = substr($result, strpos($result, '[') + 1, strpos($result, ']') - 1);
		$log = $repo->getLog($branch, $fullClassPath, 0, 10);
		$count = $log->count();
		$lastPage = (int)(($count - 1) / $limit) + 1;

		$log->setOffset($gitPage * $limit);
		$log->setLimit($limit);

		$table = new \PHPFUI\Table();
		$table->setHeaders(['Title', 'Name', 'Date', 'Diff']);
		$localTZ = new \DateTimeZone(date_default_timezone_get());

		foreach ($log->getCommits() as $commit)
			{
			$row['Title'] = $commit->getShortMessage();
			$row['Name'] = \PHPFUI\Link::email($commit->getCommitterEmail(), $commit->getCommitterName(), 'Your commit ' . $commit->getHash());
			$row['Date'] = $commit->getCommitterDate()->setTimezone($localTZ)->format('Y-m-d g:i a');
			$revealLink = new \PHPFUI\Link('', $commit->getShortHash(), false);
			$this->getReveal($page, $revealLink, $commit);
			$row['Diff'] = $revealLink;

			$table->addRow($row);
			}

		$container->add($table);

		$this->controller->setParameter(\PHPFUI\InstaDoc\Controller::GIT_LIMIT, $limit);
		$this->controller->setParameter(\PHPFUI\InstaDoc\Controller::GIT_ONPAGE, 'PAGE');

		$paginator = new \PHPFUI\Pagination($gitPage, $lastPage, $this->controller->getUrl($this->controller->getParameters()));
		$paginator->center();
		$paginator->setFastForward(3);
		$container->add($paginator);

		return $container;
		}

	private function getReveal(\PHPFUI\Page $page, \PHPFUI\HTML5Element $opener, \Gitonomy\Git\Commit $commit) : \PHPFUI\Reveal
		{
		$reveal = new \PHPFUI\Reveal($page, $opener);
		$reveal->addClass('large');

		$container = new \PHPFUI\Container();
		$container->add(new \PHPFUI\Header('Commit ' . $commit->getHash(), 5));

		$localTZ = new \DateTimeZone(date_default_timezone_get());
		$date = $commit->getCommitterDate()->setTimezone($localTZ)->format('Y-m-d g:i a');

		$container->add(new \PHPFUI\MultiColumn($commit->getCommitterName(), $date));

//		$files = $commit->getDiff()->getFiles();
//
//		$table = new \PHPFUI\Table();
//		foreach ($files as $file)
//			{
//			$table->addRow([print_r($file->toArray(), true)]);
//			}
//		$container->add($table);
		$reveal->add($container);

		return $reveal;
		}

	}
