<?php

namespace PHPFUI\ConstantContact\Definition;

class Links_2 extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var PHPFUI\ConstantContact\Definition\Next_2::class $next Contains the next page link, if applicable.
	 */

	protected static array $fields = [
		'href' => 'string',
		'next' => 'PHPFUI\ConstantContact\Definition\Next_2::class',

	];
	}