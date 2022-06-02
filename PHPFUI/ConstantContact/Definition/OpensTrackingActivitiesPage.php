<?php

// Generated file. Do not edit by hand. Use update.php in project root.

namespace PHPFUI\ConstantContact\Definition;

/**
 * @property array<\PHPFUI\ConstantContact\Definition\OpensTrackingActivity> $tracking_activities Lists contacts that opened the specified <code>campaign_activity_id</code>.
 * @property \PHPFUI\ConstantContact\Definition\Links2 $_links HAL property that contains the next link, if applicable.
 */
class OpensTrackingActivitiesPage extends \PHPFUI\ConstantContact\Definition\Base
	{
	protected static array $fields = [
		'tracking_activities' => 'array<\PHPFUI\ConstantContact\Definition\OpensTrackingActivity>',
		'_links' => '\PHPFUI\ConstantContact\Definition\Links2',

	];
	}
