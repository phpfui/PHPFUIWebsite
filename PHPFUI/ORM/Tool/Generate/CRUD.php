<?php

namespace PHPFUI\ORM\Tool\Generate;

class CRUD extends Base
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

		$classDefinition = <<<'PHP'
<?php

namespace ~~RECORD_NAMESPACE~~\Definition;

/**
 * Autogenerated. Do not modify. Modify SQL table, then generate with \PHPFUI\ORM\Tool\Generate\CRUD class.
 *~~FIELD_COMMENTS~~
 */
abstract class ~~CLASS~~ extends \PHPFUI\ORM\Record
	{
	protected static bool $autoIncrement = ~~AUTO_INCREMENT~~;

	/** @var array<string, array<mixed>> */
	protected static array $fields = [
		// MYSQL_TYPE, PHP_TYPE, LENGTH, ALLOWS_NULL, DEFAULT
~~FIELD_ARRAY~~	];

	/** @var array<string> */
	protected static array $primaryKeys = ~~PRIMARY_KEY~~;

	protected static string $table = '~~TABLE_NAME~~';
	}

PHP;

		$model = <<<'PHP'
<?php

namespace ~~RECORD_NAMESPACE~~;

class ~~CLASS~~ extends \~~RECORD_NAMESPACE~~\Definition\~~CLASS~~
	{
	}

PHP;

		$tableModel = <<<'PHP'
<?php

namespace ~~TABLE_NAMESPACE~~;

class ~~CLASS~~ extends \PHPFUI\ORM\Table
	{
	protected static string $className = \~~RECORD_NAMESPACE~~\~~CLASS~~::class;
	}

PHP;

		$sourceVars = ['~~CLASS~~', '~~TABLE_NAME~~', '~~FIELD_COMMENTS~~', '~~FIELD_ARRAY~~', '~~PRIMARY_KEY~~', '~~AUTO_INCREMENT~~', '~~RECORD_NAMESPACE~~', '~~TABLE_NAMESPACE~~'];

		$fieldArray = '';
		$autoIncrement = 'false';

		foreach ($fields as $field)
			{
			$fieldArray .= "\t\t" . $this->getLine($field) . "\n";

			if ($field->autoIncrement)
				{
				$autoIncrement = 'true';
				}
			}

		$fieldComments = '';
		$commentedFields = [];

		foreach ($fields as $field)
			{
			$comment = $this->getComment($field, $commentedFields);

			if ($comment)
				{
				$fieldComments .= "\n * @property {$comment}";
				}
			}

		$ucTable = \PHPFUI\ORM::getBaseClassName($table);
		$keys = '[';

		foreach ($this->getPrimaryKeys($table) as $key)
			{
			$keys .= "'{$key}', ";
			}
		$keys .= ']';
		$replaceVars = [$ucTable, $table, $fieldComments, $fieldArray, $keys, $autoIncrement, \PHPFUI\ORM::$recordNamespace, \PHPFUI\ORM::$tableNamespace, ];

		// Always make definition file
		$basePath = \PHPFUI\ORM::getRecordNamespacePath() . '/Definition';

		if (! \is_dir($basePath))
			{
			\mkdir($basePath, 0777, true);
			}
		\file_put_contents($basePath . '/' . $ucTable . '.php', \str_replace($sourceVars, $replaceVars, $classDefinition));

		// Only make model file if no model
		$modelPath = \PHPFUI\ORM::getRecordNamespacePath() . '/' . $ucTable . '.php';

		if (! \file_exists($modelPath))
			{
			\file_put_contents($modelPath, \str_replace($sourceVars, $replaceVars, $model));
			}

		// Only make table file if no file
		$tablePath = \PHPFUI\ORM::getTableNamespacePath();

		if (! \is_dir($tablePath))
			{
			\mkdir($tablePath, 0777, true);
			}
		$tablePath .= '/' . $ucTable . '.php';

		if (! \file_exists($tablePath))
			{
			\file_put_contents($tablePath, \str_replace($sourceVars, $replaceVars, $tableModel));
			}

		return true;
		}

	protected function getLine(\PHPFUI\ORM\Schema\Field $field) : string
		{
		$retVal = $this->quote($field->name) . ' => [';
		$retVal .= $this->quoteLine(\str_replace("'", '"', $field->type));
		$type = $field->type;
		$length = $this->getTypeLength($type);
		$retVal .= $this->quoteLine($type);
		$retVal .= $this->line($length);
		$allowNulls = $field->nullable;
		$defaultValue = null;

		switch ($type)
			{
			case 'int':
				if (null !== $field->defaultValue)
					{
					$defaultValue = 'NULL' !== $field->defaultValue ? (int)$field->defaultValue : 'NULL';
					}

				break;

			case 'bool':
			case 'datetime':
			case 'string':
				if ('NULL' === $field->defaultValue || 'CURRENT_TIMESTAMP' == $field->defaultValue || 'CURRENT_DATE' == $field->defaultValue)
					{
					$defaultValue = 'NULL';
					}
				elseif (\str_contains($field->defaultValue ?? '', "'") || \str_contains($field->defaultValue ?? '', '"'))
					{
					$defaultValue = $field->defaultValue;
					}
				elseif (null !== $field->defaultValue)
					{
					$defaultValue = "'{$field->defaultValue}'";
					}

				break;

			case 'float':
				if (null !== $field->defaultValue)
					{
					$defaultValue = 'NULL' !== $field->defaultValue ? (float)$field->defaultValue : 'NULL';
					}

				break;
			}

		if ('boolean' == \gettype($field->defaultValue))
			{
			$defaultValue = (int)$field->defaultValue;
			}

		$retVal .= $this->line($allowNulls ? 'true' : 'false');

		if (null !== $defaultValue)
			{
			$retVal .= $this->line($defaultValue);
			}
		$retVal .= '],';

		return $retVal;
		}

	private function getComment(\PHPFUI\ORM\Schema\Field $field, array &$commentedFields) : ?string
		{
		$fieldName = $field->name;

		if (isset($commentedFields[$fieldName]))
			{
			return null;
			}
		$commentedFields[$fieldName] = true;
		$mySQLType = \str_replace("'", '', $field->type);
		$phpType = $mySQLType;
		$this->getTypeLength($phpType);
		$null = $field->nullable ? '?' : '';

		$block = $null . $phpType . ' $' . $fieldName . ' MySQL type ' . $mySQLType;

		if (\str_ends_with($fieldName, \PHPFUI\ORM::$idSuffix))
			{
			$var = \substr($fieldName, 0, \strlen($fieldName) - 2);

			if (! isset($commentedFields[$var]))
				{
				$table = \PHPFUI\ORM::getBaseClassName($var);
				$className = '\\' . \PHPFUI\ORM::$recordNamespace . "\\{$table}";

				if (\class_exists($className))
					{
					$block .= "\n * @property \\~~RECORD_NAMESPACE~~\\" . $table . ' $' . $var . ' related record';
					}
				}
			$commentedFields[$var] = true;
			}

		return $block;
		}
	}
