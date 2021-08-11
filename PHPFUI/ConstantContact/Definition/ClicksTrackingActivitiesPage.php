<?php

namespace PHPFUI\ConstantContact\Definition;

class ClicksTrackingActivitiesPage extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var array $tracking_activities The list of click tracking activities
	 * @var PHPFUI\ConstantContact\Definition\Links_2::class $_links HAL property that contains next link if applicable.
	 */

	protected static array $fields = [
		'tracking_activities' => 'array',
		'_links' => 'PHPFUI\ConstantContact\Definition\Links_2::class',

	];
	}