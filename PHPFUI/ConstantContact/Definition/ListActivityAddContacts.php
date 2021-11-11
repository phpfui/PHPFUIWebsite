<?php

// Generated file. Do not edit by hand. Use update.php in project root.

namespace PHPFUI\ConstantContact\Definition;

/**
 * @var \PHPFUI\ConstantContact\Definition\Source $source The <code>source</code> object specifies which contacts you are adding to your targeted lists using one of four mutually exclusive properties.
 * @var array[\PHPFUI\ConstantContact\UUID][50] $list_ids Specifies which lists (up to 50) you are adding your source contacts to.
 */
class ListActivityAddContacts extends \PHPFUI\ConstantContact\Definition\Base
	{
	protected static array $fields = [
		'source' => '\PHPFUI\ConstantContact\Definition\Source',
		'list_ids' => 'array[\PHPFUI\ConstantContact\UUID][50]',

	];
	}
