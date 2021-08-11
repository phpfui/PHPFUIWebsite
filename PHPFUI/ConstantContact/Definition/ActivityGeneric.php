<?php

namespace PHPFUI\ConstantContact\Definition;

class ActivityGeneric extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var string $activity_id The ID that uniquely identifies the activity.
	 * @var string $state The processing state for the activity.
	 * @var date-time $created_at The system generated date and time that the resource was created, in ISO-8601 format.
	 * @var date-time $updated_at The system generated date and time that the resource was last updated, in ISO-8601 format.
	 * @var int $percent_done The percentage complete for the specified activity.
	 * @var array $activity_errors An array of error messages if errors occurred for a specified activity. The system returns an empty array if no errors occur.
	 */

	protected static array $fields = [
		'activity_id' => 'string',
		'state' => 'string',
		'created_at' => 'date-time',
		'updated_at' => 'date-time',
		'percent_done' => 'int',
		'activity_errors' => 'array',
		'status' => 'PHPFUI\ConstantContact\Definition\ActivityGenericStatus::class',
		'_links' => 'PHPFUI\ConstantContact\Definition\ActivityLinks_2::class',

	];
	}