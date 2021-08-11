<?php

namespace PHPFUI\ConstantContact\Definition;

class CreateOrUpdateContactCustomField extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var uuid $custom_field_id The unique ID for the <code>custom_field</code>.
	 * @var string $value The value of the <code>custom_field</code>.
	 */

	protected static array $fields = [
		'custom_field_id' => 'uuid',
		'value' => 'string',

	];

	protected static array $maxLength = [
		'value' => 255,

	];
	}