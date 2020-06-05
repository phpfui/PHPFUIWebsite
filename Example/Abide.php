<?php

namespace Example;

class Abide extends \Example\Page
	{

	public function __construct()
		{
		parent::__construct();

		$this->addBody(new \PHPFUI\Header('Abide Example'));
		$form = new \PHPFUI\Form($this);
		$parameters = \PHPFUI\Session::getFlash('post');

		if (! is_array($parameters))
			{
			$parameters = [];
			}
		$abide = new \Example\View\Abide($this, $parameters);
		$form->add($abide->render());
		$form->add(new \PHPFUI\Submit('Save'));
		$this->addBody($form);
		}

	}
