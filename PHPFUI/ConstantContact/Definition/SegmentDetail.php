<?php

// Generated file. Do not edit by hand. Use update.php in project root.

namespace PHPFUI\ConstantContact\Definition;

/**
 * @property string $name The segment's unique descriptive name.
 * @property string $segment_criteria The segment's contact selection criteria formatted as single-string escaped JSON.
 * @property int $segment_id The system generated number that uniquely identifies the segment.
 * @property \PHPFUI\ConstantContact\DateTime $created_at The system generated date and time (ISO-8601) that the segment was created.
 * @property \PHPFUI\ConstantContact\DateTime $edited_at The system generated date and time (ISO-8601) that the segment's <code>name</code> or <code> segment_criteria</code> was last updated.
 */
class SegmentDetail extends \PHPFUI\ConstantContact\Definition\Base
	{
	protected static array $fields = [
		'name' => 'string',
		'segment_criteria' => 'string',
		'segment_id' => 'int',
		'created_at' => '\PHPFUI\ConstantContact\DateTime',
		'edited_at' => '\PHPFUI\ConstantContact\DateTime',

	];

	protected static array $maxLength = [
		'segment_criteria' => 20000,

	];
	}
