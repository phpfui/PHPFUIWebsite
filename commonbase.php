<?php
// allow the autoloader and db to be included from any script that needs it.

if (! defined('PROJECT_ROOT'))
	{
	define ('PROJECT_ROOT', __DIR__);
	define ('PUBLIC_ROOT', __DIR__ . '/www');

	// allow the autoloader to be included from any script that needs it.
	function autoload(string $className) : void
		{
		$path = str_replace('\\', DIRECTORY_SEPARATOR, PROJECT_ROOT . "/{$className}.php");
		if (file_exists($path))
			{
			@include_once $path;
			}
		}

	spl_autoload_register('autoload');
	$errorLogger = new \Example\Tool\ErrorLogging();
	}

date_default_timezone_set('America/New_York');
