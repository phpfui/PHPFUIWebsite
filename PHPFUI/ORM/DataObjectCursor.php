<?php

namespace PHPFUI\ORM;

/**
 * A Cursor does not read the entire query result into memory at once, but will just read and return one row at a time.
 *
 * Since it is iterable, it can be used in a foreach statement.
 *
 * The DataObjectCursor returns an object you access via object syntax (ie. $object->field), vs array
 * syntax ($array['field']) for the ArrayCursor
 */
class DataObjectCursor extends \PHPFUI\ORM\ArrayCursor implements \Countable, \Iterator
	{
	/**
	 * @return object  representation of the current row
	 */
	public function current() : mixed
		{
		$this->init();

		return new \PHPFUI\ORM\DataObject($this->current ?: []);
		}
	}
