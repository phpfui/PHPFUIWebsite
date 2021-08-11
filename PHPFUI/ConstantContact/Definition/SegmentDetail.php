<?php

namespace PHPFUI\ConstantContact\Definition;

class SegmentDetail extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var string $name The segment's unique descriptive name.
	 * @var string $segment_criteria The segment's contact selection criteria formatted as single-string escaped JSON.
	 * @var int $segment_id The system generated number that uniquely identifies the segment.
	 * @var date-time $created_at The system generated date and time (ISO-8601) that the segment was created.
	 * @var date-time $edited_at The system generated date and time (ISO-8601) that the segment's <code>name</code> or <code> segment_criteria</code> was last updated.
	 */

	protected static array $fields = [
		'name' => 'string',
		'segment_criteria' => 'string',
		'segment_id' => 'int',
		'created_at' => 'date-time',
		'edited_at' => 'date-time',

	];

	protected static array $maxLength = [
		'segment_criteria' => 20000,

	];
	}