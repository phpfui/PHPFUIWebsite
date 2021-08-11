<?php

namespace PHPFUI\ConstantContact\Definition;

class ContactList extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var uuid $list_id Unique ID for the contact list
	 * @var string $name The name given to the contact list
	 * @var string $description Text describing the list.
	 * @var boolean $favorite Identifies whether or not the account has favorited the contact list.
	 * @var date-time $created_at System generated date and time that the resource was created, in ISO-8601 format.
	 * @var date-time $updated_at Date and time that the list was last updated, in ISO-8601 format. System generated.
	 * @var int $membership_count The number of contacts in the contact list.
	 */

	protected static array $fields = [
		'list_id' => 'uuid',
		'name' => 'string',
		'description' => 'string',
		'favorite' => 'boolean',
		'created_at' => 'date-time',
		'updated_at' => 'date-time',
		'membership_count' => 'int',

	];
	}