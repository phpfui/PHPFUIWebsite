<?php

namespace Example;

class RWGPS2CueSheet extends \Example\Page
	{
	public function __construct()
		{
		parent::__construct();

		\PHPFUI\Session::setFlash('post', \json_encode($_POST));
		$fieldName = 'rwgpsUrl';

		if (isset($_POST[$fieldName]))
			{
			$model = new \Example\Model\RWGPS($_POST[$fieldName], $_POST['units'] ?? 'mi');
			$error = $model->validate();

			if ($error)
				{
				\PHPFUI\Session::setFlash('alert', \json_encode($error));
				$this->redirect();

				return;
				}
			$title = $model->getTitle();

			$cuesheetGenerator = new \Example\Report\CueSheet();
			$cuesheetGenerator->generate($model->getData(), $title, $model->getDistance(), $_POST['units'] ?? 'mi', $model->getAscent(), $model->getDescent());
			$cuesheetGenerator->Output('D', \str_replace(' ', '_', $title) . '.pdf', true);

			return;
			}

		$this->addBody(new \PHPFUI\Header('RWGPS Route Url to Cue Sheet PDF'));
		$form = new \PHPFUI\Form($this);
		$input = new \Example\View\RWGPS2CueSheet($fieldName);
		$form->add($input->render());
		$form->add('<br>');
		$buttonGroup = new \PHPFUI\ButtonGroup();
		$buttonGroup->addButton(new \PHPFUI\Submit('Download CueSheet'));
		$form->add($buttonGroup);
		$form->add(new \PHPFUI\FormError());

		$this->addBody($form);
		}
	}
