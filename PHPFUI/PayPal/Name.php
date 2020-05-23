<?php

namespace PHPFUI\PayPal;

class Name extends Base
	{
	protected static $validFields = [
		'given_name' => 'string',
		'surname' => 'string',
		];

	public function __construct()
		{
		parent::__construct();
		}
	}

