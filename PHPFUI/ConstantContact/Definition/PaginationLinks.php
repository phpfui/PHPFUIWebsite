<?php

namespace PHPFUI\ConstantContact\Definition;

class PaginationLinks extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var PHPFUI\ConstantContact\Definition\Link_2::class $next Contains the next page link, if applicable.
	 */

	protected static array $fields = [
		'next' => 'PHPFUI\ConstantContact\Definition\Link_2::class',

	];
	}