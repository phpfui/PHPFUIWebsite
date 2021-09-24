<?php

namespace PHPFUI;

/**
 * Create a table that is sortedable
 */
class SortableTable extends \PHPFUI\Table
	{
	private $columnParameter = 'c';

	private $parameters = [];

	private $sortableColumns = [];

	private $sortedColumn = '';

	private $sortedOrder = '';

	private $sortParameter = 's';

	private $url;

	public function __construct()
		{
		parent::__construct();

		$this->url = $url = $_SERVER['REQUEST_URI'] ?? '';
		$queryStart = \strpos($this->url, '?');

		if ($queryStart)
			{
			$this->url = \substr($url, 0, $queryStart);
			\parse_str(\substr($url, $queryStart + 1), $this->parameters);
			}
		}

	/**
	 * Returns the base url of the current page, with no query parameters
	 */
	public function getBaseUrl() : string
		{
		return $this->url;
		}

	/**
	 * @return string a link that will sort the column in descending order
	 */
	public function getDownUrl(string $column) : string
		{
		$parameters = $this->parameters;
		$parameters[$this->columnParameter] = $column;
		$parameters[$this->sortParameter] = 'd';

		return $this->url . '?' . \http_build_query($parameters);
		}

	/**
	 * Get parameters parsed off the url
	 */
	public function getParsedParameters() : array
		{
		return $this->parameters;
		}

	/**
	 * @return string a link that will sort the column in ascending order
	 */
	public function getUpUrl(string $column) : string
		{
		$parameters = $this->parameters;
		$parameters[$this->columnParameter] = $column;
		$parameters[$this->sortParameter] = 'a';

		return $this->url . '?' . \http_build_query($parameters);
		}

	/**
	 * Set the column and sort direction parameter names.
	 */
	public function setParameters(string $column = 'c', string $sort = 's') : SortableTable
		{
		$this->columnParameter = $column;
		$this->sortParameter = $sort;

		return $this;
		}

	/**
	 * Set the valid sortable columns
	 */
	public function setSortableColumns(array $columns) : SortableTable
		{
		$this->sortableColumns = \array_flip($columns);

		return $this;
		}

	/**
	 * Set the current sorted column and sorted order.
	 */
	public function setSortedColumnOrder(string $column, string $order) : SortableTable
		{
		$order = \strtolower($order);

		if (! \in_array($order, ['a', 'd']))
			{
			$order = 'a';
			}

		$this->sortedOrder = $order;
		$this->sortedColumn = $column;

		return $this;
		}

	/**
	 * Get the correct header with sort indicator based on the column and title passed.
	 */
	protected function getSortHeader(string $column, string $title) : string
		{
		if (! isset($this->sortableColumns[$column]))
			{
			return $title;
			}

		$downUrl = $this->getDownUrl($column);
		$url = $upUrl = $this->getUpUrl($column);

		$icon = clone \PHPFUI\Language::getSortIcon();
		$icon->setLink($upUrl);

		if ($column == $this->sortedColumn)
			{
			if ('d' == $this->sortedOrder)
				{
				$icon = clone \PHPFUI\Language::getSortIcon('down');
				$icon->setLink($upUrl);
				}
			else
				{
				$icon = clone \PHPFUI\Language::getSortIcon('up');
				$url = $downUrl;
				$icon->setLink($downUrl);
				}
			}

		return $icon . new \PHPFUI\Link($url, $title, false);
		}
	}
