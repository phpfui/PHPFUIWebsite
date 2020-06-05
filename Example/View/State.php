<?php

namespace Example\View;

class State extends \PHPFUI\Input\SelectAutoComplete
	{

	public function __construct(\PHPFUI\Page $page, string $name, string $label = '', string $value = '')
		{
		parent::__construct($page, $name, $label);
		$csvReader = new \Example\Model\CSVReader($_SERVER['DOCUMENT_ROOT'] . '/states.tsv', true, "\t");

		foreach ($csvReader as $state)
			{
			$this->addOption($state['state'] . ' - ' . $state['name'], $state['state'], $state['state'] == $value);
			}
		}

	}
