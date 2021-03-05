<?php

namespace PHPFUI;

class Menu extends \PHPFUI\HTML5Element
	{
	protected $menuItems = [];

	protected $menuLabels = [];

	protected $sorted = false;

	private $started = false;

	private $type = '';

	public function __construct()
		{
		parent::__construct('ul');
		$this->addClass('menu');
		}

	public function addMenuItem(MenuItem $item) : Menu
		{
		$this->menuItems[$item->getName() . ':' . \count($this->menuItems)] = $item;

		return $this;
		}

	public function addSubMenu(MenuItem $item, Menu $subMenu) : Menu
		{
		$subMenu->addClass('nested');
		$name = $item->getName() . ':' . \count($this->menuItems);
		$this->menuItems[$name] = $subMenu;
		$this->menuLabels[$name] = $item;

		return $this;
		}

	/**
	 * Number of object in this object.  Does not count sub objects.
	 */
	public function count() : int
		{
		return \count($this->menuItems);
		}

	public function getActive() : bool
		{
		foreach ($this->menuItems as $menuItem)
			{
			if ($menuItem->getActive())
				{
				return true;
				}
			}

		return false;
		}

	public function getMenuItems() : array
		{
		return $this->menuItems;
		}

	public function getName()
		{
		return 'Menu';
		}

	/**
	 * Set the active MenuItem by link
	 *
	 * @return bool true if an active link was set
	 */
	public function setActiveLink(string $link) : bool
		{
		foreach ($this->menuItems as &$menuItem)
			{
			if (false !== \strpos($link, $menuItem->getLink()))
				{
				$menuItem->setActive();

				return true;
				}
			}

		return false;
		}

	/**
	 * Set the active MenuItem by name
	 *
	 * @return bool true if an active name was set
	 */
	public function setActiveName(string $name) : bool
		{
		foreach ($this->menuItems as &$menuItem)
			{
			if ($menuItem->getName() == $name)
				{
				$menuItem->setActive();

				return true;
				}
			}

		return false;
		}

	/**
	 * @param string $type must one of top, right, bottom, left
	 */
	public function setIconAlignment(string $type) : Menu
		{
		$types = ['top',
			'right',
			'bottom',
			'left', ];

		if (! \in_array($type, $types))
			{
			throw new Exception(__METHOD__ . ' Error: Icon type {$type} should be one of ' . \implode('', $types));
			}

		$this->addClass('icons');
		$this->addClass('icon-' . $type);
		$this->type = $type;

		return $this;
		}

	/**
	 * Sort the menu by name displayed to the user.
	 */
	public function sort() : Menu
		{
		$this->sorted = true;
		\ksort($this->menuItems);

		return $this;
		}

	protected function getStart() : string
		{
		if (! $this->started)
			{
			$this->started = true;
			$somethingActive = false;

			if ($this->sorted)
				{
				\ksort($this->menuItems);
				}

			foreach ($this->menuItems as $label => $item)
				{
				if ($item instanceof \PHPFUI\MenuItem)
					{
					$somethingActive |= $item->getActive();

					if ($this->type)
						{
						$item->setAlignment($this->type);
						}

					$this->add($item);
					}
				else
					{
					$menuTitle = $this->menuLabels[$label];
					$menuTitle->setLink('#');
					$somethingActive |= $item->getActive();
					$menuTitle->setActive($item->getActive());
					$menuTitle->add($item);
					$this->add($menuTitle);
					}
				}

			if ($somethingActive)
				{
				$this->addClass('is-active');
				}
			}

		return parent::getStart();
		}
	}
