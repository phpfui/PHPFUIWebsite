<?php

// Generated file. Do not edit by hand. Use update.php in project root.

namespace PHPFUI\ConstantContact\Definition;

/**
 * @property string $address The email address of the contact. The email address must be unique for each contact.
 * @property string $permission_to_send Identifies the type of permission that the Constant Contact account has to send email to the contact. Types of permission: explicit, implicit, not_set, pending_confirmation, temp_hold, unsubscribed.
 * @property \PHPFUI\ConstantContact\DateTime $created_at Date and time that the email_address was created, in ISO-8601 format. System generated.
 * @property \PHPFUI\ConstantContact\DateTime $updated_at Date and time that the email_address was last updated, in ISO-8601 format. System generated.
 * @property string $opt_in_source Describes who opted-in the email_address; valid values are Contact or Account. Your integration must accurately identify <code>opt_in_source</code> for compliance reasons; value is set on POST, and is read-only going forward.
 * @property \PHPFUI\ConstantContact\DateTime $opt_in_date Date and time that the email_address was opted-in to receive email from the account, in ISO-8601 format. System generated.
 * @property string $opt_out_source Describes the source of the unsubscribed/opt-out action: either Account or Contact. If the Contact opted-out, then the account cannot send any campaigns to this contact until the contact opts back in. If the Account, then the account can add the contact back to any lists and send to them. Displayed only if contact has been unsubscribed/opt-out.
 * @property \PHPFUI\ConstantContact\DateTime $opt_out_date Date and time that the contact unsubscribed/opted-out of receiving email from the account, in ISO-8601 format. Displayed only if contact has been unsubscribed/opt-out. System generated.
 * @property string $opt_out_reason The reason, as provided by the contact, that they unsubscribed/opted-out of receiving email campaigns.
 * @property string $confirm_status Indicates if the contact confirmed their email address after they subscribed to receive emails. Possible values: pending, confirmed, off.
 */
class EmailAddress extends \PHPFUI\ConstantContact\Definition\Base
	{
	protected static array $fields = [
		'address' => 'string',
		'permission_to_send' => ['implicit', 'explicit', 'pending_confirmation', 'unsubscribed', 'temp_hold', 'not_set'],
		'created_at' => '\PHPFUI\ConstantContact\DateTime',
		'updated_at' => '\PHPFUI\ConstantContact\DateTime',
		'opt_in_source' => ['Account', 'Contact'],
		'opt_in_date' => '\PHPFUI\ConstantContact\DateTime',
		'opt_out_source' => ['Account', 'Contact'],
		'opt_out_date' => '\PHPFUI\ConstantContact\DateTime',
		'opt_out_reason' => 'string',
		'confirm_status' => ['pending', 'confirmed', 'off'],

	];

	protected static array $maxLength = [
		'address' => 80,
		'opt_out_reason' => 255,

	];
	}
