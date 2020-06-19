<?php

namespace Example\Model;

class State
	{

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

	public function getFiltered(callable $filter) : array
		{
		$filtered = [];

		foreach ($this->states as $state)
			{
			if (call_user_func($filter, $state['name']))
				{
				$filtered[] = $state;
				}
			}

		return $filtered;
		}

	public function getSelected(array $selected) : array
		{
		$group = [];

		foreach($selected as $index)
			{
			$group[] = $this->states[$index];
			}

		return $group;
		}

	public function getState(int $index) : array
		{
		return $this->states[$index] ?? [];
		}

	public function getStates() : array
		{
		return $this->states;
		}

//	if (strpos(' AEIOU', $state['name'][0]) )

	}
