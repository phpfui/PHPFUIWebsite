<?php

namespace App\View\BuriedTreasure;

class HomePage extends \App\View\BuriedTreasure\WWWPublicBase implements \PHPFUI\Interfaces\NanoClass
	{
	public function __construct(\PHPFUI\Interfaces\NanoController $controller)
		{
		parent::__construct($controller);
		$this->page->addHeader('Home');
		}
	}
