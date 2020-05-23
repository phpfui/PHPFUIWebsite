<?php

namespace PHPFUI\PayPal;

class BillingCycle extends Base
	{
	protected static $validFields = [
		'pricing_scheme' => '',
		'frequency' => '',
		'tenure_type' => ['REGULAR', 'TRIAL'],
		'sequence' => 'integer',
		'total_cycles' => 'integer',
		];

	private static $initialized = false;

	public function __construct()
		{
		if (! self::$initialized)
			{
			self::$validFields['pricing_scheme'] = new PricingScheme();
			self::$validFields['frequency'] = new Frequency();
			self::$initialized = true;
			}
		parent::__construct();
		}
	}
