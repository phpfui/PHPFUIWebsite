<?php

namespace Example\Tool;

class ErrorLogging
	{
	private static ?\Maknz\Slack\Client $client = null;

	/**
	 * @var array<string,bool>
	 */
	private static array $messages = [];

	/**
	 * @var array<string, bool>
	 */
	private static array $pages = [];

	private static ?\Example\Setting\Slack $settings = null;

	public function __construct()
		{
		self::$settings = new \Example\Setting\Slack();
		\register_shutdown_function([self::class, 'check_for_fatal']);
		\set_error_handler([self::class, 'log_error'], \E_ALL);
		\set_exception_handler([self::class, 'log_exception']);
//		\ini_set('display_errors', 'off');
		\error_reporting(\E_ALL);
		}

	/**
	 * Checks for a fatal error, work around for set_error_handler not working on fatal errors.
	 */
	public static function check_for_fatal() : bool
		{
		$error = \error_get_last();

		if ($error && \E_ERROR == $error['type'])
			{
			self::log_error($error['type'], $error['message'], $error['file'], $error['line']);
			}

		return false;
		}

	public static function clearErrorMessages() : void
		{
		self::$messages = [];
		}

	public static function debug(mixed $message, string $location = '') : void
		{
		if (empty(self::$settings->optional('debug')))
			{
			return;
			}

		$bt = \debug_backtrace();

		if (! isset($bt[0]['file']))
			{
			if (\strlen($location))
				{
				$location .= ': ';
				}
			self::sendMessage($location . \print_r($message, true));

			return;
			}
		$src = \file($bt[0]['file']);
		$line = $src[$bt[0]['line'] - 1];
		\preg_match('#' . __FUNCTION__ . '\((.+)\)#', $line, $match);
		$max = \strlen($match[1] ?? '');
		$varname = '';
		$c = 0;

		for ($i = 0; $i < $max; ++$i)
			{
			if ('(' == $match[1][$i])
				{
				++$c;
				}
			elseif (')' == $match[1][$i])
				{
				--$c;
				}

			if ($c < 0)
				{
				break;
				}
			$varname .= $match[1][$i];
			}
		$at = '';

		if (\strlen($location))
			{
			$at = "({$location})";
			}

		self::sendMessage("{$varname} {$at}: " . \print_r($message, true));
		}

	/**
	 * @return array<string>
	 */
	public static function getErrorMessages() : array
		{
		return \array_keys(self::$messages);
		}

	/**
	 * Error handler, passes flow over the exception logger with new ErrorException.
	 */
	public static function log_error(int $num, string $str, string $file, int $line, mixed $context = null) : bool
		{
		self::log_exception(new \ErrorException($str, 0, $num, $file, $line));

		return false;
		}

	/**
	 * Uncaught exception handler.
	 */
	public static function log_exception(\Throwable $e) : bool
		{
		$errorText = $e->getMessage();

		if (isset(self::$messages[$errorText]))
			{
			return false;
			}
		self::$messages[$errorText] = true;

		$link = ($_SERVER['SERVER_NAME'] ?? '') . ($_SERVER['REQUEST_URI'] ?? '');

		// track one error per file if using Slack
		if (self::$client)
			{
			if (isset(self::$pages[$link]) && empty(self::$settings->optional('all')))
				{
				return false;
				}
			self::$pages[$link] = true;
			}

		$file = \str_replace('/', '\\', $e->getFile());
		$dir = \str_replace('/', '\\', PROJECT_ROOT . '\\');
		$file = \str_replace($dir, '', $file);

		$message = "{$errorText};\nFile: {$file}; Line: {$e->getLine()};";

		self::sendMessage($message);

		return false;
		}

	public static function sendMessage(string $message, string $type = 'error') : void
		{
		self::initialize();

		if (! self::$client)
			{
			return;
			}

		try
			{
			$link = ($_SERVER['REQUEST_SCHEME'] ?? 'http') . '://' . ($_SERVER['SERVER_NAME'] ?? 'localhost') . ($_SERVER['REQUEST_URI'] ?? '') . "\n";
			self::$client->send($link . $message);
			}
		catch (\Exception $e)
			{
			}
		}

	public static function warning(string $message) : void
		{
		self::sendMessage($message, 'warning');
		}

	private static function initialize() : void
		{
		if (! self::$client && self::$settings && self::$settings->optional('LoggingWebhook') && \strlen(self::$settings->optional('LoggingWebhook')) > 20)
			{
			$guzzle = new \GuzzleHttp\Client(['connect_timeout' => 1, 'timeout' => 1, 'verify' => false, 'http_errors' => false]);
			self::$client = new \Maknz\Slack\Client(self::$settings->optional('LoggingWebhook'), [], $guzzle);
			}
		}
	}
