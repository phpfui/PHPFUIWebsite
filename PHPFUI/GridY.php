<?php

namespace PHPFUI;

/**
 * Simple wrapper for grid-y
 */
class GridY extends HTML5Element
	{

	/**
	 * Construct a GridY element.
	 */
	public function __construct(string $height)
		{
		parent::__construct('div');
		$this->addClass('grid-y');
		$this->addAttribute('style', "height:{$height};");
		}

	public function setMargin() : GridY
		{
		$this->addClass('grid-margin-y');

		return $this;
		}
	}