<?php

namespace PHPFUI\ConstantContact\Definition;

class ActivityTagging extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var string $activity_id The system assigned UUID that uniquely identifies an activity.
	 * @var string $state The activity processing state.
	 * @var date-time $started_at Timestamp showing when processing started for the activity, in ISO-8601 format.
	 * @var date-time $completed_at Timestamp showing when processing completed for the activity, in ISO-8601 format.
	 * @var date-time $created_at Timestamp showing when the activity was first requested, in ISO-8601 format.
	 * @var date-time $updated_at Timestamp showing when the activity was last updated, in ISO-8601 format.
	 * @var int $percent_done The processing percent complete for the activity.
	 * @var array $activity_errors An array of error message strings describing the errors that occurred.
	 */

	protected static array $fields = [
		'activity_id' => 'string',
		'state' => 'string',
		'started_at' => 'date-time',
		'completed_at' => 'date-time',
		'created_at' => 'date-time',
		'updated_at' => 'date-time',
		'percent_done' => 'int',
		'activity_errors' => 'array',
		'status' => 'PHPFUI\ConstantContact\Definition\ActivityTaggingStatus::class',
		'_links' => 'PHPFUI\ConstantContact\Definition\ActivityLinks::class',

	];
	}