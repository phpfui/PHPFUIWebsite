<?php

namespace App\WWW\BuriedTreasure\Admin;

class Rank extends \App\View\BuriedTreasure\WWWAdminBase implements \PHPFUI\Interfaces\NanoClass
	{
	public function request() : void
		{
		$this->page->addHeader('Rank');

		// compute ranks

		$showSequence = new \App\Table\ShowSequence();
		$artists = [];
		$titles = [];
		$albums = [];

		foreach ($showSequence->getRecordCursor() as $showSequence)
			{
			$this->add($artists, $showSequence->artistId);
			$this->add($titles, $showSequence->titleId);
			$this->add($albums, $showSequence->albumId);
			}

		$this->rank($artists, 'Artist');
		$this->rank($albums, 'Album');
		$this->rank($titles, 'Title');

		$this->page->addPageContent('Data has been reranked');
		}

	private function rank(array $list, string $class) : void
		{
		$class = "\\App\\Record\\{$class}";
		\arsort($list);
		$rank = $tieRank = 1;
		$crud = new $class();
		$lastPlays = 0;

		foreach ($list as $id => $plays)
			{
			if ($lastPlays != $plays)
				{
				$lastPlays = $plays;
				$tieRank = $rank;
				}
			$crud->read($id);
			$crud->plays = $plays;
			$crud->rank = $tieRank;
			$crud->update();
			++$rank;
			}
		}

	private function add(array &$list, ?int $thing) : void
		{
		if (empty($thing))
			{
			return;
			}

		if (! isset($list[$thing]))
			{
			$list[$thing] = 0;
			}
		++$list[$thing];
		}
	}
