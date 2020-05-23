<?php

namespace PHPFUI\PayPal;

class Plan extends Base
	{
	protected static $validFields = [
		'product_id' => 'string',
		'name' => 'string',
		'status' => ['CREATED', 'INACTIVE', 'ACTIVE'],
		'payment_preferences' => '',
		'taxes' => '',
		'quantity_supported' => 'boolean',
		];

	private $billing_cycles = [];

	private static $initialized = false;

	public function __construct()
		{
		if (! self::$initialized)
			{
			self::$validFields['payment_preferences'] = new PaymentPreferences();
			self::$validFields['taxes'] = new Taxes();
			self::$initialized = true;
			}
		parent::__construct();
		}

	public function getData() : array
		{
		$result = parent::getData();
		if ($this->billing_cycles)
			{
			$result['billing_cycles'] = [];

			foreach ($this->billing_cycles as $billing_cycle)
				{
				$result['billing_cycles'][] = $billing_cycle->getData();
				}
			}

		return $result;
		}

	public function addBillingCycle(BillingCycle $billing_cycle) : self
		{
		$this->billing_cycles[] = $billing_cycle;

		return $this;
		}
	}
