<?php

namespace PHPFUI\PayPal;

class PurchaseUnit extends \PHPFUI\PayPal\Base
	{
	protected $items = [];

	protected static $validFields = [
		'reference_id' => 'string',
		'description' => 'string',
		'custom_id' => 'string',
		'invoice_id' => 'string',
		'soft_descriptor' => 'string',
		'amount' => Amount::class,
		'shipping' => Shipping::class,
	];

	public function addItem(Item $item) : self
		{
		$this->items[] = $item;

		return $this;
		}

	public function getData() : array
		{
		$result = parent::getData();

		if ($this->items)
			{
			$result['items'] = [];

			foreach ($this->items as $item)
				{
				$result['items'][] = $item->getData();
				}
			}

		return $result;
		}
	}
