<?php

namespace PHPFUI\ConstantContact\Definition;

class ContactCustomField extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var uuid $custom_field_id The custom_field's unique ID
	 * @var string $value The custom_field value.
	 */

	protected static array $fields = [
		'custom_field_id' => 'uuid',
		'value' => 'string',

	];

	protected static array $maxLength = [
		'value' => 255,

	];
	}