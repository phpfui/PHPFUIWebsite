<?php

namespace PHPFUI\RefActor\Actor\Classes;

abstract class Base extends \PHPFUI\RefActor\Actor\Base
	{
	private string $baseDirectory;
	private array $classMap = [];
	private string $currentNamespace;

	public function __construct(string $csvFileName = 'classNames.csv', string $delimiter = ',')
		{
		$this->baseDirectory = getcwd();

		if (file_exists($csvFileName))
			{
			$csvReader = new \PHPFUI\RefActor\CSVReader($csvFileName, true, $delimiter);

			foreach ($csvReader as $row)
				{
				$fqn = $row['namespace'] . '\\' . $row['class_name'];
				$this->classMap[$fqn] = $row;
				}
			}
		else
			{
			throw new \Exception(__CLASS__ . ": File {$csvFileName} as not found in " . getcwd());
			}
		}

	public function getBaseDirectory() : string
		{
		return $this->baseDirectory;
		}

	public function getClassInfo(?string $fqn) : array
		{
		if ($fqn && isset($this->classMap[$fqn]))
			{
			return $this->classMap[$fqn];
			}

		return [];
		}

	public function getCorrectClassName(array $row) : string
		{
		if (! empty($row['new_class_name']))
			{
			return $row['new_class_name'];
			}

		return ucfirst($row['class_name']);
		}

	public function getCorrectFileName(array $row) : string
		{
		if (! empty($row['new_file_name']))
			{
			return $row['new_file_name'];
			}

		$file = $this->getCorrectNamespace($row) . '/' . $this->getCorrectClassName($row) . '.php';

		return str_replace('\\', '/', $file);
		}

	public function getCorrectNamespace(array $row) : string
		{
		if (! empty($row['new_namespace']))
			{
			return $row['new_namespace'];
			}

		// no namespace, use file path, minus last part
		if (empty($row['namespace']))
			{
			$namespace = str_replace('/', '\\', $row['file_name']);
			$parts = explode('\\', $namespace);
			array_pop($parts);
			$row['namespace'] = implode('\\', $parts);
			}

		$parts = explode('\\', $row['namespace']);

		foreach ($parts as $index => $part)
			{
			$parts[$index] = ucfirst($part);
			}

		return implode('\\', $parts);
		}

	public function getCurrentNamespace() : string
		{
		return $this->currentNamespace;
		}

	public function setBaseDirectory(string $baseDirectory) : self
		{
		$this->baseDirectory = $baseDirectory;

		return $this;
		}

	public function setCurrentNameSpace(string $currentNamespace) : self
		{
		$this->currentNamespace = $currentNamespace;

		return $this;
		}

	public function shouldProcessFile(string $file) : bool
		{
		$this->currentNamespace = '';

		return parent::shouldProcessFile($file);
		}

	}
