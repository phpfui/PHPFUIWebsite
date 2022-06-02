<?php

// Generated file. Do not edit by hand. Use update.php in project root.

namespace PHPFUI\ConstantContact\Definition;

/**
 * @property \PHPFUI\ConstantContact\UUID $activity_id Unique ID for the delete list batch job
 * @property string $state The state of the delete list request: processing - request is being processed completed - job completed cancelled - request was cancelled failed - job failed to complete timed_out - the request timed out before completing
 * @property \PHPFUI\ConstantContact\DateTime $created_at Date and time that the request was received, in ISO-8601 formmat.
 * @property \PHPFUI\ConstantContact\DateTime $updated_at Date and time that the request status was updated, in ISO-8601 format.
 * @property int $percent_done Job completion percentage
 * @property array $activity_errors Array of messages describing the errors that occurred.
 * @property \PHPFUI\ConstantContact\Definition\Link $_links
 */
class ActivityDeleteListResponse extends \PHPFUI\ConstantContact\Definition\Base
	{
	protected static array $fields = [
		'activity_id' => '\PHPFUI\ConstantContact\UUID',
		'state' => ['initialized', 'processing', 'completed', 'cancelled', 'failed', 'timed_out'],
		'created_at' => '\PHPFUI\ConstantContact\DateTime',
		'updated_at' => '\PHPFUI\ConstantContact\DateTime',
		'percent_done' => 'int',
		'activity_errors' => 'array',
		'_links' => '\PHPFUI\ConstantContact\Definition\Link',

	];
	}
