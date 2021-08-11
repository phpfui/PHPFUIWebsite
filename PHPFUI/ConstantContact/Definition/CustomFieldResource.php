<?php

namespace PHPFUI\ConstantContact\Definition;

class CustomFieldResource extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var uuid $custom_field_id The custom_field's unique ID
	 * @var string $label The display name for the custom_field shown in the UI as free-form text
	 * @var string $name Unique name for the custom_field constructed from the label by replacing blanks with underscores.
	 * @var string $type Specifies the type of value the custom_field field accepts: string or date.
	 * @var date-time $updated_at System generated date and time that the resource was updated, in ISO-8601 format.
	 * @var date-time $created_at Date and time that the resource was created, in ISO-8601 format. System generated.
	 */

	protected static array $fields = [
		'custom_field_id' => 'uuid',
		'label' => 'string',
		'name' => 'string',
		'type' => 'string',
		'updated_at' => 'date-time',
		'created_at' => 'date-time',

	];

	protected static array $maxLength = [
		'label' => 50,
		'name' => 50,

	];
	}