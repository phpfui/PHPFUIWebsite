<?php

namespace PHPFUI\ConstantContact\Definition;

class Status extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var int $items_total_count Total number of contacts to add to or remove from lists.
	 * @var int $items_completed_count The number of contacts processed.
	 * @var int $list_count The number of lists specified in the request.
	 */

	protected static array $fields = [
		'items_total_count' => 'int',
		'items_completed_count' => 'int',
		'list_count' => 'int',

	];
	}