<?php

namespace Example;

class AutoComplete extends Page
	{

	public function __construct()
		{
		parent::__construct();

		$this->addBody(new \PHPFUI\Header('Auto Complete Country Example'));

		$this->addBody('<b>AutoComplete</b> offers a backend callback that can be leveraged for various user experiences. ');
		$this->addBody(new \PHPFUI\Link('http://' . $_SERVER['SERVER_NAME'] . '/countries.csv', 'Data Source'));
		$form = new \PHPFUI\Form($this);
		$control = new \PHPFUI\Input\AutoComplete($this, [$this, 'callback',], 'text', 'country', 'Pick a country, any country');
		$control->setToolTip('Start typing to find a country');
		$form->add($control);
		$form->add(new \PHPFUI\Submit('Save'));

		$this->addBody($form);
		}

	public function callback(array $parameters) : array
		{
		$returnValue = [];

		if (empty($parameters['save']))
			{
			$csvReader = new \Example\Model\CSVReader($_SERVER['DOCUMENT_ROOT'] . '/countries.csv');
			$names = explode(' ', trim($parameters['AutoComplete']));

			foreach ($csvReader as $row)
				{
				$pos = 0;
				$country = $row['Country'];

				foreach ($names as $part)
					{
					$pos = stripos($country, $part, $pos);

					if (false === $pos)
						{
						break;
						}
					}

				if (false !== $pos)
					{
					$returnValue[] = ['value' => $country, 'data' => $country];
					}
				}
			}
		else
			{
			// save $parameters['AutoComplete'];
			}

		return ['suggestions' => $returnValue];
		}

	}
