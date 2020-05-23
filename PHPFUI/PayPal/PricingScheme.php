<?php

namespace PHPFUI\PayPal;

class PricingScheme extends Base
	{
	protected static $validFields = [
		'version' => 'integer',
		'fixed_price' => '',
		'create_time' => 'string',
		'update_time' => 'string',
		];

	private static $initialized = false;

	public function __construct()
		{
		if (! self::$initialized)
			{
			self::$validFields['fixed_price'] = new Currency();
			self::$initialized = true;
			}
		parent::__construct();
		}
	}

