<?php

namespace Example\Model;

class State
	{
	/** @var array<array<string, string>> */
	private array $states = [];

	public function __construct()
		{
		// grab the data we need and store it off
		$csvReader = new \Example\Model\CSVReader($_SERVER['DOCUMENT_ROOT'] . '/states.tsv', true, "\t");

		foreach ($csvReader as $index => $state)
			{
			$state['index'] = $index;
			$this->states[$index] = $state;
			}
		}

	/** @return array<array<string, string>> */
	public function getFiltered(callable $filter) : array
		{
		$filtered = [];

		foreach ($this->states as $state)
			{
			if (\call_user_func($filter, $state['name']))
				{
				$filtered[] = $state;
				}
			}

		return $filtered;
		}

	/**
	 * @param array<int> $selected
	 *
	 * @return array<array<string, string>>
	 */
	public function getSelected(array $selected) : array
		{
		$group = [];

		foreach($selected as $index)
			{
			$group[] = $this->states[$index];
			}

		return $group;
		}

	/** @return array<string, string> */
	public function getState(int $index) : array
		{
		return $this->states[$index] ?? [];
		}

	/** @return array<array<string, string>> */
	public function getStates() : array
		{
		return $this->states;
		}
	}
