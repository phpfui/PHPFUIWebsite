<?php

namespace Example;

class Landing extends \Example\Page
	{

	public function __construct()
		{
		parent::__construct();

		$menu = $this->getMenu();
		$ul = new \PHPFUI\UnorderedList();

		foreach ($menu->getMenuItems() as $menuItem)
			{
			$ul->addItem(new \PHPFUI\ListItem(new \PHPFUI\Link($menuItem->getLink(), $menuItem->getName(), false)));
			}

		$this->addBody($ul);
		}

	}
