<?php

namespace PHPFUI;

/**
 * A fancy button with a drop down
 */
class DropDownButton extends \PHPFUI\Button
	{
	private $dropDown;

	private $items = [];

	private $maxLength = 0;

	private $sorted = false;

	/**
	 * Make a drop down button
	 *
	 * @param string $text of the button
	 */
	public function __construct(string $text)
		{
		parent::__construct($text);
		$this->addClass('dropdown');
		}

	public function addLink(string $link, string $name) : DropDownButton
		{
		$this->maxLength = \max($this->maxLength, \strlen($name));

		return $this->addMenuItem(new MenuItem($name, $link));
		}

	public function addMenuItem(MenuItem $item) : DropDownButton
		{
		$this->maxLength = \max($this->maxLength, \strlen($item->getName()));
		$this->items[$item->getName()] = $item;

		return $this;
		}

	/**
	 * Return the number dropdown items
	 */
	public function count() : int
		{
		return \count($this->items);
		}

	/**
	 * Sort the drop down items by name
	 */
	public function sort() : DropDownButton
		{
		$this->sorted = true;

		return $this;
		}

	protected function getEnd() : string
		{
		return parent::getEnd() . $this->dropDown;
		}

	protected function getStart() : string
		{
		if ($this->sorted)
			{
			\ksort($this->items);
			}

		if (! $this->dropDown)
			{
			$this->dropDown = new \PHPFUI\HTML5Element('div');
			$this->addAttribute('data-toggle', $this->dropDown->getId());

			$this->dropDown->addAttribute('style', "width:{$this->maxLength}em;");
			$this->dropDown->addClass('dropdown-pane');
			$this->dropDown->addAttribute('data-dropdown');
			$this->dropDown->addAttribute('data-position', 'bottom');
			$this->dropDown->addAttribute('data-alignment', 'right');

			// hover
			$this->dropDown->addAttribute('data-hover', 'true');
			$this->dropDown->addAttribute('data-hover-pane', 'true');


			$menu = new \PHPFUI\DropDownMenu();
			$menu->computeWidth();

			foreach ($this->items as $item)
				{
				$menu->addMenuItem($item);
				}

			$this->dropDown->add($menu);
			}

		return parent::getStart();
		}
	}
