<?php

namespace PHPFUI\ConstantContact\Definition;

class Tag_2 extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var uuid $tag_id The ID that uniquely identifies a tag (UUID format)
	 * @var string $name The unique tag name.
	 * @var int $contacts_count The total number of contacts who are assigned this tag.
	 * @var date-time $created_at The system generated date and time when the tag was created (ISO-8601 format).
	 * @var date-time $updated_at The system generated date and time when the tag was last updated (ISO-8601 format).
	 * @var string $tag_source The source used to tag contacts.
	 */

	protected static array $fields = [
		'tag_id' => 'uuid',
		'name' => 'string',
		'contacts_count' => 'int',
		'created_at' => 'date-time',
		'updated_at' => 'date-time',
		'tag_source' => 'string',

	];
	}