<?php

namespace PHPFUI\ConstantContact\Definition;

class SendsTrackingActivity extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var uuid $contact_id The ID that uniquely identifies a contact.
	 * @var uuid $campaign_activity_id The ID that uniquely identifies an email campaign activity.
	 * @var string $tracking_activity_type The type of tracking activity that is associated with this <code>campaign_activity_id</code> and used for reporting purposes.
	 * @var string $email_address The email address used to send the email campaign activity to a contact.
	 * @var string $first_name The first name of the contact.
	 * @var string $last_name The last name of the contact.
	 * @var date-time $created_time The date and time that you sent the email campaign to the contact.
	 * @var date $deleted_at If applicable, displays the date that the contact was deleted.
	 */

	protected static array $fields = [
		'contact_id' => 'uuid',
		'campaign_activity_id' => 'uuid',
		'tracking_activity_type' => 'string',
		'email_address' => 'string',
		'first_name' => 'string',
		'last_name' => 'string',
		'created_time' => 'date-time',
		'deleted_at' => 'date',

	];
	}