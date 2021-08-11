<?php

namespace PHPFUI\ConstantContact\Definition;

class ListActivityAddContacts extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var object $source The <code>source</code> object specifies which contacts you are adding to your targeted lists using one of four mutually exclusive properties.
	 * @var array $list_ids Specifies which lists (up to 50) you are adding your source contacts to.
	 */

	protected static array $fields = [
		'source' => 'object',
		'list_ids' => 'array',

	];
	}