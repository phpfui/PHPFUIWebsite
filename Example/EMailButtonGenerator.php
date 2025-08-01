<?php

namespace Example;

class EMailButtonGenerator extends \Example\Page
	{
	/**
	 * @param array<string,string> $parameters
	 */
	public function __construct(array $parameters)
		{
		parent::__construct();

		$form = new \Example\View\Form\EMailButtonGenerator($this, $parameters['t'] ?? 'Click Me', $parameters['l'] ?? 'https://www.google.com');

		$form->setBackgroundColor($parameters['bc'] ?? '#03adfc');
		$form->setBackgroundImage($parameters['img'] ?? '');
		$form->setBorderColor($parameters['brd'] ?? '#000000');
		$form->setColor($parameters['c'] ?? '#ffffff');
		$form->setFont($parameters['f'] ?? 'Ariel');
		$form->setFontSize((int)($parameters['fs'] ?? 20));
		$form->setHeight((int)($parameters['h'] ?? 50));
		$form->setRadius((int)($parameters['r'] ?? 5));
		$form->setWidth((int)($parameters['w'] ?? 100));

		$this->addBody(new \PHPFUI\Header('EMail Button Generator'));

		$this->addBody($form);
		}
	}
