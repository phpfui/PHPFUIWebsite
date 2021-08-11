<?php

namespace PHPFUI\ConstantContact\Definition;

class ContactXref extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var string $sequence_id The V2 API contact unique identifier
	 * @var uuid $contact_id The V3 API contact unique identifier
	 */

	protected static array $fields = [
		'sequence_id' => 'string',
		'contact_id' => 'uuid',

	];
	}