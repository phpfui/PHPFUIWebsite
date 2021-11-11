<?php

namespace PHPFUI\Input;

/**
 * Simple wrapper for DateTime input fields
 */
class DateTime extends \PHPFUI\Input\Input
	{
	/**
	 * Construct a DateTime input
	 *
	 * @param \PHPFUIPage $page for needed JS (unused, reserved for
	 *  			future use)
	 * @param string $name of the field
	 * @param string $label defaults to empty
	 * @param ?string $value defaults to empty
	 */
	public function __construct(\PHPFUI\Interfaces\Page $page, string $name, string $label = '', ?string $value = '')
		{
		parent::__construct('datetime-local', $name, $label, $value);
		}
	}
