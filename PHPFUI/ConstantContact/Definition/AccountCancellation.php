<?php

namespace PHPFUI\ConstantContact\Definition;

class AccountCancellation extends \PHPFUI\ConstantContact\Definition\Base
	{
	/**
	 * @var int $reason_id Specifies the reason that the client is canceling their Constant Contact account as follows:
  <ul>
    <li><code>1</code>  Cost Too High</li>
    <li><code>2</code>  Using A Competitive Service</li>
    <li><code>3</code>  Not Doing Email Marketing</li>
    <li><code>11</code> Something Missing Or Not Working </li>
    <li><code>12</code> Doing It In-House</li>
    <li><code>14</code> Poor Results</li>
    <li><code>21</code> Too Difficult To Use</li>
    <li><code>27</code> Canceled Online by Customer</li>
    <li><code>30</code> Dissatisfied With Billing Policies</li>
  </ul>
	 * @var date-time $effective_date The client account cancellation date and time in ISO-8601 format.
	 */

	protected static array $fields = [
		'reason_id' => 'int',
		'effective_date' => 'date-time',

	];
	}