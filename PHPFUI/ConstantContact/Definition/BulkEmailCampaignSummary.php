<?php

// Generated file. Do not edit by hand. Use update.php in project root.

namespace PHPFUI\ConstantContact\Definition;

/**
 * @property string $campaign_id The ID that uniquely identifies an email campaign.
 * @property string $campaign_type Identifies the email campaign type.
 * @property \PHPFUI\ConstantContact\DateTime $last_sent_date The date and time that the email campaign was last sent.
 * @property \PHPFUI\ConstantContact\Definition\UniqueEmailCounts $unique_counts The total number of times each unique contact interacted with a tracked email campaign activity.
 */
class BulkEmailCampaignSummary extends \PHPFUI\ConstantContact\Definition\Base
	{
	protected static array $fields = [
		'campaign_id' => 'string',
		'campaign_type' => 'string',
		'last_sent_date' => '\PHPFUI\ConstantContact\DateTime',
		'unique_counts' => '\PHPFUI\ConstantContact\Definition\UniqueEmailCounts',

	];
	}
