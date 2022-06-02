<?php

// Generated file. Do not edit by hand. Use update.php in project root.

namespace PHPFUI\ConstantContact\Definition;

/**
 * @property string $name The segment's unique descriptive name.
 * @property string $segment_criteria The <code>segment_criteria</code> specifies the contact data that Constant Contact uses to evaluate and identify contacts that meet your criteria. The <code>segment_criteria</code> must be formatted as single-string escaped JSON. The top-level <code>group</code> <code>type</code> must be <code>add</code>.
 */
class SegmentData extends \PHPFUI\ConstantContact\Definition\Base
	{
	protected static array $fields = [
		'name' => 'string',
		'segment_criteria' => 'string',

	];

	protected static array $maxLength = [
		'segment_criteria' => 20000,

	];
	}
