<?php

namespace PHPFUI\ConstantContact\Definition;

class OptoutsTrackingActivity extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var uuid $contact_id The ID that uniquely identifies a contact.
	 * @var uuid $campaign_activity_id The ID that uniquely identifies the email campaign activity.
	 * @var string $tracking_activity_type The type of report tracking activity that is associated with the specified <code>campaign_activity_id</code>.
	 * @var string $email_address The contact's email address.
	 * @var string $first_name The first name of the contact.
	 * @var string $last_name The last name of the contact.
	 * @var string $opt_out_reason The opt-out reason, if the contact entered a reason.
	 * @var date-time $created_time The time that the contact chose to opt-out from receiving future email campaign activities.
	 * @var date $deleted_at If applicable, displays the date that the contact was deleted.
	 */

	protected static array $fields = [
		'contact_id' => 'uuid',
		'campaign_activity_id' => 'uuid',
		'tracking_activity_type' => 'string',
		'email_address' => 'string',
		'first_name' => 'string',
		'last_name' => 'string',
		'opt_out_reason' => 'string',
		'created_time' => 'date-time',
		'deleted_at' => 'date',

	];
	}