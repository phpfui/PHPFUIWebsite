<?php

namespace Example;

class RWGPS2CueSheet extends \Example\Page
	{
	public function __construct()
		{
		parent::__construct();

		\PHPFUI\Session::setFlash('post', \json_encode($_POST));
		$fieldName = 'rwgpsUrl';

		if (isset($_POST[$fieldName]) || isset($_GET['id']))
			{
			if (isset($_POST[$fieldName]))
				{
				$url = $_POST[$fieldName];
				$units = $_POST['units'] ?? 'Miles';
				}
			else
				{
				$url = 'https://ridewithgps.com/routes/' . (int)$_GET['id'];
				$units = $_GET['units'] ?? 'Miles';
				}
			$model = new \Example\Model\RWGPS($url, $units);
			$error = $model->validate();

			if ($error)
				{
				\PHPFUI\Session::setFlash('alert', \json_encode($error));
				$this->redirect();

				return;
				}
			$title = $model->getTitle();

			$cuesheetGenerator = new \Example\Report\CueSheet();
			$cuesheetGenerator->generate($model->getData(), $title, $model->getDistance(), $units, $model->getAscent(), $model->getDescent());
			$cuesheetGenerator->Output('D', \str_replace(' ', '_', $title) . '.pdf', true);

			return;
			}

		$this->addBody(new \PHPFUI\Header('RWGPS Route Url to Cue Sheet PDF'));
		$form = new \PHPFUI\Form($this);
		$input = new \Example\View\RWGPS2CueSheet($fieldName);
		$form->add($input->render());
		$form->add('<br>');
		$buttonGroup = new \PHPFUI\ButtonGroup();
		$buttonGroup->addButton(new \PHPFUI\Submit('Download Cue Sheet'));
		$form->add($buttonGroup);
		$form->add(new \PHPFUI\FormError());

		$this->addBody($form);
		}
	}
