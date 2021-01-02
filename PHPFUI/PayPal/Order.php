<?php

namespace PHPFUI\PayPal;

class Order extends \PHPFUI\PayPal\Base
	{
	protected static $validFields = [
		'application_context' => ApplicationContext::class,
		'intent' => ['CAPTURE', 'AUTHORIZE'],
	];

	private $purchase_units = [];

	public function __construct(string $intent)
		{
		$this->intent = $intent;
		}

	public function addPurchaseUnit(PurchaseUnit $purchase_unit) : self
		{
		$this->purchase_units[] = $purchase_unit;

		return $this;
		}

	public function getData() : array
		{
		$result = ['intent' => $this->intent];

		if ($this->application_context)
			{
			$result['application_context'] = $this->application_context->getData();
			}

		if ($this->purchase_units)
			{
			$result['purchase_units'] = [];

			foreach ($this->purchase_units as $purchase_unit)
				{
				$result['purchase_units'][] = $purchase_unit->getData();
				}
			}

		return $result;
		}
	}
