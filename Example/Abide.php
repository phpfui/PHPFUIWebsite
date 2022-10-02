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

		if ($parameters)
			{
			$parameters = \json_decode($parameters, true);
			}
		else
			{
			$parameters = [];
			}
		$abide = new \Example\View\Abide($this, $parameters);
		$form->add($abide->render());
		$buttonGroup = new \PHPFUI\ButtonGroup();
		$buttonGroup->addButton(new \PHPFUI\Submit('Save', 'save'));
		$reveal = new \PHPFUI\Button('Reveal');
		$reveal->addClass('success');
		$this->getReveal($reveal);
		$buttonGroup->addButton($reveal);
		$clear = new \PHPFUI\Reset('Clear');
		$clear->addClass('warning');
		$buttonGroup->addButton($clear);
		$form->add($buttonGroup);
		$this->addBody($form);
		}

	private function getReveal(\PHPFUI\Button $button) : void
		{
		$modal = new \PHPFUI\Reveal($this, $button);
		$modal->addClass('small');
		$form = new \PHPFUI\Form($this);
		$form->setAreYouSure(false);
		$fieldSet = new \PHPFUI\FieldSet('Some More Fields');
		$url = new \PHPFUI\Input\Url('url', 'A valid Url');
		$fieldSet->add($url);
		$monthYear = new \PHPFUI\Input\MonthYear($this, 'date', 'Month and Year');
		$fieldSet->add($monthYear);
		$form->add($fieldSet);
		$buttonGroup = new \PHPFUI\ButtonGroup();
		$submit = new \PHPFUI\Submit('Save', 'save');
		$buttonGroup->addButton($submit);
		$clear = new \PHPFUI\Reset('Clear');
		$clear->addClass('warning');
		$buttonGroup->addButton($clear);
		$buttonGroup->addButton($modal->getCloseButton());
		$form->add($buttonGroup);
		$modal->add($form);
		}
	}
