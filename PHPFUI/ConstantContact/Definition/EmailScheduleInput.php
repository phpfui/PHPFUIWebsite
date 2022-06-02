<?php

// Generated file. Do not edit by hand. Use update.php in project root.

namespace PHPFUI\ConstantContact\Definition;

/**
 * @property \PHPFUI\ConstantContact\DateTime $scheduled_date The date when Constant Contact will send the email campaign activity to contacts in ISO-8601 format. For example, <code>2022-05-17</code> and <code>2022-05-17T16:37:59.091Z</code> are valid dates. Use <code>"0"</code> as the date to have Constant Contact immediately send the email campaign activity to contacts.
 */
class EmailScheduleInput extends \PHPFUI\ConstantContact\Definition\Base
	{
	protected static array $fields = [
		'scheduled_date' => '\PHPFUI\ConstantContact\DateTime',

	];
	}
