<?php

namespace Example;

class SortableTable extends \Example\Page
	{

	public function __construct()
		{
		parent::__construct();

		$this->addBody(new \PHPFUI\Header('SortableTable with Pagination'));

		$table = new \PHPFUI\SortableTable();

		// get the parameter we know we are interested in
		$parameters = $table->getParsedParameters();
		$p = (int)($parameters['p'] ?? 0);
		$limit = (int)($parameters['l'] ?? 25);
		$column = $parameters['c'] ?? 'Sequence';
		$sort = $parameters['s'] ?? 'a';

		$headers = ['s' => 'Sequence', 'r' => 'Random'];
		$table->setHeaders($headers)->setSortableColumns(array_keys($headers))->setSortedColumnOrder($column, $sort);

		$count = 10000;
		$lastPage = (int)($count / $limit);

		if ($p >= 0 && $p < $lastPage)
			{
			// generate data
			$model = new \Example\Model\SortableRandom($count);
			$model->sort($column, $sort);

			// add selected data to table
			$start = $p * $limit;
			$end = $start + $limit;

			for ($i = $start; $i < $end; ++$i)
				{
				$table->addRow($model->getRow($i));
				}

			$this->addBody($table);

			// set page to magic value for replacement
			$parameters['p'] = 'PAGE';
			$url = $table->getBaseUrl() . '?' . http_build_query($parameters);

			// Add the paginator to the bottom
			$paginator = new \PHPFUI\Pagination($p, $lastPage, $url);
			$paginator->center()->setFastForward(30)->setWindow(5);
			$this->addBody($paginator);
			$this->getFooterMenu()->addMenuItem(new \PHPFUI\MenuItem(new \PHPFUI\Input\LimitSelect($this, $limit)));
			}
		else
			{
			$this->addBody(new \PHPFUI\SubHeader('Page not found'));
			}
		}

	}
