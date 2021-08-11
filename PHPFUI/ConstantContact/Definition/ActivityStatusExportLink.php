<?php

namespace PHPFUI\ConstantContact\Definition;

class ActivityStatusExportLink extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var object $self HATEOS-style link to the activity status (this object).
	 * @var object $results Link to an activity result resource; as an example, for file_export, the link to the exported contacts file.
	 */

	protected static array $fields = [
		'self' => 'object',
		'results' => 'object',

	];
	}