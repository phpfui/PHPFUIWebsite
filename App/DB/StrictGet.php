<?php

namespace App\DB;

trait StrictGet
	{
	public function __get(string $name) : void
		{
		throw new \TypeError('Undefined property: ' . __CLASS__ . '::$' . $name);
		}
	}
