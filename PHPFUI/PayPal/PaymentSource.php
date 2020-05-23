<?php

namespace PHPFUI\PayPal;

class PaymentSource extends Base
	{
	protected static $validFields = [
		'card' => '',
		];

	private static $initialized = false;

	public function __construct()
		{
		if (! self::$initialized)
			{
			self::$validFields['card'] = new Card();
			}
		parent::__construct();
		}
	}

