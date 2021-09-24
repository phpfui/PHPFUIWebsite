<?php

namespace PHPFUI\ConstantContact\Definition;

	/**
	 * @var array $xrefs An array of cross-referenced V3 API <code>list_id</code> and V2 API <code>sequence_id</code> properties. Response is sorted ascending by <code>sequence_id</code>.
	 */

class ListXrefs extends \PHPFUI\ConstantContact\Definition\Base
	{

	protected static array $fields = [
		'xrefs' => 'array',

	];
	}