<?php

namespace App\Tools;

class Cookies
	{
	use \App\DB\StrictGet;
	use \App\DB\StrictSet;

	private string $prefix;

	public function __construct()
		{
		$settings = new \App\Table\Setting();
		$this->prefix = $settings->value('clubAbbrev');
		}

	public function delete(string $name) : static
		{
		$cookieName = $this->prefix . $name;
		unset($_COOKIE[$cookieName]);
		\setcookie($cookieName, '', \time() - 1);
		unset($_COOKIE[$cookieName]);

		return $this;
		}

	public function get(string $name)
		{
		$cookieName = $this->prefix . $name;

		return $_COOKIE[$cookieName] ?? '';
		}

	public function set(string $name, string $value = '', bool $permanent = false) : static
		{
		$permanent ? \time() + 32000000 : 0; // expires in about a year if permanent
		$options = [
			'expires' => $permanent ? \time() + 32000000 : 0, // expires in about a year if permanent
			'path' => '/',
			'domain' => $_SERVER['SERVER_NAME'],
			'secure' => true,
			'httponly' => true,
			'samesite' => 'Strict',
		];
		\setcookie($this->prefix . $name, $value, $options);

		return $this;
		}
	}
