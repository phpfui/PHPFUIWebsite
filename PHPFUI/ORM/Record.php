<?php

namespace PHPFUI\ORM;

/**
 * Basic CRUD class implementing insert (create), read, update and delete methods.
 *
 * Classes that derive from **\PHPFUI\ORM\Record** must define the static members
 *
 * There is only one record associated with a single CRUD object.
 *
 * Members of the class can be accessed by their database table field name, case sensitive.  On setting a member, it will be cast to the correct PHP type for the field.
 */
abstract class Record extends DataObject
	{
	public const ALLOWS_NULL_INDEX = 3;

	public const DEFAULT_INDEX = 4;

	public const KEY_INDEX = 5;

	public const LENGTH_INDEX = 2;

	public const MYSQL_TYPE_INDEX = 0;

	public const PHP_TYPE_INDEX = 1;

	protected static bool $autoIncrement = false;

	protected static array $fields = [];

	protected static array $primaryKeys = [];

	protected static array $relationships = [];

	protected static array $displayTransforms = [];

	protected static array $setTransforms = [];

	protected static string $table = '';

	protected bool $empty = true;

	protected bool $loaded = false;

	protected string $validator = '';

	/**
	 * Construct a CRUD object
	 *
	 * ##### Possible $parameter types and values
	 * - **int** primary key value, will load object values if the primary key value exists
	 * - **string** primary key value, will load object values if the primary key value exists
	 * - **array** object will be initialized to these values, but not read from the database
	 * - **null** (default) constructs an empty object
	 */
	public function __construct(int|array|null|string $parameter = null)
		{
		$type = \gettype($parameter);

		switch ($type)
		  {
			case 'string':

				if (1 == \count(static::$primaryKeys))
					{
					$this->read($parameter);
					}
				else
					{
					throw new \PHPFUI\ORM\Exception(static::class . ' has no string primary key');
					}

				break;

			case 'integer':

				if (1 == \count(static::$primaryKeys) && 'int' == static::$fields[\array_key_first(static::$primaryKeys)][self::PHP_TYPE_INDEX])
					{
					$this->read($parameter);
					}
				else
					{
					throw new \PHPFUI\ORM\Exception(static::class . ' does not have an integer primary key');
					}

				break;


			case 'array':

				$this->current = [];
				$this->setFrom($parameter);

				break;


			default:

				$this->setEmpty();

				break;

			}
		}

	/**
	 * Allows for $object->field syntax
	 *
	 * Unset fields will return null
	 */
	public function __get(string $field) : mixed
		{
		if (isset(static::$fields[$field]))
			{
			return $this->displayTransform($field);
			}

		$relationship = static::$relationships[$field] ?? false;

		if ($relationship)
			{
			$childTable = $this->getChildTable($field);

			if (! $childTable)
				{
				$childTable = $this->getTable($field);
				}

			if ($childTable)
				{
				$condition = new \PHPFUI\ORM\Condition();

				foreach (static::$primaryKeys as $primaryKey => $junk)
					{
					$condition->and($primaryKey, $this->current[$primaryKey]);
					}
				$childTable->setWhere($condition);

				if (\is_callable($relationship))
					{
					$relationship($childTable, $this->current);
					}

				return $childTable->getRecordCursor();
				}
			}

		$id = $field . \PHPFUI\ORM::$idSuffix;

		if (isset(static::$fields[$id]))
			{
			$type = '\\' . \PHPFUI\ORM::$recordNamespace . '\\' . \ucfirst($field);

			return new $type($this->current[$id] ?? 0);
			}

		throw new \PHPFUI\ORM\Exception(static::class . "::{$field} is not a valid field");
		}

	/**
	 * Allows for empty($object->field) to work correctly
	 */
	public function __isset(string $field) : bool
		{
		if (\array_key_exists($field, $this->current) || \array_key_exists($field . \PHPFUI\ORM::$idSuffix, $this->current))
			{
			return true;
			}

		throw new \PHPFUI\ORM\Exception(static::class . "::{$field} is not a valid field");
		}

	/**
	 * Allows for $object->field = $x syntax
	 *
	 * @return mixed  returns $value so you can string together assignments
	 */
	public function __set(string $field, $value)
		{
		$id = $field . \PHPFUI\ORM::$idSuffix;

		if (isset(static::$fields[$id]) && $value instanceof \PHPFUI\ORM\Record)
			{
			$haveType = $value->getTableName();

			if ($value instanceof \PHPFUI\ORM\Record && $field == $haveType)
				{
				if (empty($value->{$id}))
					{
					$this->empty = false;
					$this->current[$id] = $value->insert();
					}
				else
					{
					$this->empty = false;
					$this->current[$id] = $value->{$id};
					}

				return $value;
				}

			$haveType = \ucfirst($haveType);
			$recordNamespace = \PHPFUI\ORM::$recordNamespace;
			$message = static::class . "::{$field} is of type \\{$recordNamespace}\\" . \ucfirst($field) . " but being assigned a type of \\{$recordNamespace}\\{$haveType}}";
			\PHPFUI\ORM::log(\Psr\Log\LogLevel::ERROR, $message);

			throw new \PHPFUI\ORM\Exception($message);
			}

		$this->validateFieldExists($field);

		if (isset(static::$setTransforms[$field]))
			{
			$value = static::$setTransforms[$field]($value);
			}

		$expectedType = static::$fields[$field][self::PHP_TYPE_INDEX];
		$haveType = \get_debug_type($value);

		if (null !== $value && $haveType != $expectedType)
			{
			//throw new \PHPFUI\ORM\Exception($message);
			$message = static::class . "::{$field} is of type {$expectedType} but being assigned a type of {$haveType}";
			\PHPFUI\ORM::log(\Psr\Log\LogLevel::ERROR, $message);
			// do the conversion
			switch ($expectedType)
				{
				case 'string':
					$value = (string)$value;

					break;

				case 'int':
					$value = (int)$value;

					break;

				case 'float':
					$value = (float)$value;

					break;

				case 'bool':
					$value = (bool)$value;

					break;
				}
			}
		$this->empty = false;
		$this->current[$field] = $value;

		return $value;
		}

	/**
	 * Add a transform for set.  Callback is passed value.
	 */
	public function addSetTransform(string $field, callable $callback) : static
		{
		static::$setTransforms[$field] = $callback;

		return $this;
		}

	/**
	 * Add a transform for get.  Callback is passed value.
	 */
	public function addDisplayTransform(string $field, callable $callback) : static
		{
		static::$displayTransforms[$field] = $callback;

		return $this;
		}

	public function offsetGet(mixed $offset) : mixed
		{
		$this->validateFieldExists($offset);

		return $this->current[$offset] ?? null;
		}

	/**
	 * clean is called before insert or update. Override to impliment cleaning on a specific record
	 */
	public function clean() : static
		{
		return $this;
		}

	/**
	 * Alias of insert
	 */
	public function create() : int
		{
		return $this->insert();
		}

	/**
	 * Deletes the record (and children) currently pointed to by the data
	 *
	 * @return bool  true if record deleted
	 */
	public function delete() : bool
		{
		// delete child records for primary key only
		if (1 == \count(static::$primaryKeys))
			{
			$primaryKey = \array_key_first(static::$primaryKeys);

			foreach (static::$relationships as $relationship => $status)
				{
				$childTable = $this->getChildTable($relationship);

				if ($childTable)
					{
					$childTable->setWhere(new \PHPFUI\ORM\Condition($primaryKey, $this->current[$primaryKey]));
					$childTable->delete();
					}
				}
			}

		$input = [];
		$table = static::$table;
		$where = $this->buildWhere($this->current, $input);

		if (empty($input) || empty($where))
			{
			return false;
			}

		$sql = "delete from `{$table}` " . $where;

		return \PHPFUI\ORM::execute($sql, $input);
		}

	/**
	 * @return bool  true if empty (default values)
	 */
	public function empty() : bool
		{
		return $this->empty;
		}

	/**
	 * @return bool  true if table has an auto increment primary key
	 */
	public function getAutoIncrement() : bool
		{
		return static::$autoIncrement;
		}

	/**
	 * @return array  of fields properties indexed by field name
	 */
	public static function getFields() : array
		{
		return static::$fields;
		}

	/**
	 * @return int Maximium valid field length
	 */
	public function getLength(string $field) : int
		{
		$this->validateFieldExists($field);

		return static::$fields[$field][self::LENGTH_INDEX];
		}

	//	ALLOWS_NULL_INDEX = 3;
	//	DEFAULT_INDEX = 4;
	//	KEY_INDEX = 5;
	//	MYSQL_TYPE_INDEX = 0;
	//	PHP_TYPE_INDEX = 1;

	/**
	 * @return array  primary keys
	 */
	public static function getPrimaryKeys() : array
		{
		return static::$primaryKeys;
		}

	/**
	 * @return array<string, string>  indexed by primary keys containing the key value
	 */
	public function getPrimaryKeyValues() : array
		{
		$retVal = [];

		foreach (static::$primaryKeys as $key => $junk)
			{
			$retVal[$key] = $this->current[$key] ?? null;
			}

		return $retVal;
		}

	/**
	 * @return string  table name, case sensitive
	 */
	public static function getTableName() : string
		{
		return static::$table;
		}

	/**
	 * Get the record relationships to mostly children
	 *
	 * @return array<string>
	 */
	public static function getRelationships() : array
		{
		return \array_keys(static::$relationships);
		}

	/**
	 * Inserts current data into table
	 *
	 * @return int | bool inserted id if auto increment, true on insertion if not auto increment or false on error
	 */
	public function insert() : int | bool
		{
		return $this->privateInsert(false);
		}

	/**
	 * Inserts current data into table or updates if duplicate key
	 *
	 * @return int | bool inserted id if auto increment, true on insertion if not auto increment or false on error
	 */
	public function insertOrUpdate() : int | bool
		{
		return $this->privateInsert(true);
		}

	/**
	 * Load first from SQL query
	 */
	public function loadFromSQL(string $sql, array $input = []) : bool
		{
		$this->current = \PHPFUI\ORM::getRow($sql, $input);

		if (! $this->current)
			{
			$this->setEmpty();

			return false;
			}
		$this->empty = false;
		$this->loaded = true;

		// cast to correct values as ints, floats, etc are read in from PDO as strings
		foreach (static::$fields as $field => $row)
			{
			switch ($row[1])
				{
				case 'int':
					if (\array_key_exists($field, $this->current))
						{
						$this->current[$field] = (int)$this->current[$field];
						}

					break;

				case 'float':
					if (\array_key_exists($field, $this->current))
						{
						$this->current[$field] = (float)$this->current[$field];
						}

					break;

				case 'bool':
					if (\array_key_exists($field, $this->current))
						{
						$this->current[$field] = (bool)$this->current[$field];
						}

					break;
				}
			}

		return true;
		}

 /**
  * Read a record from the db. If more than one match, only the first is loaded.
  *
  * @param array|int|string $fields if int|string, primary key, otherwise a key => value array to match on. Multiple field value pairs are anded into the where clause.
  *
  * @return bool  true if a record found
  */
	public function read(array|int|string $fields) : bool
		{
		$input = [];
		$table = static::$table;
		$sql = "select * from `{$table}` " . $this->buildWhere($fields, $input);

		return $this->loadFromSQL($sql, $input);
		}

	/**
	 * @return bool  true if loaded from the disk
	 */
	public function loaded() : bool
		{
		return $this->loaded;
		}

	/**
	 * Reload the object from the database.  Unsaved fields are discarded.
	 */
	public function reload() : bool
		{
		$keys = [];

		foreach (static::$primaryKeys as $key => $junk)
			{
			if (\array_key_exists($key, $this->current))
				{
				$keys[$key] = $this->current[$key];
				}
			}

		return $this->read($keys);
		}

	/**
	 * Sets all fields to default values
	 */
	public function setEmpty() : static
		{
		$this->empty = true;
		$this->loaded = false;
		$this->current = [];

		foreach (static::$fields as $field => $description)
			{
			$this->current[$field] = $description[self::DEFAULT_INDEX];
			}

		return $this;
		}

	/**
	 * Sets the object to values in the array.  Invalid array values are ignored.
	 *
	 * @param bool $loaded set to true if you want to simulated being loaded from the db.
	 */
	public function setFrom(array $values, bool $loaded = false) : static
		{
		$this->loaded = $loaded;

		foreach ($values as $field => $value)
			{
			if (isset(static::$fields[$field]))
				{
				$this->empty = false;

				if (isset(static::$setTransforms[$field]))
					{
					$value = static::$setTransforms[$field]($value);
					}
				$this->current[$field] = $value;
				}
			}

		return $this;
		}

	/**
	 * Update the database with the current record based on table primary key
	 */
	public function update() : bool
		{
		$this->clean();
		$table = static::$table;

		$sql = "update `{$table}` set ";
		$input = [];
		$keys = [];
		$comma = '';
		$dateTimes = ['timestamp', 'date', 'time', 'datetime'];

		foreach ($this->current as $field => $value)
			{
			if (isset(static::$fields[$field]))
				{
				if (! isset(static::$primaryKeys[$field]))
					{
					if (empty($value) && \in_array(static::$fields[$field][self::MYSQL_TYPE_INDEX], $dateTimes))
						{
						$value = null;
						}
					$input[] = $value;
					$sql .= $comma . '`' . $field . '`=?';
					$comma = ',';
					}
				else
					{
					$keys[$field] = $value;
					}
				}
			}

		if (empty($comma))
			{
			return false;
			}

		$where = $this->buildWhere($keys, $input);

		if (empty($where))
			{
			return false;
			}

		return \PHPFUI\ORM::execute($sql . $where, $input);
		}

	/**
	 * Transform a field for display
	 */
	public function displayTransform(string $field, $value = null)
		{
		if (null === $value)
			{
			$value = $this->current[$field] ?? null;
			}

		if (! isset(static::$displayTransforms[$field]))
			{
			return $value;
			}

		return static::$displayTransforms[$field]($value);
		}

	/**
	 * Return array of validation errors indexed by offending field containing an array of translated errors
	 */
	public function validate(string $optionalMethod = '', ?self $originalRecord = null) : array
		{
		$parts = \explode('\\', static::class);
		$baseName = \array_pop($parts);
		$class = $this->validator ?: 'App\\Record\\Validation\\' . $baseName;

		if (! \class_exists($class))
			{
			return [];
			}

		$validator = new $class($this, $originalRecord);
		$validator->validate($optionalMethod);

		return $validator->getErrors();
		}

	/**
	 * Set a custom validator class
	 */
	public function setCustomValidator(string $className) : static
		{
		$this->validator = $className;

		return $this;
		}

	public function blankDate(?string $date) : string
		{
		if ('1000-01-01' < $date)
			{
			return '';
			}

		return $date ?? '';
		}

	/**
	 * Converts the field to all upper case
	 */
	protected function cleanUpperCase(string $field) : static
		{
		if (isset($this->current[$field]))
			{
			$this->current[$field] = \strtoupper($this->current[$field]);
			}

		return $this;
		}

	/**
	 * Converts the field to all lower case
	 */
	protected function cleanLowerCase(string $field) : static
		{
		if (isset($this->current[$field]))
			{
			$this->current[$field] = \strtolower($this->current[$field]);
			}

		return $this;
		}

	/**
	 * removes all non-digits (0-9 and -) from string representation of a number
	 */
	protected function cleanNumber(string $field) : static
		{
		if (isset($this->current[$field]))
			{
			$temp = (int)$this->current[$field];
			$this->current[$field] = "{$temp}";
			}

		return $this;
		}

	/**
	 * removes all non-digits (0-9, . and -)
	 */
	protected function cleanFloat(string $field, int $decimalPoints = 2) : static
		{
		if (isset($this->current[$field]))
			{
			$this->current[$field] = \number_format((float)$this->current[$field], $decimalPoints);
			}

		return $this;
		}

	/**
	 * removes all non-digits (0-9) and regex separators
	 */
	protected function cleanPhone(string $field, string $regExSeparators = '\\-\\.') : static
		{
		if (isset($this->current[$field]))
			{
			$this->current[$field] = \preg_replace("/[^0-9{$regExSeparators}]/", '', \strtolower($this->current[$field]));
			}

		return $this;
		}

	/**
	 * Properly capitalizes proper names if in single case. Mixed case strings are not altered.
	 */
	protected function cleanProperName(string $field) : static
		{
		if (isset($this->current[$field]))
			{
			$text = $this->current[$field];
			$lower = \strtolower($text);
			$upper = \strtoupper($text);

			if ($lower != $text && $upper != $text)
				{
				return $this;
				}
			$this->current[$field] = \ucwords($lower);
			}

		return $this;
		}

	/**
	 * Lowercases and strips invalid email characters.  Does not validate email address.
	 */
	protected function cleanEmail(string $field) : static
		{
		if (isset($this->current[$field]))
			{
			$this->current[$field] = \preg_replace('/[^a-z0-9\._\-@!#\$%&\'\*\+=\?\^`\{\|\}~]/', '', \strtolower($this->current[$field]));
			}

		return $this;
		}

	protected function timeStamp(?int $timeStamp) : string
		{
		if (empty($timeStamp))
			{
			return '';
			}

		return \date('Y-m-d g:i a', $timeStamp);
		}

	private function getChildTable(string $relationship) : ?\PHPFUI\ORM\Table
		{
		$children = \str_ends_with($relationship, 'Children');

		if (! $children)
			{
			return null;
			}
		$recordType = \substr($relationship, 0, \strlen($relationship) - 8);
		$type = '\\' . \PHPFUI\ORM::$tableNamespace . '\\' . $recordType;

		return new $type();
		}

	private function getTable(string $tableName) : ?\PHPFUI\ORM\Table
		{
		$className = '\\' . \PHPFUI\ORM::$tableNamespace . '\\' . $tableName;

		if (! \class_exists($className))
			{
			return null;
			}

		return new $className();
		}

	/**
	 * Inserts current data into table
	 *
	 * @return int | bool inserted id if auto increment, true on insertion if not auto increment or false on error
	 */
	private function privateInsert(bool $updateOnDuplicate) : int | bool
		{
		$this->clean();
		$table = static::$table;

		$sql = "insert into `{$table}` (";
		$values = [];
		$whereInput = $input = [];
		$comma = '';

		foreach ($this->current as $key => $value)
			{
			if (isset(static::$fields[$key]))
				{
				$definition = static::$fields[$key];
				// MYSQL_TYPE, PHP_TYPE, LENGTH, NULL, DEFAULT, KEY
				if ($definition[self::ALLOWS_NULL_INDEX] && empty($definition[self::DEFAULT_INDEX]) && empty($value))
					{
					continue;
					}

				if (! static::$autoIncrement || ! (isset(static::$primaryKeys[$key]) && empty($value)))
					{
					$sql .= $comma . '`' . $key . '`';
					$input[] = $value;
					$values[] = '?';
					$comma = ',';
					}
				}
			}

		if (! \count($values))
			{
			return false;
			}
		$sql .= ') values (' . \implode(',', $values) . ')';

		if ($updateOnDuplicate)
			{
			$sql .= ' on duplicate key update ';
			$comma = '';

			foreach ($this->current as $key => $value)
				{
				if (isset(static::$fields[$key]))
					{
					$definition = static::$fields[$key];
					// MYSQL_TYPE, PHP_TYPE, LENGTH, NULL, DEFAULT, KEY
					if ($definition[self::ALLOWS_NULL_INDEX] && empty($definition[self::DEFAULT_INDEX]) && empty($value))
						{
						continue;
						}

					if (! isset(static::$primaryKeys[$key]))
						{
						$sql .= $comma . '`' . $key . '` = ?';
						$input[] = $value;
						$comma = ',';
						}
					}
				}
			}

		$returnValue = \PHPFUI\ORM::execute($sql, $input);

		if (static::$autoIncrement && $returnValue)
			{
			$this->current[\array_key_first(static::$primaryKeys)] = $returnValue = (int)\PHPFUI\ORM::lastInsertId(\array_key_first(static::$primaryKeys));
			}

		$this->loaded = true;	// record is effectively read from the database now

		return $returnValue;
		}

	/**
	 * Build a where clause
	 *
	 * @param int|array|string $key if int|string, primary key, otherwise a key => value array of fields to match
	 *
	 * @return string  starting with " where"
	 */
	private function buildWhere(array|int|string $key, array &$input) : string
		{
		if ('*' === $key)
			{
			return '';
			}

		if (! \is_array($key))
			{
			$key = [\array_key_first(static::$primaryKeys) => $key];
			}
		else
			{ // if all primary keys are set, then use primary keys only

			$keys = [];
			$all = true;

			foreach (static::$primaryKeys as $keyField => $junk)
				{
				if (! isset($key[$keyField]))
					{
					$all = false;

					break;
					}
				$keys[$keyField] = $key[$keyField];
				}

			if ($all && \count($keys))
				{
				$key = $keys;
				}
			}

		$and = ' ';
		$sql = '';

		foreach ($key as $field => $value)
			{
			if (isset(static::$fields[$field]))
				{
				$sql .= empty($sql) ? ' where' : '';
				$sql .= $and . '`' . $field . '`=?';
				$input[] = $value;
				$and = ' and ';
				}
			}

		return $sql;
		}

	private function validateFieldExists(string $field) : void
		{
		if (! isset(static::$fields[$field]))
			{
			$message = static::class . "::{$field} is not a valid field";
			\PHPFUI\ORM::log(\Psr\Log\LogLevel::ERROR, $message);

			throw new \PHPFUI\ORM\Exception($message);
			}
		}
	}