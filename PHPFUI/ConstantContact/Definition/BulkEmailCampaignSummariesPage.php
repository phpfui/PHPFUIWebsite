<?php

namespace PHPFUI\ConstantContact\Definition;

	/**
	 * @var array $bulk_email_campaign_summaries Lists and provides details about each bulk email campaign activity including total unique counts for tracked activities.
	 * @var PHPFUI\ConstantContact\Definition\Links2 $_links HAL property that contains next link if applicable
	 */

class BulkEmailCampaignSummariesPage extends \PHPFUI\ConstantContact\Definition\Base
	{

	protected static array $fields = [
		'bulk_email_campaign_summaries' => 'array',
		'_links' => 'PHPFUI\\ConstantContact\\Definition\\Links2',

	];
	}