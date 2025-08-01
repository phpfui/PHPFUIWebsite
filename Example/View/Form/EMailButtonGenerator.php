<?php

namespace Example\View\Form;

class EMailButtonGenerator
	{
	private \PHPFUI\EMailButton $button;

	private \PHPFUI\Form $form;

	private \PHPFUI\Input\Text $title;

	private \PHPFUI\Input\Url $url;

	private \Example\View\WebFont $font;

	private \PHPFUI\Input\Number $fontSize;

	private \PHPFUI\Input\Color $color;

	private \PHPFUI\Input\Color $backgroundColor;

	private \PHPFUI\Input\Color $borderColor;

	private \PHPFUI\Input\Number $height;

	private \PHPFUI\Input\Number $width;

	private \PHPFUI\Input\Number $radius;

	public function __construct(private \Example\Page $page, string $title, string $link)
		{
		$this->button = new \PHPFUI\EMailButton($title, $link);

		$this->form = new \PHPFUI\Form($page);
		$this->form->setAttribute('method', 'GET');

		$fieldSet = new \PHPFUI\FieldSet('Required Fields');
		$this->title = new \PHPFUI\Input\Text('t', 'Button Text', $title);
		$this->title->setRequired();
		$this->url = new \PHPFUI\Input\Url('l', 'Link', $link);
		$this->url->setRequired();
		$fieldSet->add(new \PHPFUI\MultiColumn($this->title, $this->url));

		$this->form->add($fieldSet);

		$fieldSet = new \PHPFUI\FieldSet('Colors');
		$this->color = new \PHPFUI\Input\Color('c', 'Color');
		$this->backgroundColor = new \PHPFUI\Input\Color('bc', 'Background Color');
		$this->borderColor = new \PHPFUI\Input\Color('brd', 'Border Color');
		$fieldSet->add(new \PHPFUI\MultiColumn($this->color, $this->backgroundColor, $this->borderColor));
		$this->form->add($fieldSet);

//		public function setBackgroundImage(string $backgroundImage) : static

		$fieldSet = new \PHPFUI\FieldSet('Appearance');
		$this->font = new \Example\View\WebFont('f', 'Font');
		$this->fontSize = new \PHPFUI\Input\Number('fs', 'Font Size');
		$fieldSet->add(new \PHPFUI\MultiColumn($this->font, $this->fontSize));
		$this->height = new \PHPFUI\Input\Number('h', 'Button Height');
		$this->width = new \PHPFUI\Input\Number('w', 'Button Width');
		$this->radius = new \PHPFUI\Input\Number('r', 'Button Radius');
		$fieldSet->add(new \PHPFUI\MultiColumn($this->height, $this->width, $this->radius));

		$this->form->add($fieldSet);
		$buttonGroup = new \PHPFUI\ButtonGroup();
		$buttonGroup->addButton(new \PHPFUI\Submit('Generate'));
		$defaults = new \PHPFUI\Button('Defaults', $this->page->getBaseUrl());
		$defaults->addClass('secondary');
		$buttonGroup->addButton($defaults);
		$this->form->add($buttonGroup);

		$fieldSet = new \PHPFUI\FieldSet('Generated Button');
		$copyButton = new \PHPFUI\Button('Copy HTML');
		$copyButton->addClass('warning');
		$copied = new \PHPFUI\Button('Copied!');
		$copied->addClass('success')->addClass('hollow');

		$this->page->addCopyToClipboard((string)$this->button, $copyButton, $copied);
		$fieldSet->add(new \PHPFUI\MultiColumn($this->button, $copyButton, $copied));
		$this->form->add($fieldSet);
		}

	public function __toString() : string
		{
		return (string)$this->form;
		}

	public function setBackgroundColor(string $backgroundColor) : static
		{
		$this->backgroundColor->setValue($backgroundColor);
		$this->button->setBackgroundColor($backgroundColor);

		return $this;
		}

	public function setBackgroundImage(string $backgroundImage) : static
		{
//		$this->button->setBackgroundImage($backgroundImage);

		return $this;
		}

	public function setBorderColor(string $borderColor) : static
		{
		$this->borderColor->setValue($borderColor);
		$this->button->setBorderColor($borderColor);

		return $this;
		}

	public function setColor(string $color) : static
		{
		$this->color->setValue($color);
		$this->button->setColor($color);

		return $this;
		}

	public function setFont(string $font) : static
		{
		$this->font->select($font);
		$this->button->setFont($font);

		return $this;
		}

	public function setFontSize(int $fontSize) : static
		{
		$this->fontSize->setValue("{$fontSize}");
		$this->button->setFontSize($fontSize);

		return $this;
		}

	public function setHeight(int $height) : static
		{
		$this->height->setValue("{$height}");
		$this->button->setHeight($height);

		return $this;
		}

	public function setRadius(int $radius) : static
		{
		$this->radius->setValue("{$radius}");
		$this->button->setRadius($radius);

		return $this;
		}

	public function setWidth(int $width) : static
		{
		$this->width->setValue("{$width}");
		$this->button->setWidth($width);

		return $this;
		}
	}
