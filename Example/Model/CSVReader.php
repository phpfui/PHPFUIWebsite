<?php

namespace Example\Model;

class CSVReader implements \Iterator
	{

	private array $current = [];
	private $fh = null;
	private array $headers = [];
	private int $index = 0;

	public function __construct(private string $fileName, private bool $headerRow = true, private string $delimiter = ',')
		{
		$this->rewind();
		}

	public function __destruct()
		{
		$this->closeFile();
		}

	public function current() : array
		{
		return $this->current;
		}

	public function key() : int
		{
		return $this->index;
		}

	public function next() : void
		{
		$this->current = [];

		if ($this->fh)
			{
			$array = fgetcsv($this->fh, 0, $this->delimiter);

			if ($array)
				{
				++$this->index;

				if ($this->headers)
					{
					foreach ($this->headers as $index => $header)
						{
						if (isset($array[$index]))
							{
							$this->current[$header] = $array[$index];
							}
						else
							{
							break;
							}
						}
					}
				else
					{
					$this->current = $array;
					}
				}
			}
		}

	public function rewind() : void
		{
		$this->index = -1;
		$this->closeFile();
		$this->fh = @fopen($this->fileName, 'r');

		if ($this->fh && $this->headerRow)
			{
			$this->headers = fgetcsv($this->fh, 0, $this->delimiter);
			}
		$this->next();
		}

	public function setHeaders(array $headers) : void
		{
		$this->headers = $headers;
		}

	public function valid() : bool
		{
		return $this->current && $this->fh;
		}

	private function closeFile() : void
		{
		if ($this->fh)
			{
			fclose($this->fh);
			$this->fh = null;
			}
		}

	}
