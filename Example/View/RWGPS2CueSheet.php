<?php

namespace Example\View;

class RWGPS2CueSheet
	{
	public function __construct(private string $fieldName)
		{
		}

	public function render() : \PHPFUI\Container
		{
		$parameters = \PHPFUI\Session::getFlash('post');

		$container = new \PHPFUI\Container();
		$callout = new \PHPFUI\Callout('info');
		$rwgpsLink = new \PHPFUI\Link('https://ridewithgps.com', 'Ride With GPS Route');
		$PDFLink = new \PHPFUI\Link('https://en.wikipedia.org/wiki/PDF', 'PDF');
		$callout->add("Convert a {$rwgpsLink} url to a {$PDFLink} version of a CueSheet.");
		$container->add($callout);
		$url = new \PHPFUI\Input\Url($this->fieldName, 'Ride With GPS Route link to convert to a cuesheet.');
		$url->setRequired();
		$container->add($url);

		$radioGroup = new \PHPFUI\Input\RadioGroup('units', 'Distance Units', $parameters['units'] ?? 'Miles');
		$radioGroup->addButton('Miles', 'Miles');
		$radioGroup->addButton('Kilometers', 'Km');
		$container->add($radioGroup);

		return $container;
		}
	}
