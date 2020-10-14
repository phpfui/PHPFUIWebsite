<?php
// allow the autoloader and db to be included from any script that needs it.

error_reporting(E_ALL);

define ('PROJECT_ROOT', __DIR__);

// allow the autoloader and db to be included from any script that needs it.
function classNameExists($className)
	{
	$dir = (strpos($className, '\\') === false) ? '\\NoNameSpace\\' : '\\';
	$path = PROJECT_ROOT . $dir . "{$className}.php";
	$path = str_replace('\\', DIRECTORY_SEPARATOR, $path);

	return file_exists($path) ? $path : '';
	}

function autoload($className)
	{
	$path = classNameExists($className);
	if ($path)
		{
		/** @noinspection PhpIncludeInspection */
		include $path;
		}
	}

spl_autoload_register('autoload');

date_default_timezone_set('America/New_York');
