<?php

namespace PHPFUI\ConstantContact\Definition;

class Note extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var uuid $note_id The ID that uniquely identifies the note (UUID format).
	 * @var date-time $created_at The date that the note was created.
	 * @var string $content The content for the note.
	 */

	protected static array $fields = [
		'note_id' => 'uuid',
		'created_at' => 'date-time',
		'content' => 'string',

	];

	protected static array $maxLength = [
		'content' => 2000,

	];
	}