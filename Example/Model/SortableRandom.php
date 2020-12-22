<?php

namespace Example\Model;

class SortableRandom implements \countable
	{

	private array $data = [];

	public function __construct(int $count)
		{
		for ($i = 0; $i < $count; ++$i)
			{
			srand($i); // always use a known seed per position
			$this->data[] = ['s' => $i, 'r' => rand()];
			}
		}

	public function count() : int
		{
		return count($this->data);
		}

	public function getRow(int $index) : array
		{
		if ($index < 0 || $index >= count($this->data))
			{
			return [];
			}

		return $this->data[$index];
		}

	public function sort(string $column, string $sort) : void
		{
		// very much hard coded and not generic, but this is just a demo
		if ('s' == $column)
			{
			if ('a' == $sort)
				{
				usort($this->data, function($a, $b) { return $a['s'] <=> $b['s']; });
				}
			else
				{
				usort($this->data, function($a, $b) { return $b['s'] <=> $a['s']; });
				}
			}
		else
			{
			if ('a' == $sort)
				{
				usort($this->data, function($a, $b) { return $a['r'] <=> $b['r']; });
				}
			else
				{
				usort($this->data, function($a, $b) { return $b['r'] <=> $a['r']; });
				}
			}
		}

	}
