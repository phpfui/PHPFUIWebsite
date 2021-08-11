<?php

namespace PHPFUI\ConstantContact\Definition;

class ContactCampaignActivitiesSummary extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var uuid $contact_id Unique id of the contact that will have their activity summarized.
	 * @var array $campaign_activities A summary of all the actions for a contact.
	 * @var PHPFUI\ConstantContact\Definition\Links_2::class $_links The next link if more summaries of activities are available.
	 */

	protected static array $fields = [
		'contact_id' => 'uuid',
		'campaign_activities' => 'array',
		'_links' => 'PHPFUI\ConstantContact\Definition\Links_2::class',

	];
	}