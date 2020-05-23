<?php

namespace PHPFUI\PayPal;

class ApplicationContent extends Base
	{
	protected static $validFields = [
		'brand_name' => 'string',
		'locale' => 'string',
		'landing_page' => ['LOGIN', 'BILLING', 'NO_PREFERENCE'],
		'shipping_preferences' => ['GET_FROM_FILE', 'NO_SHIPPING', 'SET_PROVIDED_ADDRESS'],
		'user_action' => ['CONTINUE', 'PAY_NOW'],
		'payment_method' => '',
		'return_url' => 'string',
		'cancel_url' => 'string',
		];

	private static $initialized = false;

	public function __construct()
		{
		if (! self::$initialized)
			{
			self::$validFields['payment_method'] = new PaymentMethod();
			self::$initialized = true;
			}
		parent::__construct();
		}
	}
