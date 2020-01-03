<?php

namespace PHPFUI;

/**
 * A container class that conforms to an interface needed by PHPFUI.  The Container class does not impart any html
 * or other formatting, but simply contains items that will be output in the order they were added to the collection.
 */
class Container implements \Countable
	{
	private $objects = [];

	public function __construct()
		{
		$this->objects = func_get_args();
		}

	public function __toString() : string
		{
		return $this->output();
		}

	/**
	 * Add an item to the Container
	 *
	 * @param string|Base $object need to support output interface or __toString
	 *
	 */
	public function add($object) : Container
		{
		if (null !== $object)
			{
			$this->objects[] = $object;
			}

		return $this;
		}

	/**
	 * Adds to the front of the container
	 *
	 * @param mixed $object should be convertable to string
	 *
	 * @return Base
	 */
	public function addAsFirst($object) : Container
		{
		if (null !== $object)
			{
			array_unshift($this->objects, $object);
			}

		return $this;
		}

	/**
	 * Supports the Countable interface
	 *
	 */
	public function count() : int
		{
		return count($this->objects);
		}

	public function output() : string
		{
		$output = '';

		foreach ($this->objects as $object)
			{
			$output .= $object;
			}

		return $output;
		}

	/**
	 * Add an item to the beginning of the Container
	 *
	 * @param string|Base $object need to support output interface or __toString
	 *
	 */
	public function prepend($object) : Container
		{
		array_unshift($this->objects, $object);

		return $this;
		}
	}
