<?php

namespace PHPFUI;

/**
 * A container to add objects to that will output a fully formed Foundation page.
 */
class Page extends \PHPFUI\VanillaPage implements \PHPFUI\Interfaces\Page
	{
	private $plugins = [];

	private $reveals = [];

	public function __construct()
		{
		parent::__construct();
		$this->setResourcePath('/PHPFUI/');
		$this->addStyleSheet('font-awesome/css/all.min.css');
		$this->setPageName('Created with Foundation');
		$this->addTailScript('jquery.min.js');
		$this->addTailScript('what-input.min.js');
		$this->addTailScript('foundation/js/foundation.min.js');
		$this->addHeadTag('<meta charset="utf-8">');
		$this->addHeadTag('<meta name="viewport" content="width=device-width, initial-scale=1.0" />');
		}

	/**
	 * You can add various plugin default parameters
	 */
	public function addPluginDefault(string $pluginName, string $property, string $value) : Page
		{
		$this->plugins[$pluginName][$property] = $value;

		return $this;
		}

	/**
	 * Add a reveal dialog to the page
	 *
	 * @param Reveal $reveal dialog to store in the page
	 */
	public function addReveal(Reveal $reveal) : Page
		{
		$this->reveals[] = $reveal;

		return $this;
		}

	protected function getStart() : string
		{
		foreach ($this->reveals as &$reveal)
			{
			$this->add("{$reveal}");
			}

		foreach ($this->plugins as $plugin => $options)
			{
			foreach ($options as $name => $value)
				{
				$this->addJavaScriptFirst("Foundation.{$plugin}.defaults.{$name}={$value};");
				}
			}
		$this->addJavaScriptFirst('$(document).foundation();');

		return parent::getStart();
		}
	}
