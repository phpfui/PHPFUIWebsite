<?php

namespace Example\View\Form;

class Pagination
	{
	private int $center = 0;
	private int $fastForward = 0;
	private int $onPage = 0;

	private \PHPFUI\Page $page;
	private int $totalPages = 10;
	private int $window = 3;

	public function __construct(\PHPFUI\Page $page)
		{
		$this->page = $page;
		}

	public function __toString() : string
		{
		$form = new \PHPFUI\Form($this->page);
		$fieldSet = new \PHPFUI\FieldSet('Change Parameters');
		$of = new \PHPFUI\Input\Number('o', 'Total Pages', $this->totalPages);
		$of->setToolTip('Total pages in view');
		$window = new \PHPFUI\Input\Number('w', 'Page Window', $this->window);
		$window->setToolTip('Number of pages to show on either side of current page');
		$fastForward = new \PHPFUI\Input\Number('ff', 'Fast Forward', $this->fastForward);
		$fastForward->setToolTip('Pages to advance instead of elipse');
		$center = new \PHPFUI\Input\CheckBoxBoolean('c', 'Center', $this->center);
		$center->setToolTip('Check to center the paginator');
		$mc = new \PHPFUI\MultiColumn($of, $window, $fastForward, $center);
		$mc->addClass('align-center-middle');

		$fieldSet->add($mc);
		$form->add($fieldSet);
		$form->add(new \PHPFUI\Submit('Change'));
		$form->setAttribute('method', 'GET');

		return $form;
		}

	public function getCenter() : int
		{
		return $this->center;
		}

	public function getFastForward() : int
		{
		return $this->fastForward;
		}

	public function getOnPage() : int
		{
		return $this->onPage;
		}

	public function getTotalPages() : int
		{
		return $this->totalPages;
		}

	public function getWindow() : int
		{
		return $this->window;
		}

	public function setParameters(array $parameters) : self
		{
		$this->onPage = $parameters['p'] ?? $this->onPage;
		$this->window = $parameters['w'] ?? $this->window;
		$this->totalPages = $parameters['o'] ?? $this->totalPages;
		$this->fastForward = $parameters['ff'] ?? $this->fastForward;
		$this->center = $parameters['c'] ?? $this->center;

		return $this;
		}

	}
