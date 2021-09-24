<?php

namespace PHPFUI;

class MenuItem extends \PHPFUI\HTML5Element
	{
	private $active = false;

	private $align;

	private $generatedLink;

	private $graphic;

	private $link;

	private $name;

	private $started = false;

	public function __construct(string $name = '', string $link = '')
		{
		parent::__construct('li');
		$this->link = $link;
		$this->name = $name;
		}

	public function getActive() : bool
		{
		return $this->active;
		}

	/**
	 * returns the icon or image if set
	 */
	public function getGraphic(Base $graphic) : Base
		{
		return $this->graphic;
		}

	public function getLink() : string
		{
		return $this->link;
		}

	/**
	 * Get the link as a \PHPFUI\Link from the MenuItem
	 *
	 * Due to the need to be able to add images to a MenuItem, getLink should only be called after the icon or image is set,
	 * otherwise the graphic will not be rendered.
	 */
	public function getLinkObject() : ?Link
		{
		if ($this->generatedLink)
			{
			return $this->generatedLink;
			}

		$name = $this->name;

		if ('' !== $this->link && $this->graphic)
			{
			if (\in_array($this->align, ['right', 'bottom']))
					{
					$name = "<span>{$name}</span> {$this->graphic}";
					}
				else
					{
					$name = "{$this->graphic} <span>{$name}</span>";
					}
			}
		$this->generatedLink = new Link($this->link, $name, false);

		return $this->generatedLink;
		}

	public function getName() : string
		{
		return $this->name;
		}

	public function setActive(bool $active = true) : MenuItem
		{
		$this->active = $active;

		return $this;
		}

	public function setAlignment(string $align) : MenuItem
		{
		$this->align = $align;

		return $this;
		}

	/**
	 * Set a menu graphic other than an icon or image
	 */
	public function setGraphic(Base $graphic) : MenuItem
		{
		$this->graphic = $graphic;

		return $this;
		}

	public function setIcon(IconBase $icon) : MenuItem
		{
		$this->graphic = $icon;

		return $this;
		}

	public function setImage(Image $image) : MenuItem
		{
		$this->graphic = $image;

		return $this;
		}

	public function setLink(string $link) : MenuItem
		{
		$this->link = $link;

		return $this;
		}

	/**
	 * You can set the link object directly if needed to set specific properties
	 */
	public function setLinkObject(Link $linkObject) : MenuItem
		{
		$this->generatedLink = $linkObject;

		return $this;
		}

	public function setName(string $name) : MenuItem
		{
		$this->name = $name;

		return $this;
		}

	protected function getStart() : string
		{
		if (! $this->started)
			{
			$this->started = true;

			if ($this->active)
				{
				$this->addClass('is-active');
				}

			if ($this->link)
				{
				$text = $this->getLinkObject();
				}
			else
				{
				$this->addClass('menu-text');
				$text = $this->name;
				}

			$this->prepend($text);
			}

		return parent::getStart();
		}
	}
