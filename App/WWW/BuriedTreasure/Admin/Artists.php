<?php

namespace App\WWW\BuriedTreasure\Admin;

class Artists extends \App\View\BuriedTreasure\WWWAdminBase implements \PHPFUI\Interfaces\NanoClass
	{
	public function edit(\App\Record\Artist $artist = new \App\Record\Artist()) : void
		{
		if ($artist->empty())
			{
			$this->page->redirect($this->page->getRelativeURL('home'));

			return;
			}

		$this->addHeaderFromMethod(__METHOD__, $artist->artist);

		$view = new \App\View\Edit($this->page);
		$this->page->addPageContent($view->edit($artist));
		}

	public function merge() : void
		{
		$this->page->addHeader('Merge Artists');

		$view = new \App\View\Cleanup($this->page, new \App\Table\Artist());
		$this->page->addPageContent($view->list());
		}
	}
