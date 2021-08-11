<?php

namespace PHPFUI\ConstantContact\Definition;

class ContactTrackingActivity extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var uuid $contact_id The contact id.
	 * @var uuid $campaign_activity_id The unique id of the activity for an e-mail campaign.
	 * @var date-time $created_time The time the tracking activity occurred
	 * @var string $tracking_activity_type The type of the tracking activity (send, open, click, bounce, opt-out or forward to a friend)
	 */

	protected static array $fields = [
		'contact_id' => 'uuid',
		'campaign_activity_id' => 'uuid',
		'created_time' => 'date-time',
		'tracking_activity_type' => 'string',

	];
	}