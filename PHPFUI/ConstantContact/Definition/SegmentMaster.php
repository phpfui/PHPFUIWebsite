<?php

// Generated file. Do not edit by hand. Use update.php in project root.

namespace PHPFUI\ConstantContact\Definition;

/**
 * @property string $name The segment's unique descriptive name.
 * @property int $segment_id The system generated number that uniquely identifies the segment.
 * @property \PHPFUI\ConstantContact\DateTime $created_at The system generated date and time that the segment was created (ISO-8601 format).
 * @property \PHPFUI\ConstantContact\DateTime $edited_at The system generated date and time that the segment's <code>name</code> or <code>segment_criteria</code> was last updated (ISO-8601 format).
 */
class SegmentMaster extends \PHPFUI\ConstantContact\Definition\Base
	{
	protected static array $fields = [
		'name' => 'string',
		'segment_id' => 'int',
		'created_at' => '\PHPFUI\ConstantContact\DateTime',
		'edited_at' => '\PHPFUI\ConstantContact\DateTime',

	];
	}
