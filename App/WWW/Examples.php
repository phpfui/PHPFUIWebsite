<?php

namespace App\WWW;

class Examples implements \PHPFUI\Interfaces\NanoClass
	{

	public function abide() : \Example\Abide
		{
		\PHPFUI\Session::setFlash('post', '');

		return new \Example\Abide();
		}

	public function abideValidation() : \Example\AbideValidation
		{
		return new \Example\AbideValidation();
		}

	public function accordionToFromList() : \Example\AccordionToFromList
		{
		return new \Example\AccordionToFromList();
		}

	public function autoComplete() : \Example\AutoComplete
		{
		return new \Example\AutoComplete();
		}

	public function checkBoxMenu() : \Example\CheckBoxMenu
		{
		return new \Example\CheckBoxMenu();
		}

	public function composerVersion() : \Example\ComposerVersion
		{
		return new \Example\ComposerVersion();
		}

	public function eMailButtonGenerator() : \Example\EMailButtonGenerator
		{
		\PHPFUI\Session::setFlash('post', '');

		return new \Example\EMailButtonGenerator($_GET);
		}

	public function gPX2CueSheet() : \Example\GPX2CueSheet
		{
		\PHPFUI\Session::setFlash('post', '');

		return new \Example\GPX2CueSheet($_GET);
		}

	public function landing() : \Example\Landing
		{
		return new \Example\Landing();
		}

	public function kitchenSink() : \Example\KitchenSink
		{
		return new \Example\KitchenSink();
		}

	public function orbit() : \Example\Orbit
		{
		return new \Example\Orbit();
		}

	public function orderableTable() : \Example\OrderableTable
		{
		return new \Example\OrderableTable();
		}

	public function pagination() : \Example\Pagination
		{
		return new \Example\Pagination($_GET);
		}

	public function rWGPS2CueSheet() : \Example\RWGPS2CueSheet
		{
		\PHPFUI\Session::setFlash('post', '');

		return new \Example\RWGPS2CueSheet($_GET);
		}

	public function selectAutoComplete() : \Example\SelectAutoComplete
		{
		return new \Example\SelectAutoComplete();
		}

	public function sortableTable() : \Example\SortableTable
		{
		return new \Example\SortableTable();
		}

	public function toFromList() : \Example\ToFromList
		{
		\PHPFUI\Session::setFlash('post', '');

		return new \Example\ToFromList();
		}
