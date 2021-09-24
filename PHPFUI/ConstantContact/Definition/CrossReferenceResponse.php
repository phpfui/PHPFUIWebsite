<?php

namespace PHPFUI\ConstantContact\Definition;

	/**
	 * @var array $xrefs An array of objects that contain a <code>v2_email_campaign_id</code> cross-referenced with a V3 <code>campaign_id</code> and a V3 <code>campaign_activity_id</code> value.
	 */

class CrossReferenceResponse extends \PHPFUI\ConstantContact\Definition\Base
	{

	protected static array $fields = [
		'xrefs' => 'array',

	];
	}