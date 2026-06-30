<?php

namespace App\View\BuriedTreasure;

class Missing extends \App\View\BuriedTreasure\Page implements \PHPFUI\Interfaces\NanoClass
	{
	public function __construct(\PHPFUI\Interfaces\NanoController $controller)
		{
		parent::__construct($controller);
		$this->addPageContent(new \PHPFUI\Header($controller->getUri() . ' was not found on this server.'));
		}
	}
