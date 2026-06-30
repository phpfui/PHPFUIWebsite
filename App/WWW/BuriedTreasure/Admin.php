<?php

namespace App\WWW;

class Admin extends \App\View\BuriedTreasure\WWWPublicBase implements \PHPFUI\Interfaces\NanoClass
	{
	public function home() : void
		{
		$this->page->addHeader('Admin');
		$ul = new \PHPFUI\UnorderedList();
		$ul->addItem(new \PHPFUI\ListItem(new \PHPFUI\Link('/BuriedTreasure/Admin/Albums', 'Albums', false)));
		$ul->addItem(new \PHPFUI\ListItem(new \PHPFUI\Link('/BuriedTreasure/Admin/Artists', 'Artists', false)));
		$ul->addItem(new \PHPFUI\ListItem(new \PHPFUI\Link('/BuriedTreasure/Admin/Titles', 'Titles', false)));
		$ul->addItem(new \PHPFUI\ListItem(new \PHPFUI\Link('/BuriedTreasure/Admin/Shows/0', 'Shows', false)));
		$this->page->addPageContent($ul);
		}
	}
