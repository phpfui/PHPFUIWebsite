<?php

namespace PHPFUI\ConstantContact\Definition;

class ContactCreateOrUpdateResponse extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var uuid $contact_id The unique identifier for the contact that the V3 API created or updated.
	 * @var string $action Identifies if the V3 API created a new contact or updated an existing contact.
	 */

	protected static array $fields = [
		'contact_id' => 'uuid',
		'action' => 'string',

	];
	}