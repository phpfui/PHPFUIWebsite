<?php

namespace App;

class Missing implements \PHPFUI\Interfaces\NanoClass
	{
	public function __construct(\PHPFUI\Interfaces\NanoController $controller)
		{
		$this->redirect();
		}

	public function __toString() : string
		{
		$this->redirect();

		return '';
		}

	public function redirect() : void
		{
		\header("location: /");
		}

	}
