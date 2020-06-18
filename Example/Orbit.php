<?php

namespace Example;

class Orbit extends \Example\Page
	{

	public function __construct()
		{
		parent::__construct();

		$this->addBody(new \PHPFUI\Header('Orbit Example'));
		$this->addBody('The native Foundation carousel.');

		$slider = new \PHPFUI\Orbit('Favorite Space Pictures');
		$slider->addImageSlide(new \PHPFUI\Image('/images/orbit/01.jpg', 'Space, the final frontier.'), 'Space, the final frontier.');
		$slider->addImageSlide(new \PHPFUI\Image('/images/orbit/02.jpg', 'Lets Rocket!'), 'Lets Rocket!');
		$slider->addImageSlide(new \PHPFUI\Image('/images/orbit/03.jpg', 'Encapsulating'), 'Encapsulating');
		$slider->addImageSlide(new \PHPFUI\Image('/images/orbit/04.jpg', 'Outta This World'), 'Outta This World');
		$slider->addHTMLSlide($this->getSlide('This is html'));
		$slider->addHTMLSlide($this->getSlide('This is a warning', 'warning'));
		$slider->addHTMLSlide($this->getSlide('This is secondary', 'secondary'));
		$slider->addHTMLSlide($this->getSlide('Warning Will Robinson', 'alert'));
		$this->addBody($slider);
		}

	private function getSlide(string $text, string $class = 'primary') : \PHPFUI\Callout
		{
		$callout = new \PHPFUI\Callout($class);
		$callout->add($text);

		return $callout;
		}

	}
