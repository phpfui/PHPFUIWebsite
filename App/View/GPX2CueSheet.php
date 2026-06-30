<?php

namespace Example\View;

class GPX2CueSheet
	{
	public function __construct(private \PHPFUI\Page $page, private string $fieldName)
		{
		}

	public function render() : \PHPFUI\Container
		{
		$parameters = \PHPFUI\Session::getFlash('post');

		$container = new \PHPFUI\Container();
		$callout = new \PHPFUI\Callout('info');
		$gpxLink = new \PHPFUI\Link('https://en.wikipedia.org/wiki/GPS_Exchange_Format', 'GPX');
		$PDFLink = new \PHPFUI\Link('https://en.wikipedia.org/wiki/PDF', 'PDF');
		$callout->add("Convert a {$gpxLink} file to a {$PDFLink} version of a Cue Sheet. Drag in a {$gpxLink} file and press Generate to download a {$PDFLink} version of a cue sheet.");
		$container->add($callout);
		$file = new \PHPFUI\Input\File($this->page, $this->fieldName, 'GPX File to convert to a cuesheet. You must remove the existing file to drag in a different file.');
		$file->setAllowedExtensions(['gpx']);
		$file->setRequired();
		$container->add($file);

		$container->add(new \PHPFUI\Input\Text('title', 'Title, or leave blank to use file name', $parameters['title'] ?? ''));

		$radioGroup = new \PHPFUI\Input\RadioGroup('units', 'Distance Units', $parameters['units'] ?? 'Miles');
		$radioGroup->addButton('Miles', 'Miles');
		$radioGroup->addButton('Kilometers', 'Km');
		$container->add($radioGroup);

		return $container;
		}
	}
