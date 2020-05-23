<?php

namespace PHPFUI\PayPal;

class AddressPortable extends Base
	{
	protected static $validFields = [
		'address_line_1' => 'string',
		'address_line_2' => 'string',
		'address_line_3' => 'string',
		'admin_area_1' => 'string',
		'admin_area_2' => 'string',
		'admin_area_3' => 'string',
		'admin_area_4' => 'string',
		'postal_code' => 'string',
		'country_code' => 'string',
		];

	public function __construct()
		{
		parent::__construct();
		}
	}


