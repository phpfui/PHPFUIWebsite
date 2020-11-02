<?php

namespace PHPFUI\RefActor\Actor;

class FindAndReplace extends \PHPFUI\RefActor\Actor\Base
	{

	private array $find = [];
	private array $replace = [];

	public function __construct(string $csvFileName = 'FindAndReplace.csv', string $delimiter = ',')
		{
		$this->baseDirectory = getcwd();

		if (file_exists($csvFileName))
			{
			$sourceChars = ['\R', '\N', '\T'];
			$phpChars = [chr(13), "\n", "\t"];
			$csvReader = new \PHPFUI\RefActor\CSVReader($csvFileName, true, $delimiter);

			foreach ($csvReader as $row)
				{
				$this->find[] = str_replace($sourceChars, $phpChars, $row['find']);
				$this->replace[] = str_replace($sourceChars, $phpChars, $row['replace']);
				}
			}
		else
			{
			throw new \Exception(__CLASS__ . ": File {$csvFileName} as not found in " . getcwd());
			}
		}

	public function getDescription() : string
		{
		return 'Find and replace strings from FindAndReplace.csv file';
		}

	public function getTestCases() : array
		{
		$testCases = [];

///////////// Test Case 0 ///////////////////
		$original = <<<'PHP'
PHP;

		$modified = <<<'PHP'
PHP;
		$testCases[] = [$original, $modified];

		return $testCases;
		}

	public function shouldProcessFile(string $file) : bool
		{
		parent::shouldProcessFile($file);

		if (! strpos($file, '.php'))
			{
			return false;
			}

		$PHP = file_get_contents($file);
		$newPHP = str_replace($this->find, $this->replace, $PHP);

		if ($newPHP != $PHP)
			{
			$this->refActor->log('info', 'Found and replaced ' . $file);
			file_put_contents($file, $newPHP);
			}

		return false;
		}

	}
