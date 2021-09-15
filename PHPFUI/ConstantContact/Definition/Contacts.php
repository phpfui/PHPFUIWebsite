<?php

namespace PHPFUI\ConstantContact\Definition;

class Contacts extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var int $contacts_count Total number of contacts in the response.
	 * @var string $status If you use the <code>segment_id</code> query parameter to filter results based on a segment, this property indicates that the V3 API accepted your request and is still processing it.
	 */

	protected static array $fields = [
		'contacts' => 'array',
		'contacts_count' => 'int',
		'_links' => 'PHPFUI\\ConstantContact\\Definition\\PagingLinks',
		'status' => ['processing'],

	];
	}