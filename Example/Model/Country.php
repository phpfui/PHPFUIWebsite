<?php

namespace Example\Model;

class Country
	{

	private array $countries = [];

	public function __construct()
		{
		// grab the data we need and store it off
		$csvReader = new \Example\Model\CSVReader($_SERVER['DOCUMENT_ROOT'] . '/countries.csv', true);

		foreach ($csvReader as $index => $country)
			{
			$country['index'] = $index;
			$this->countries[$index] = $country;
			}
		}

	public function getCountries() : array
		{
		return $this->countries;
		}

	public function getCountry(int $index) : array
		{
		return $this->countries[$index] ?? [];
		}

	public function getFiltered(callable $filter) : array
		{
		$filtered = [];

		foreach ($this->countries as $country)
			{
			if (call_user_func($filter, $country['Country']))
				{
				$filtered[$country['Country'][0]][] = $country;
				}
			}

		return $filtered;
		}

	public function getSelected(array $selected) : array
		{
		$group = [];

		foreach($selected as $index)
			{
			$group[$this->countries[$index]['Country'][0]][] = $this->countries[$index];
			}
		ksort($group);

		return $group;
		}

	}
