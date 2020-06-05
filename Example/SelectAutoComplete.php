<?php

namespace Example;

class SelectAutoComplete extends Page
	{

	public function __construct()
		{
		parent::__construct();

		$this->addBody(new \PHPFUI\Header('Select Auto Complete Country Example'));

		$this->addBody('If you have a lot of selections, then a <b>SelectAutoComplete</b> offers a drop in replacement for a <b>Select</b>, but a better user experience than selecting from a huge list. ');
		$this->addBody(new \PHPFUI\Link('http://' . $_SERVER['SERVER_NAME'] . '/states.tsv', 'Data Source'));
		$form = new \PHPFUI\Form($this);
		$select = new \Example\View\State($this, 'state', 'Pick a USA State');
		$select->setToolTip('Start typing to find a state by name or abbreviation');
		$form->add($select);
		$form->add(new \PHPFUI\Submit('Save'));
		$this->setDebug(1);

		$this->addBody($form);
		}

	}
