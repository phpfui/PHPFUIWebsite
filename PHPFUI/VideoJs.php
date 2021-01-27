<?php

namespace PHPFUI;

/**
 * A wrapper for VideoJs
 */
class VideoJs extends \PHPFUI\HTML5Element
	{
	private $sources = [];

	public function __construct(\PHPFUI\Interfaces\Page $page)
		{
		parent::__construct('video');
		$page->addStyleSheet('https://vjs.zencdn.net/7.10.2/video-js.css');
		$page->addTailScript('https://vjs.zencdn.net/7.10.2/video.min.js');
		$this->addClass('video-js');
		$this->addAttribute('controls');
		$this->addAttribute('preload', 'auto');
		$this->addAttribute('data-setup', '{}');
		}

	/**
	 * Add a source, type will be prepended with 'video/'.  Missing types will be computed based on path extension.
	 */
	public function addSource(string $path, string $type = '') : self
		{
		if (! $type)
			{
			$index = strrpos($path, '.');

			if ($index)
				{
				$type = substr($path, $index + 1);
				}
			}
		$this->sources[$path] = $type;

		return $this;
		}

	public function getStart() : string
		{
		foreach ($this->sources as $file => $type)
			{
			$source = new \PHPFUI\HTML5Element('source');
			$source->addAttribute('src', $file);
			$source->addAttribute('type', 'video/' . $type);
			$this->add($source);
			}

		$p = new \PHPFUI\HTML5Element('p');
		$p->addClass('vjs-no-js');
		$p->add('To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>');
		$this->add($p);

		return parent::getStart();
		}
	}
