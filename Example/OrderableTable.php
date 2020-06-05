<?php

namespace Example;

class OrderableTable extends \Example\Page
	{

	public function __construct()
		{
		parent::__construct();

		$this->addBody(new \PHPFUI\Header('Orderable Table'));
		$this->addBody('<p>Drag the first column to change the order of the table.</p>');
		$table = new \PHPFUI\OrderableTable($this);
		$csvReader = new \Example\Model\CSVReader($_SERVER['DOCUMENT_ROOT'] . '/countries.csv');
		$first = true;
		$table->setHeaders(['Country', 'Population', 'Land Area']);
		$taken = [];

		foreach ($csvReader as $row)
			{
			$first = $row['Country'][0];

			if (empty($taken[$first]))
				{
				$table->addRow($row);
				$taken[$first] = true;
				}
			}
		$this->addBody($table);
		}

	}
