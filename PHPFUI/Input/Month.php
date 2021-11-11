<?php

namespace PHPFUI\Input;

/**
 * Simple wrapper for Month input fields
 */
class Month extends \PHPFUI\Input\Input
	{
	/**
	 * Construct a Month input
	 *
	 * @param string $name of the field
	 * @param string $label defaults to empty
	 * @param ?string $value defaults to empty
	 */
	public function __construct(string $name, string $label = '', ?string $value = '')
		{
		parent::__construct('month', $name, $label, $value);
		}
	}
