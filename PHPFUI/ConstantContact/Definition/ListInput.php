<?php

namespace PHPFUI\ConstantContact\Definition;

class ListInput extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var string $name The name given to the contact list
	 * @var boolean $favorite Identifies whether or not the account has favorited the contact list.
	 * @var string $description Text describing the list.
	 */

	protected static array $fields = [
		'name' => 'string',
		'favorite' => 'boolean',
		'description' => 'string',

	];

	protected static array $maxLength = [
		'name' => 255,

	];
	}