<?php

namespace PHPFUI\ORM;

/**
 * A RecordCursor is the same as an ArrayCursor except is returns a Record object instead of an array
 */
class RecordCursor extends \PHPFUI\ORM\DataObjectCursor
	{
	/**
	 * You must pass an instance if the Record object that will be filled and returned by **current()** method
	 */
	public function __construct(\PHPFUI\ORM\Record $instance, \PDOStatement $statement, array $input)
		{
		$this->current = clone $instance;
		parent::__construct($statement, $input);
		}

	/**
	 * @return object  representation of the current row
	 */
	public function current() : mixed
		{
		$this->init();

		return $this->current;
		}

	/**
	 * @inheritDoc
	 */
	public function next() : void
		{
		$this->init();
		$data = $this->statement->fetch(\PDO::FETCH_ASSOC);

		if (false === $data)
			{
			$this->current->setEmpty();
			}
		else
			{
			$this->current->setFrom($data, true);
			}
		++$this->index;
		}

	/**
	 * @inheritDoc
	 */
	public function valid() : bool
		{
		$this->init();

		return ! $this->current->empty();
		}
	}
