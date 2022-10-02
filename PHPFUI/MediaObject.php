<?php

namespace PHPFUI;

class MediaObject extends \PHPFUI\HTML5Element
	{
	public function __construct()
		{
		parent::__construct('div');
		$this->addClass('media-object');
		}

	public function addSection(string $content, bool $main = false, string $alignment = '') : static
		{
		$section = new \PHPFUI\HTML5Element('div');
		$section->addClass('media-object-section');

		if ($main)
			{
			$section->addClass('main-section');
			}

		if ($alignment)
			{
			$validAlignments = ['middle',
				'bottom',
				'square',
				'align-self-middle',
				'align-self-bottom', ];

			if (! \in_array($alignment, $validAlignments))
				{
				throw new \Exception(__METHOD__ . ': $alignment must be one of (' . \implode(',', $validAlignments) . ')');
				}

			$section->addClass($alignment);
			}

		$section->add($content);

		$this->add($section);

		return $this;
		}

	public function stackForSmall() : static
		{
		$this->addClass('stack-for-small');

		return $this;
		}
	}
