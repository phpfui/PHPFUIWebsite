<?php

namespace PHPFUI\ConstantContact\Definition;

class Links extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var PHPFUI\ConstantContact\Definition\Next::class $next HAL property that contains next link if applicable.
	 */

	protected static array $fields = [
		'next' => 'PHPFUI\ConstantContact\Definition\Next::class',

	];
	}