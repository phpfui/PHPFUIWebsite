<?php

namespace PHPFUI\ConstantContact\Definition;

class ActivityDeleteListResponse extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var uuid $activity_id Unique ID for the delete list batch job
	 * @var string $state The state of the delete list request: processing - request is being processed completed - job completed cancelled - request was cancelled failed - job failed to complete timed_out - the request timed out before completing
	 * @var date-time $created_at Date and time that the request was received, in ISO-8601 formmat.
	 * @var date-time $updated_at Date and time that the request status was updated, in ISO-8601 format.
	 * @var int $percent_done Job completion percentage
	 * @var array $activity_errors Array of messages describing the errors that occurred.
	 */

	protected static array $fields = [
		'activity_id' => 'uuid',
		'state' => 'string',
		'created_at' => 'date-time',
		'updated_at' => 'date-time',
		'percent_done' => 'int',
		'activity_errors' => 'array',
		'_links' => 'object',

	];
	}