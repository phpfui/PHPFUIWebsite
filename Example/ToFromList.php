<?php

namespace Example;

class ToFromList extends \Example\Page
	{
	public function __construct()
		{
		parent::__construct();

		$this->addBody(new \PHPFUI\Header('ToFromList Example'));
		$this->addBody('A mobile friendly drag and drop interface for smaller datasets. Use AccordionToFromList for larger lists. ');
		$this->addBody(new \PHPFUI\Link('http://' . $_SERVER['SERVER_NAME'] . '/states.tsv', 'Data Source'));

		$inGroup = $notInGroup = [];
		$model = new \Example\Model\State();
		$name = 'state';
		$post = \PHPFUI\Session::getFlash('post');

		if ($post)
			{
			$posted = json_decode($post, true);
			$inGroup = $model->getSelected($posted[$name . '-in'] ?? []);
			$notInGroup = $model->getSelected($posted[$name . '-out'] ?? []);
			}

		if (0 == count($inGroup) + count($notInGroup))
			{
			$inGroup = $model->getFiltered(static function($stateName) {return strpos(' AEIOU', $stateName[0]);});
			$notInGroup = $model->getFiltered(static function($stateName) {return ! strpos(' AEIOU', $stateName[0]);});
			}

		$toFromList = new \Example\View\StateToFromList($this, $name, $model, $inGroup, $notInGroup);
		$form = new \PHPFUI\Form($this);
		$form->setAreYouSure(false);
		$form->add($toFromList);
		$form->add(new \PHPFUI\Submit('Save'));

		$this->addBody($form);
		}
	}
