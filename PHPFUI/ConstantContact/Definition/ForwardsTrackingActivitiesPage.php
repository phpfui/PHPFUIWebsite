<?php

namespace PHPFUI\ConstantContact\Definition;

class ForwardsTrackingActivitiesPage extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var array $tracking_activities The list of contacts that forwarded the specified email campaign activity.
	 * @var PHPFUI\ConstantContact\Definition\Links_2::class $_links HAL property that contains the next link, if applicable.
	 */

	protected static array $fields = [
		'tracking_activities' => 'array',
		'_links' => 'PHPFUI\ConstantContact\Definition\Links_2::class',

	];
	}