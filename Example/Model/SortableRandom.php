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
		// do the sort, data in Sequence ascending already, so only do if not that
		if ('s' != $column || 'a' != $sort)
			{
			// very much hard coded and not generic, but this is just a demo
			if ('s' == $column)
				{
				usort($this->data, function($a, $b) { return $b['s'] > $a['s']; });
				}
			elseif ('a' == $sort)
				{
				usort($this->data, function($a, $b) { return $b['r'] < $a['r']; });
				}
			else
				{
				usort($this->data, function($a, $b) { return $b['r'] > $a['r']; });
				}
			}
		}

	}
