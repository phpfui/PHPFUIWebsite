<?php

namespace Example;

class Pagination extends \Example\Page
	{

	public function __construct(array $parameters)
		{
		parent::__construct();

		$form = new \Example\View\Form\Pagination($this);
		$form->setParameters($parameters);

		$p = $form->getOnPage();
		$w = $form->getWindow();
		$o = $form->getTotalPages();
		$ff = $form->getFastForward();
		$c = $form->getCenter();
		$this->addBody(new \PHPFUI\Header('Pagination Example'));

		$paginate = new \PHPFUI\Pagination($p, $o, "/Examples/paginate.php?p=PAGE&o={$o}&ff={$ff}&c={$c}&w={$w}");

		if ($c)
			{
			$paginate->center();
			}
		$paginate->setFastForward($ff);
		$paginate->setWindow($w);
		$this->addBody($paginate);

		$this->addBody($form);
		}

	}
