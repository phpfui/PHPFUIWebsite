<?php

namespace PHPFUI\ORM\Tool\Generate;

class Validator extends Base
	{
	public function generate(string $table) : bool
		{
		$fields = \PHPFUI\ORM::describeTable($table);

		if (! \count($fields))
			{
			return false;
			}

		// sort fields so table order is ignored on update
		\usort($fields, [$this, 'nameSort']);

		$ucTable = \PHPFUI\ORM::getBaseClassName($table);

		$keys = $this->getPrimaryKeys($table);

		$classDefinition = <<<'PHP'
<?php

namespace ~~RECORD_NAMESPACE~~\Validation;

/**
 * Autogenerated. Do not modify. Modify SQL table, then run oneOffScripts\generateValidators.php table_name
 */
class ~~CLASS~~ extends \PHPFUI\ORM\Validator
	{

	/** @var array<string, array<string>> */
	public static array $validators = [
~~FIELD_ARRAY~~		];

	public function __construct(\~~RECORD_NAMESPACE~~\~~CLASS~~ $record)
		{
		parent::__construct($record);
		}

	}

PHP;

		$sourceVars = ['~~CLASS~~', '~~FIELD_ARRAY~~', '~~RECORD_NAMESPACE~~'];

		$fieldArray = '';

		foreach ($fields as $field)
			{
			$line = $this->getLine($field);

			if ($line)
				{
				$fieldArray .= "\t\t{$line}\n";
				}
			}

		$replaceVars = [$ucTable, $fieldArray, \PHPFUI\ORM::$recordNamespace, ];

		$source = \str_replace($sourceVars, $replaceVars, $classDefinition);

		// Always make definition file
		$basePath = \PHPFUI\ORM::getRecordNamespacePath() . '/Validation';

		if (! \is_dir($basePath))
			{
			\mkdir($basePath, 0777, true);
			}
		$filePath = $basePath . '/' . $ucTable . '.php';

		if (! \file_exists($filePath))
			{
			\file_put_contents($filePath, $source);
			}

		return true;
		}

	protected function getLine(\PHPFUI\ORM\Schema\Field $field) : string
		{
		$type = $field->type;
		$length = $this->getTypeLength($type);
		$validators = [];

		if (! $field->nullable)
			{
			$validators[] = 'required';
			}

		switch($type)
			{
			case 'bool':
				$validators[] = 'minvalue:0';
				$validators[] = 'maxvalue:1';

				break;

			case 'float':
				$validators[] = 'number';

				break;

			case 'int':
				$validators[] = 'integer';

				break;

			case 'string':
				if ($length)
					{
					$validators[] = 'maxlength';
					}

				break;
			}

		if (false !== \strpos($field->type, 'unsigned'))
			{
			$validators[] = 'minvalue:0';
			}

		switch($field->type)
			{
			case 'timestamp':
				$validators[] = 'datetime';

				break;

			case 'date':
			case 'time':
			case 'datetime':
				$validators[] = $field->type;

				break;
			}

		if (0 === \strpos($field->type, 'enum('))
			{
			$validators[] = \str_replace(['(', "'", ')'], [':', '', ''], $field['Type']);
			}

		$retVal = '';

		if ($validators)
			{
			$retVal .= $this->quote($field->name) . " => ['";
			$retVal .= \implode("', '", $validators);
			$retVal .= "'],";
			}

		return $retVal;
		}
	}
