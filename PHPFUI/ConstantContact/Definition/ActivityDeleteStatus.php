<?php

namespace PHPFUI\ConstantContact\Definition;

class ActivityDeleteStatus extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var uuid $activity_id Unique ID for the activity.
	 * @var string $state The state of the request: initialized - request has been received processing - request is being processed completed - job completed cancelled - request was cancelled failed - job failed to complete timed_out - the request timed out before completing
	 * @var date-time $started_at Timestamp showing when we began processing the activity request, in ISO-8601 format.
	 * @var date-time $completed_at Timestamp showing when we completed processing the activity, in ISO-8601 format.
	 * @var date-time $created_at Timestamp showing when we created the activity, in ISO-8601 format.
	 * @var date-time $updated_at Timestamp showing when we last updated the activity, in ISO-8601 format.
	 * @var int $percent_done Shows the percent done for an activity that we are still processing.
	 * @var array $activity_errors Array of messages describing the errors that occurred.
	 */

	protected static array $fields = [
		'activity_id' => 'uuid',
		'state' => 'string',
		'started_at' => 'date-time',
		'completed_at' => 'date-time',
		'created_at' => 'date-time',
		'updated_at' => 'date-time',
		'percent_done' => 'int',
		'activity_errors' => 'array',
		'status' => 'object',
		'_links' => 'object',

	];
	}