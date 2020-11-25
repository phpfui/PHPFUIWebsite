<?php

namespace PHPFUI\PayPal;

class Amount extends \PHPFUI\PayPal\Base
	{
	protected static $validFields = [
		'currency_code' => 'string',
		'value' => 'string',
		'breakdown' => Breakdown::class,
		];

	public function setCurrency(Currency $currency) : self
		{
		foreach ($currency->getData() as $field => $value)
			{
			$this->{$field} = $value;
			}

		return $this;
		}

	}
