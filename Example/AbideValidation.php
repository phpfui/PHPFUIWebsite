<?php

namespace Example;

class AbideValidation extends \Example\Page
	{

	public function __construct()
		{
		parent::__construct();

		$this->addBody(new \PHPFUI\Header('Abide Validation Example'));
		$form = new \PHPFUI\Form($this);
		$parameters = \PHPFUI\Session::getFlash('post');

		if ($parameters)
			{
			$parameters = json_decode($parameters, true);
			}
		else
			{
			$parameters = [];
			}
		$abide = new \Example\View\AbideValidation($this, $parameters);
		$form->add($abide->render());
		$buttonGroup = new \PHPFUI\ButtonGroup();
		$buttonGroup->addButton(new \PHPFUI\Submit('Save', 'save'));
		$buttonGroup->addButton((new \PHPFUI\Reset('Clear'))->addClass('warning'));
		$form->add($buttonGroup);
		$form->add(new \PHPFUI\FormError());

		$this->addBody($form);
		}

	}
