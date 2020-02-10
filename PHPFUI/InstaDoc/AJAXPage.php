<?php

namespace PHPFUI\InstaDoc;

class AJAXPage extends \PHPFUI\Container implements PageInterface
	{
	private $controller;
	private $generating = '';

	public function __construct(Controller $controller)
		{
		$this->controller = $controller;
		}

	public function addBody($item) : PageInterface
		{
		$this->add($item);

		return $this;
		}

	public function create(\PHPFUI\Menu $menu) : void
		{
		}

	public function setGenerating(string $generating) : PageInterface
		{
		$this->generating = $generating;

		return $this;
		}

	public function setHomeUrl(string $url) : PageInterface
		{
		return $this;
		}

	}
