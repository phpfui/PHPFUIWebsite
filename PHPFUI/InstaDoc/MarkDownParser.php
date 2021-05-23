<?php

namespace PHPFUI\InstaDoc;

class MarkDownParser
	{
	private $parser;

	public function __construct()
		{
		$this->parser = new \cebe\markdown\GithubMarkdown();
		$this->parser->html5 = true;
		$this->parser->keepListStartNumber = true;
		$this->parser->enableNewlines = true;
		}

	public function fileText(string $filename) : string
		{
		$markdown = @\file_get_contents($filename);

		return $this->text($markdown);
		}

	public function text(string $markdown) : string
		{
		$div = new \PHPFUI\HTML5Element('div');
		$div->addClass('markdown-body');
		$div->add($this->parser->parse($markdown));
		return $div;
		}
	}
