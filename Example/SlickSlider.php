<?php

namespace Example;

class SlickSlider extends \Example\Page
	{

	public function __construct()
		{
		parent::__construct();

		$this->addBody(new \PHPFUI\Header('Slick Slider Example'));
		$this->addBody('A PHPFUI wrapper around the JavaScript carousel ' . new \PHPFUI\Link('https://kenwheeler.github.io/slick/', 'Slick Slider'));

		$slider = new \PHPFUI\SlickSlider($this);
		$slider->addImage('/images/orbit/01.jpg', 'Space, the final frontier.');
		$slider->addImage('/images/orbit/02.jpg', 'Lets Rocket!');
		$slider->addImage('/images/orbit/03.jpg', 'Encapsulating');
		$slider->addImage('/images/orbit/04.jpg', 'Outta This World');
		$slider->addSlide($this->getSlide('This is html'));
		$slider->addSlide($this->getSlide('This is a warning', 'warning'));
		$slider->addSlide($this->getSlide('This is secondary', 'secondary'));
		$slider->addSlide($this->getSlide('Warning Will Robinson', 'alert'));

		$view = new \Example\View\SlickSlider($this);
		$parameters = \PHPFUI\Session::getFlash('parameters');
		if ($parameters)
			{
			$view->setParameters();
			}
		foreach ($view->getParameters() as $attribute => $value)
			{
			$slider->addSliderAttribute($attribute, $value);
			}
		$this->addBody($slider);
		$this->addBody($view->render());
		}

	private function getSlide(string $text, string $class = 'primary') : string
		{
		$callout = new \PHPFUI\Callout($class);
		$callout->add($text);

		return $callout;
		}

	}
