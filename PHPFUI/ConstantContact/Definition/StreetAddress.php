<?php

namespace PHPFUI\ConstantContact\Definition;

class StreetAddress extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var uuid $street_address_id Unique ID for the street address
	 * @var string $kind Describes the type of address; valid values are home, work, or other.
	 * @var string $street Number and street of the address.
	 * @var string $city The name of the city where the contact lives.
	 * @var string $state The name of the state or province where the contact lives.
	 * @var string $postal_code The zip or postal code of the contact.
	 * @var string $country The name of the country where the contact lives.
	 * @var date-time $created_at Date and time that the street address was created, in ISO-8601 format. System generated.
	 * @var date-time $updated_at Date and time that the street address was last updated, in ISO-8601 format. System generated.
	 */

	protected static array $fields = [
		'street_address_id' => 'uuid',
		'kind' => 'string',
		'street' => 'string',
		'city' => 'string',
		'state' => 'string',
		'postal_code' => 'string',
		'country' => 'string',
		'created_at' => 'date-time',
		'updated_at' => 'date-time',

	];

	protected static array $maxLength = [
		'street' => 255,
		'city' => 50,
		'state' => 50,
		'postal_code' => 50,
		'country' => 50,

	];
	}