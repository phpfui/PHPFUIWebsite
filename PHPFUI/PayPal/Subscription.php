<?php

namespace PHPFUI\PayPal;

class Subscription extends Base
	{
	protected static $validFields = [
		'plan_id' => 'string',
		'start_time' => 'string',
		'quantity' => 'double',
		'shipping_amount' => '',
		'subscriber' => '',
		'auto_renewal' => 'boolean',
		'application_context' => '',
		];

	private static $initialized = false;

	public function __construct()
		{
		if (! self::$initialized)
			{
			self::$validFields['shipping_amount'] = new Currency();
			self::$validFields['subscriber'] = new Subscriber();
			self::$validFields['application_context'] = new ApplicationContext();
			self::$initialized = true;
			}
		parent::__construct();
		}
	}
