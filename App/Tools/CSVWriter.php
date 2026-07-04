<?php

namespace App\Tools;

class CSVWriter
	{
	use \App\DB\StrictGet;
	use \App\DB\StrictSet;

	private bool $headerRow = false;

	private $out;

	public function __construct(string $filename, private string $delimiter = ',', private bool $download = true)
		{
		if ($this->download)
			{
			\header('Content-Type: application/csv');
			\header('Content-Disposition: inline; filename="' . $filename . '"');
			\header('Cache-Control: private, max-age=0, must-revalidate');
			\header('Pragma: public');
			$this->out = \fopen('php://output', 'w');
			}
		else
			{
			$this->out = \fopen($filename, 'w');
			}
		}

	public function __destruct()
		{
		\fclose($this->out);

		if ($this->download)
			{
			exit;
			}
		}

	public function addHeaderRow(bool $headerRow = true) : self
		{
		$this->headerRow = true;

		return $this;
		}

	public function outputRow(array $row) : self
		{
		if ($this->headerRow)
			{
			$this->headerRow = false;
			\fputcsv($this->out, \array_keys($row), $this->delimiter);
			}

		\fputcsv($this->out, $row, $this->delimiter);

		return $this;
		}
	}
