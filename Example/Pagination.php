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
		$a = $form->getAlwaysShow();
		$this->addBody(new \PHPFUI\Header('Pagination Example'));

		$paginate = new \PHPFUI\Pagination($p, $o, "/Examples/Pagination.php?p=PAGE&o={$o}&ff={$ff}&c={$c}&w={$w}&a={$a}");

		if ($c)
			{
			$paginate->center();
			}
		$paginate->alwaysShow($a);
		$paginate->setFastForward($ff);
		$paginate->setWindow($w);
		$this->addBody($paginate);

		$this->addBody($form);
		}

	}
