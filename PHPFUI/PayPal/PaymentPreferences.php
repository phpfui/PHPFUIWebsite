<?php

namespace PHPFUI\PayPal;

class PaymentPreferences extends Base
	{
	protected static $validFields = [
		'auto_bill_outstanding' => 'boolean',
		'setup_fee' => '',
		'setup_fee_failure_action' => ['CONTINUE', 'CANCEL'],
		'payment_failure_threshold' => 'integer',
		];

	private static $initialized = false;

	public function __construct()
		{
		if (! self::$initialized)
			{
			self::$validFields['setup_fee'] = new Currency();
			self::$initialized = true;
			}
		parent::__construct();
		}
	}
