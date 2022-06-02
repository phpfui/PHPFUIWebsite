<?php

// Generated file. Do not edit by hand. Use update.php in project root.

namespace PHPFUI\ConstantContact\Definition;

/**
 * @property array<\PHPFUI\ConstantContact\Definition\ForwardsTrackingActivity> $tracking_activities The list of contacts that forwarded the specified email campaign activity.
 * @property \PHPFUI\ConstantContact\Definition\Links2 $_links HAL property that contains the next link, if applicable.
 */
class ForwardsTrackingActivitiesPage extends \PHPFUI\ConstantContact\Definition\Base
	{
	protected static array $fields = [
		'tracking_activities' => 'array<\PHPFUI\ConstantContact\Definition\ForwardsTrackingActivity>',
		'_links' => '\PHPFUI\ConstantContact\Definition\Links2',

	];
	}
