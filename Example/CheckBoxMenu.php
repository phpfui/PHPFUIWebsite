<?php

namespace Example;

class CheckBoxMenu extends \Example\Page
	{
	public function __construct()
		{
		parent::__construct();

		$this->addBody(new \PHPFUI\Header('CheckBoxMenu Example'));
		$this->addBody('Multiple checkboxes as a menu.');

		$post = \PHPFUI\Session::getFlash('post');
		$posted = $post ? json_decode($post, true) : [];

		$form = new \PHPFUI\Form($this);
		$form->setAreYouSure(false);

		$form->add($this->getCheckBoxMenu($form, 'selections', ['A', 'B', 'C', 'D', 'F'], $posted['selections'] ?? []));

		$form->add(new \PHPFUI\Header('Vertical', 4));
		$vertical = $this->getCheckBoxMenu($form, 'options', ['Leather Seats', 'Sunroof', 'Trim', 'Alloy Wheels', 'AWD'], $posted['options'] ?? []);
		$vertical->addClass('vertical');
		$form->add($vertical);

		$this->addBody($form);
		}

	private function getCheckBoxMenu(\PHPFUI\Form $form, string $name, array $options, array $posted) : \PHPFUI\Input\CheckBoxMenu
		{
		$checkBoxMenu = new \PHPFUI\Input\CheckBoxMenu($name);
		$checkBoxMenu->addAll();
		foreach ($options as $index => $item)
			{
			$checkBoxMenu->addCheckBox($item, isset($posted[$index]), $item);
			}
		$checkBoxMenu->addSubmit($form, 'Apply');

		return $checkBoxMenu;
		}
	}

