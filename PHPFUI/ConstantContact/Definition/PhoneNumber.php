<?php

namespace PHPFUI\ConstantContact\Definition;

class PhoneNumber extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var uuid $phone_number_id Unique ID for the phone number
	 * @var string $phone_number The contact's phone number, 1 of 2 allowed per contact, no more than 25 characters
	 * @var string $kind Describes the type of phone number; valid values are home, work, mobile, or other.
	 * @var date-time $created_at Date and time that the street address was created, in ISO-8601 format. System generated.
	 * @var date-time $updated_at Date and time that the phone_number was last updated, in ISO-8601 format. System generated.
	 * @var string $update_source Identifies who last updated the phone_number; valid values are Contact or Account
	 * @var string $create_source Describes who added the phone_number; valid values are Contact or Account.
	 */

	protected static array $fields = [
		'phone_number_id' => 'uuid',
		'phone_number' => 'string',
		'kind' => 'string',
		'created_at' => 'date-time',
		'updated_at' => 'date-time',
		'update_source' => 'string',
		'create_source' => 'string',

	];

	protected static array $maxLength = [
		'phone_number' => 25,

	];
	}