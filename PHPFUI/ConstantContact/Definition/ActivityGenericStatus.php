<?php

namespace PHPFUI\ConstantContact\Definition;

	/**
	 * @var int $items_total_count The total number of tags that this activity will delete.
	 * @var int $items_completed_count The number of tags that this activity has currently deleted.
	 */

class ActivityGenericStatus extends \PHPFUI\ConstantContact\Definition\Base
	{

	protected static array $fields = [
		'items_total_count' => 'int',
		'items_completed_count' => 'int',

	];
	}