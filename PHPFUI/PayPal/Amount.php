<?php

namespace PHPFUI\PayPal;

/**
 * @property string $currency_code
 * @property string $value
 * @property ?\PHPFUI\PayPal\Breakdown $breakdown
 */
class Amount extends \PHPFUI\PayPal\Base
	{
	/** @var array<string, string> */
	protected static array $validFields = [
		'currency_code' => 'string',
		'value' => 'string',
		'breakdown' => \PHPFUI\PayPal\Breakdown::class,
	];

	public function setCurrency(Currency $currency) : static
		{
		foreach ($currency->getData() as $field => $value)
			{
			$this->{$field} = $value;
			}

		return $this;
		}
	}
