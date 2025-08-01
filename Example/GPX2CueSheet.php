<?php

namespace Example;

class GPX2CueSheet extends \Example\Page
	{
	public function __construct()
		{
		parent::__construct();

		\PHPFUI\Session::setFlash('post', \json_encode($_POST));
		$fieldName = 'gpxFile';

		if (isset($_FILES[$fieldName]))
			{
			$model = new \Example\Model\GPX($_FILES[$fieldName], $_POST['units'] ?? 'mi');
			$error = $model->validate();

			if ($error)
				{
				\PHPFUI\Session::setFlash('alert', \json_encode($error));
				$this->redirect();

				return;
				}
			$title = empty($_POST['title']) ? $model->getFileName() : $_POST['title'];
			$cuesheetGenerator = new \Example\Report\CueSheet();
			$cuesheetGenerator->generate($model->getData(), $title, $model->getDistance(), $_POST['units'] ?? 'mi', $model->getAscent());
			$cuesheetGenerator->Output('D', \str_replace(' ', '_', $title) . '.pdf', true);

			return;
			}

		$this->addBody(new \PHPFUI\Header('GPX File to Cue Sheet PDF'));
		$form = new \PHPFUI\Form($this);
		$input = new \Example\View\GPX2CueSheet($this, $fieldName);
		$form->add($input->render());
		$form->add('<br>');
		$buttonGroup = new \PHPFUI\ButtonGroup();
		$buttonGroup->addButton(new \PHPFUI\Submit('Upload', 'upload'));
		$form->add($buttonGroup);
		$form->add(new \PHPFUI\FormError());

		$this->addBody($form);
		}
	}
