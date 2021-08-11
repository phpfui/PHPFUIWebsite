<?php

namespace PHPFUI\ConstantContact\Definition;

class EmailAddressPut extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var string $address The email address of the contact. The email address must be unique for each contact.
	 * @var string $permission_to_send Identifies the type of permission that the Constant Contact account has to send email to the contact. Types of permission: explicit, implicit, not_set, pending_confirmation, temp_hold, unsubscribed.
	 * @var date-time $created_at Date and time that the email_address was created, in ISO-8601 format. System generated.
	 * @var date-time $updated_at Date and time that the email_address was last updated, in ISO-8601 format. System generated.
	 * @var date-time $opt_in_date Date and time that the email_address was opted-in to receive email from the account, in ISO-8601 format. System generated.
	 * @var string $opt_out_source Describes the source of the unsubscribed/opt-out action: either Account or Contact. If the Contact opted-out, then the account cannot send any campaigns to this contact until the contact opts back in. If the Account, then the account can add the contact back to any lists and send to them. Displayed only if contact has been unsubscribed/opt-out.
	 * @var date-time $opt_out_date Date and time that the contact unsubscribed/opted-out of receiving email from the account, in ISO-8601 format. Displayed only if contact has been unsubscribed/opt-out. System generated.
	 * @var string $opt_out_reason The reason, as provided by the contact, that they unsubscribed/opted-out of receiving email campaigns.
	 * @var string $confirm_status Indicates if the contact confirmed their email address after they subscribed to receive emails. Possible values: pending, confirmed, off.
	 */

	protected static array $fields = [
		'address' => 'string',
		'permission_to_send' => 'string',
		'created_at' => 'date-time',
		'updated_at' => 'date-time',
		'opt_in_date' => 'date-time',
		'opt_out_source' => 'string',
		'opt_out_date' => 'date-time',
		'opt_out_reason' => 'string',
		'confirm_status' => 'string',

	];

	protected static array $maxLength = [
		'address' => 80,
		'opt_out_reason' => 255,

	];
	}