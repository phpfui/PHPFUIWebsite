<?php

namespace Example\Model;

class Country
	{
	/** @var array<array<string, string>> */
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

	/** @return array<array<string, string>> */
	public function getCountries() : array
		{
		return $this->countries;
		}

	/** @return array<string, string> */
	public function getCountry(int $index) : array
		{
		return $this->countries[$index] ?? [];
		}

	/** @return array<array<string, string>> */
	public function getFiltered(callable $filter) : array
		{
		$filtered = [];

		foreach ($this->countries as $country)
			{
			if (\call_user_func($filter, $country['Country']))
				{
				$filtered[$country['Country'][0]][] = $country;
				}
			}

		return $filtered;
		}

	/**
	 * @param array<int> $selected
	 *
	 * @return array<string, array<string, string>>
	 */
	public function getSelected(array $selected) : array
		{
		$group = [];

		foreach($selected as $index)
			{
			$group[$this->countries[$index]['Country'][0]][] = $this->countries[$index];
			}
		\ksort($group);

		return $group;
		}
	}
