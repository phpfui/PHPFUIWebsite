<?php

namespace PHPFUI\InstaDoc\Section;

class File extends \PHPFUI\InstaDoc\Section
	{

	public function generate(\PHPFUI\InstaDoc\PageInterface $page, string $fullClassPath) : \PHPFUI\Container
		{
		$container = new \PHPFUI\Container();

		$fullClassPath = str_replace('\\', '/', $fullClassPath);

		if (! file_exists($fullClassPath))
			{
			$fullClassPath = $this->controller->getGitFileOffset() . $fullClassPath;
			}
		$ts = $this->controller->getParameter(\PHPFUI\InstaDoc\Controller::TAB_SIZE, 2);

		$page->addCSS("code{tab-size:{$ts};-moz-tab-size:{$ts}}");
		$php = @file_get_contents($fullClassPath);
		$pre = new \PHPFUI\HTML5Element('pre');

		$css = $this->controller->getParameter(\PHPFUI\InstaDoc\Controller::CSS_FILE, 'qtcreator_dark');

		if ('PHP' != $css)
			{
//			$page->addStyleSheet("highlighter/styles/{$css}.css");

			$highlighter = new \FSHL\Highlighter(new \FSHL\Output\Html());
			$highlighter->setLexer(new \FSHL\Lexer\Php());

			// Highlight some code.
			$code = new \PHPFUI\HTML5Element('div');
			$code->add($highlighter->highlight($php));
			$pre->add($code);
			}
		else
			{
			$pre->add(highlight_string($php, true));
			}
		$container->add($pre);

		return $container;
		}
	}
