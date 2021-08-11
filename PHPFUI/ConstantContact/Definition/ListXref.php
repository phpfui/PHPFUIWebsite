<?php

namespace PHPFUI\ConstantContact\Definition;

class ListXref extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var string $sequence_id The V2 API list unique identifier
	 * @var uuid $list_id The V3 API list unique identifier
	 */

	protected static array $fields = [
		'sequence_id' => 'string',
		'list_id' => 'uuid',

	];
	}