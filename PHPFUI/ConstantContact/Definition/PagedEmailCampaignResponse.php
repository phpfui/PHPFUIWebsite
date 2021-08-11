<?php

namespace PHPFUI\ConstantContact\Definition;

class PagedEmailCampaignResponse extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 */

	protected static array $fields = [
		'_links' => 'PHPFUI\ConstantContact\Definition\PagingLinks_2::class',
		'campaigns' => 'array',

	];
	}