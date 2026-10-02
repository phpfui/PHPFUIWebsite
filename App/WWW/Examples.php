<?php

namespace App\WWW;

class Examples implements \PHPFUI\Interfaces\NanoClass
	{

	private $view = null;

	public function __construct(\PHPFUI\Interfaces\NanoController $controller)
		{
		}

	public function __toString() : string
		{
		return (string)$this->view;
		}

	public function abide() : void
		{
		\PHPFUI\Session::setFlash('post', '');

		$this->view = new \Example\Abide();
		}

	public function abideValidation() : void
		{
		$this->view = new \Example\AbideValidation();
		}

	public function accordionToFromList() : void
		{
		$this->view = new \Example\AccordionToFromList();
		}

	public function autoComplete() : void
		{
		$this->view = new \Example\AutoComplete();
		}

	public function checkBoxMenu() : void
		{
		$this->view = new \Example\CheckBoxMenu();
		}

	public function composerVersion() : void
		{
		$this->view = new \Example\ComposerVersion();
		}

	public function eMailButtonGenerator() : void
		{
		\PHPFUI\Session::setFlash('post', '');

		$this->view = new \Example\EMailButtonGenerator($_GET);
		}

	public function gPX2CueSheet() : void
		{
		\PHPFUI\Session::setFlash('post', '');

		$this->view = new \Example\GPX2CueSheet($_GET);
		}

	public function landing() : void
		{
		$this->view = new \Example\Landing();
		}

	public function kitchenSink() : void
		{
		$this->view = new \Example\KitchenSink();
		}

	public function orbit() : void
		{
		$this->view = new \Example\Orbit();
		}

	public function orderableTable() : void
		{
		$this->view = new \Example\OrderableTable();
		}

	public function pagination() : void
		{
		$this->view = new \Example\Pagination($_GET);
		}

	public function rWGPS2CueSheet() : void
		{
		\PHPFUI\Session::setFlash('post', '');

		$this->view = new \Example\RWGPS2CueSheet($_GET);
		}

	public function selectAutoComplete() : void
		{
		$this->view = new \Example\SelectAutoComplete();
		}

	public function sortableTable() : void
		{
		$this->view = new \Example\SortableTable();
		}

	public function toFromList() : void
		{
		\PHPFUI\Session::setFlash('post', '');

		$this->view = new \Example\ToFromList();
		}
	}
