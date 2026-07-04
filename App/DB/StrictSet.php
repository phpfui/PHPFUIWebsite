<?php

namespace App\DB;

trait StrictSet
	{
	public function __set(string $name, $value) : void
		{
		throw new \TypeError('Undefined property: ' . __CLASS__ . '::$' . $name);
		}
	}
