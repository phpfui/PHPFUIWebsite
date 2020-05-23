<?php

namespace PHPFUI\PayPal;

class Card extends Base
	{
	protected static $validFields = [
		'name' => 'string',
		'number' => 'string',
		'expiry' => 'string',
		'security_code' => 'integer',
		'billing_address' => '',
		];

	private static $initialized = false;

	public function __construct()
		{
		if (! self::$initialized)
			{
			self::$validFields['billing_address'] = new AddressPortable();
			self::$initialized = true;
		parent::__construct();
		}
	}
