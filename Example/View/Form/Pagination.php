<?php

namespace Example\View\Form;

class Pagination
	{
	private bool $alwaysShow = false;

	private bool $center = false;

	private int $fastForward = 0;

	private int $onPage = 0;

	private int $totalPages = 10;

	private int $window = 3;

	public function __construct(private \PHPFUI\Page $page)
		{
		}

	public function __toString() : string
		{
		$form = new \PHPFUI\Form($this->page);
		$form->setAreYouSure(false);
		$fieldSet = new \PHPFUI\FieldSet('Change Parameters');
		$of = new \PHPFUI\Input\Number('o', 'Total Pages', (string)$this->totalPages);
		$of->setToolTip('Total pages in view');
		$window = new \PHPFUI\Input\Number('w', 'Page Window', (string)$this->window);
		$window->setToolTip('Number of pages to show on either side of current page');
		$fastForward = new \PHPFUI\Input\Number('ff', 'Fast Forward', (string)$this->fastForward);
		$fastForward->setToolTip('Pages to advance instead of elipse');
		$center = new \PHPFUI\Input\CheckBoxBoolean('c', 'Center', $this->center);
		$center->setToolTip('Check to center the paginator');
		$alwaysShow = new \PHPFUI\Input\CheckBoxBoolean('a', 'Always Show', $this->alwaysShow);
		$alwaysShow->setToolTip('Always show paginator even for single page');
		$mc = new \PHPFUI\MultiColumn($of, $window, $fastForward, $center, $alwaysShow);
		$mc->addClass('align-center-middle');

		$fieldSet->add($mc);
		$form->add($fieldSet);
		$form->add(new \PHPFUI\Submit('Change', 'save'));
		$form->setAttribute('method', 'GET');

		return $form;
		}

	public function getCenter() : bool
		{
		return $this->center;
		}

	public function getAlwaysShow() : bool
		{
		return $this->alwaysShow;
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

	/** @param array<string, string> $parameters */
	public function setParameters(array $parameters) : static
		{
		$this->onPage = $parameters['p'] ?? $this->onPage;
		$this->window = $parameters['w'] ?? $this->window;
		$this->totalPages = $parameters['o'] ?? $this->totalPages;
		$this->fastForward = $parameters['ff'] ?? $this->fastForward;
		$this->center = (bool)($parameters['c'] ?? $this->center);
		$this->alwaysShow = (bool)($parameters['a'] ?? $this->alwaysShow);

		return $this;
		}
	}
