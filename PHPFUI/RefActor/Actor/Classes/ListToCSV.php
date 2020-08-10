<?php

namespace PHPFUI\RefActor\Actor\Classes;

class ListToCSV extends \PHPFUI\RefActor\Actor\Classes\Base
	{
	private string $delimiter;

	private $fileHandle;

	public function __construct(string $csvFileName = 'classNameList.csv', string $delimiter = ',')
		{
		$this->delimiter = $delimiter;

		if (file_exists($csvFileName))
			{
			$this->fileHandle = fopen($csvFileName, 'a+');
			}
		else
			{
			$this->fileHandle = fopen($csvFileName, 'w');
			$headers = ['class_name', 'namespace', 'file_name', 'new_class_name', 'new_namespace', 'new_file_name'];
			fputcsv($this->fileHandle, $headers, $this->delimiter);
			}
		}

	public function enterNode(\PhpParser\Node $node) : void
		{
		if ($node instanceof \PhpParser\Node\Stmt\Namespace_)
			{
			$this->setCurrentNamespace(implode('\\', $node->name->parts));

			return;
			}

		if ($node instanceof \PhpParser\Node\Stmt\Class_)
			{
			$row = [$node->name->name, $this->getCurrentNamespace(), $this->getCurrentFile()];
			fputcsv($this->fileHandle, $row, $this->delimiter);
			}


		}

	public function getDescription() : string
		{
		return 'Finds all classes and outputs class name, namespace and file path to a csv file for analysis';
		}

	public function getTestCases() : array
		{
		$testCases = [];

		///////// Test Case 1 ///////////////////
		$original = <<<'PHP'
<?php
class SomeClass
	{
	public function someMethod() : string
		{
		return 'something';
		}
	}

class SomeOtherClass
	{
	public function someMethod() : string
		{
		return 'something';
		}
	}
PHP;

		$testCases[] = [$original, ''];

		return $testCases;
		}

	}
