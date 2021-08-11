<?php

namespace PHPFUI\ConstantContact\Definition;

class CampaignStatsResultGenericStatsEmailPercentsEmail extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var string $campaign_id The ID that uniquely identifies the campaign (UUID).
	 * @var PHPFUI\ConstantContact\Definition\StatsEmail::class $stats Key-value pairs of campaign related statistics.
	 * @var PHPFUI\ConstantContact\Definition\PercentsEmail::class $percents Key-value pairs of campaign related percentages.
	 * @var date-time $last_refresh_time The date and time that the campaign stats were last refreshed.
	 */

	protected static array $fields = [
		'campaign_id' => 'string',
		'stats' => 'PHPFUI\ConstantContact\Definition\StatsEmail::class',
		'percents' => 'PHPFUI\ConstantContact\Definition\PercentsEmail::class',
		'last_refresh_time' => 'date-time',

	];
	}