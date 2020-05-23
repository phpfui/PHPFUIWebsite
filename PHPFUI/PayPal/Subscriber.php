<?php

namespace PHPFUI\PayPal;

class Subscriber extends Base
	{
	protected static $validFields = [
		'name' => '',
		'email_address' => 'string',
		'payer_id' => 'string',
		'shipping_address' => '',
		'payment_source' => '',
		];

	private static $initialized = false;

	public function __construct()
		{
		if (! self::$initialized)
			{
			self::$validFields['name'] = new Name();
			self::$validFields['shipping_address'] = new ShippingAddress();
			self::$validFields['payment_source'] = new PaymentSource();
			self::$initialized = true;
			}
		parent::__construct();
		}
	}
