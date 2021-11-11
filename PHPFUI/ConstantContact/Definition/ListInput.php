<?php

// Generated file. Do not edit by hand. Use update.php in project root.

namespace PHPFUI\ConstantContact\Definition;

/**
 * @var string $name The name given to the contact list
 * @var bool $favorite Identifies whether or not the account has favorited the contact list.
 * @var string $description Text describing the list.
 */
class ListInput extends \PHPFUI\ConstantContact\Definition\Base
	{
	protected static array $fields = [
		'name' => 'string',
		'favorite' => 'bool',
		'description' => 'string',

	];

	protected static array $maxLength = [
		'name' => 255,

	];
	}
