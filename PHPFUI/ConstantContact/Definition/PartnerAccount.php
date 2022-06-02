<?php

// Generated file. Do not edit by hand. Use update.php in project root.

namespace PHPFUI\ConstantContact\Definition;

/**
 * @property array $site_owner_list Lists all Constant Contact client accounts that are managed under a partner account.
 * @property \PHPFUI\ConstantContact\Definition\PaginationLinks $_links HAL property that contains the next link, if applicable.
 */
class PartnerAccount extends \PHPFUI\ConstantContact\Definition\Base
	{
	protected static array $fields = [
		'site_owner_list' => 'array',
		'_links' => '\PHPFUI\ConstantContact\Definition\PaginationLinks',

	];
	}
