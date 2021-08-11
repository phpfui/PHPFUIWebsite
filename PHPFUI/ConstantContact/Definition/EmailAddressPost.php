<?php

namespace PHPFUI\ConstantContact\Definition;

class EmailAddressPost extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var string $address The contact's email address
	 * @var string $permission_to_send Identifies the type of permission that the Constant Contact account has been granted to send email to the contact. Types of permission: explicit, implicit, not_set, pending_confirmation, temp_hold, unsubscribed.
	 */

	protected static array $fields = [
		'address' => 'string',
		'permission_to_send' => 'string',

	];

	protected static array $maxLength = [
		'address' => 80,

	];
	}