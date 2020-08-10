<?php

namespace PHPFUI\RefActor;

/**
 * A simple CSV file reader.
 *
 * Emulates an array of records (arrays), implimented as an Iterator, so can be used in a foreach statements.
 *
 * - If your CSV file has headers (the default), then the keys of the returned array will be the header values.
 * - You can also specify a different field delimiter, for example ("\t") for tabs.
 * - Use rewind to reset to the top of the file.
 * - The header record is NEVER returned as a record.  The first iteration will be the first record in the file, excluding the header record if specified.
 */
class CSVReader implements \Iterator
	{

	private array $current = [];
	private string $delimiter;
	private $fh = null;
	private string $fileName;
	private bool $headerRow;
	private array $headers = [];
	private int $index;

	public function __construct(string $fileName, bool $headerRow = true, string $delimiter = ',')
		{
		$this->fileName = $fileName;
		$this->headerRow = $headerRow;
		$this->delimiter = $delimiter;
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

	/**
	 * You can specify headers if your file does not include them.  The headers will be used as the key in the returned associative array for each record.
	 *
	 * @param array $headers of strings
	 */
	public function setHeaders(array $headers) : self
		{
		$this->headers = $headers;

		return $this;
		}

	public function valid() : bool
		{
		return $this->current && $this->fh;
		}

	private function closeFile() : self
		{
		if ($this->fh)
			{
			fclose($this->fh);
			$this->fh = null;
			}

		return $this;
		}

	}
