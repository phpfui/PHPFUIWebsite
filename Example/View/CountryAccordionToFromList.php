<?php

namespace Example\View;

class CountryAccordionToFromList extends \PHPFUI\AccordionToFromList
	{
	public function __construct(\PHPFUI\Page $page, string $name, private \Example\Model\Country $model, array $inGroup, array $notInGroup)
		{
		$callback = [$this, 'callback', ];
		parent::__construct($page, $name, $inGroup, $notInGroup, 'index', $callback);
		$this->setInName('Starts with Vowel');
		$this->setOutName('Starts with Consonant');
		}

	protected function callback(string $fieldName, string $index, $userData, string $type) : string
		{
		$country = $this->model->getCountry($userData);

		return $country['Country'] . new \PHPFUI\Input\Hidden("{$fieldName}-{$type}[]", $userData);
		}
	}
