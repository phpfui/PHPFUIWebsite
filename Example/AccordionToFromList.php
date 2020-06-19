<?php

namespace Example;

class AccordionToFromList extends \Example\Page
	{

	public function __construct()
		{
		parent::__construct();

		$this->addBody(new \PHPFUI\Header('AccordionToFromList Example'));
		$this->addBody('A mobile friendly drag and drop interface for larger datasets. Use ToFromList for smaller lists. ');
		$this->addBody(new \PHPFUI\Link('http://' . $_SERVER['SERVER_NAME'] . '/countries.csv', 'Data Source'));

		$inGroup = $notInGroup = [];
		$model = new \Example\Model\Country();
		$name = 'country';
		$post = \PHPFUI\Session::getFlash('post');

		if ($post)
			{
			$posted = json_decode($post, true);
			$inGroup = $model->getSelected($posted[$name . '-in'] ?? []);
			$notInGroup = $model->getSelected($posted[$name . '-out'] ?? []);
			}

		if (0 == count($inGroup) + count($notInGroup))
			{
			$inGroup = $model->getFiltered(function($countryName) {return strpos(' AEIOU', $countryName[0]);});
			$notInGroup = $model->getFiltered(function($countryName) {return ! strpos(' AEIOU', $countryName[0]);});
			}

		$toFromList = new \Example\View\CountryAccordionToFromList($this, $name, $model, $inGroup, $notInGroup);
		$form = new \PHPFUI\Form($this);
		$form->add($toFromList);
		$form->add(new \PHPFUI\Submit('Save'));

		$this->addBody($form);
		}

	}
