<?php

namespace PHPFUI;

/**
 * A simple BreadCrumbs class that is Countable
 */
class BreadCrumbs extends \PHPFUI\HTML5Element implements \Countable
	{
	protected $links = [];

	private $started = false;

	public function __construct()
		{
		parent::__construct('nav');
		$this->addAttribute('aria-label', 'You are here:');
		}

	/**
	 * Add a crumb
	 *
	 * @param string $text of the breadcrumb
	 * @param string $link when clicked, empty for disabled
	 */
	public function addCrumb(string $text, string $link = '') : BreadCrumbs
		{
		$this->links[$text . '|' . \count($this)] = $link;

		return $this;
		}

	/**
	 * Return the number of crumbs
	 */
	public function count() : int
		{
		return \count($this->links);
		}

	protected function getStart() : string
		{
		if (! $this->started)
			{
			$this->started = true;
			$ul = new UnorderedList();
			$ul->addClass('breadcrumbs');
			$count = \count($this->links);
			$i = 1;

			foreach ($this->links as $text => $link)
				{
				[$text, $junk] = \explode('|', $text);

				if ($count == $i)
					{
					$item = new ListItem("<span class='show-for-sr'>Current: </span>{$text}");
					}
				elseif ($link)
					{
					$a = new HTML5Element('a');
					$a->add($text);
					$a->addAttribute('href', $link);
					$item = new ListItem($a);
					}
				else
					{
					$item = new ListItem($text);
					$item->addClass('disabled');
					}

				$ul->add($item);
				++$i;
				}

			$this->add($ul);
			}

		return parent::getStart();
		}
	}
