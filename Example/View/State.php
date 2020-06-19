<?php

namespace Example\View;

class State extends \PHPFUI\Input\SelectAutoComplete
	{

	public function __construct(\PHPFUI\Page $page, string $name, string $label = '', string $value = '')
		{
		parent::__construct($page, $name, $label);
		$model = new \Example\Model\State();

		foreach ($model->getStates() as $state)
			{
			$this->addOption($state['state'] . ' - ' . $state['name'], $state['state'], $state['state'] == $value);
			}
		}

	}
