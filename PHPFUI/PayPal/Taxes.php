<?php

namespace PHPFUI\PayPal;

class Taxes extends Base
	{
	protected static $validFields = [
		'percentage' => 'string',
		'inclusive' => 'boolean',
		];

	public function __construct()
		{
		parent::__construct();
		}
	}

