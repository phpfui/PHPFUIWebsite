<?php

namespace PHPFUI;

class PayPalExpress extends PayPal\Express
	{

	public function __construct(\PHPFUI\Interfaces\Page $page, string $clientId)
		{
		parent::__construct($page, $clientId);
		}
	}
