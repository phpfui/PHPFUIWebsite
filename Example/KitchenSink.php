<?php

namespace Example;

class KitchenSink extends \Example\Page
	{

	private \PHPFUI\Menu $magellanMenu;
	private \Highlight\Highlighter $hl;
	private \PHPFUI\HTML5Element $sections;

	public function __construct()
		{
		parent::__construct();
		$this->hl = new \Highlight\Highlighter();
		$this->sections = new \PHPFUI\HTML5Element('div');

		$this->addBody(new \PHPFUI\Header('Kitchen Sink', 1));
		$this->addBody(new \PHPFUI\Header('Everything but.', 5));
		$foundation = new \PHPFUI\Link('https://get.foundation/sites/docs/kitchen-sink.html', 'Loosely based on Foundation\'s Kitchen Sink');
		$this->addStyleSheet('https://cdn.jsdelivr.net/npm/motion-ui@1.2.3/dist/motion-ui.min.css');
		$this->addBody($foundation);

		$this->addStyleSheet('highlighter/styles/Vs.css');
		$copyArea = new \PHPFUI\HTML5Element('textarea');
		$copyArea->addClass('hide');
		$this->addBody($copyArea);

		$js = 'function copyCode(button,code){var copyArea=$("#' . $copyArea->getId() .
			'");var text=button.text();button.text("Copied!");copyArea.val(code.text()).toggleClass("hide").select();document.execCommand("copy");copyArea.toggleClass("hide");setTimeout(function(){button.text(text)},2000)}';
		$this->addJavaScript($js);

		$this->sections->addClass('sections');
		$this->addBody($this->sections);

		$this->getAccordion();
 		$this->getAccordionMenu();
		$this->getBadge();
		$this->getBreadcrumbs();
		$this->getButton();
		$this->getCallout();
		$this->getCard();
		$this->getCloseButton();
		$this->getDebugExample();
		$this->getDrilldownMenu();
		$this->getDropdownButton();
		$this->getDropdownMenu();
		$this->getDropdownPane();
		$this->getEqualizer();
		$this->getForms();
		$this->getHeader();
		$this->getIcon();
		$this->getLabel();
		$this->getMediaObject();
		$this->getMenuExample();
		$this->getOrbit();
		$this->getPagination();
		$this->getProgressBar();
		$this->getResponsiveMenu();
		$this->getResponsiveEmbed();
		$this->getReveal();
		$this->getSlider();
		$this->getSplitButton();
		$this->getSwitch();
		$this->getSwitchRadio();
		$this->getTable();
		$this->getTabs();
		$this->getThumbnail();
		$this->getTitleBar();
		$this->getToggler();
		$this->getTooltip();
		$this->getTopBar();
		}

	private function getAccordion() : void
		{
		$this->section('Accordion', <<<'PHP'
$accordion = new \PHPFUI\Accordion();
$accordion->addTab('Accordion 1', '<p>Panel 1. Lorem ipsum dolor</p><a href="#">Nowhere to Go</a>');
$textArea = new \PHPFUI\Input\TextArea('', '');
$button = new \PHPFUI\Button('I do nothing!');
$accordion->addTab('Accordion 2', $textArea . $button);
$accordion->addTab('Accordion 3', new \PHPFUI\Input\Text('name', 'Type your name!'));
return $accordion;
PHP);
		}

	private function getAccordionMenu() : void
		{
		$this->section('Accordion Menu', <<<'PHP'
return $this->makeMenu(new \PHPFUI\AccordionMenu(), 'Accordion Menu', '', $this->subMenu());
PHP);
		}

	private function getBadge() : void
		{
		$this->section('Badge', <<<'PHP'
$container = new \PHPFUI\Container();

$primaryBadge = new \PHPFUI\Badge('1');
$primaryBadge->addClass('primary');
$container->add($primaryBadge);

$secondaryBadge = new \PHPFUI\Badge('2');
$secondaryBadge->addClass('secondary');
$container->add($secondaryBadge);

$successBadge = new \PHPFUI\Badge('3');
$successBadge->addClass('success');
$container->add($successBadge);

$alertBadge = new \PHPFUI\Badge('A');
$alertBadge->addClass('alert');
$container->add($alertBadge);

$warningBadge = new \PHPFUI\Badge('B');
$warningBadge->addClass('warning');
$container->add($warningBadge);

return $container;
PHP);
		}

	private function getBreadcrumbs() : void
		{
		$this->section('Breadcrumbs', <<<'PHP'
$breadCrumbs = new \PHPFUI\BreadCrumbs();
$breadCrumbs->addCrumb('Home', '#');
$breadCrumbs->addCrumb('Features', '#');
$breadCrumbs->addCrumb('Gene Splicing');
$breadCrumbs->addCrumb('Cloning');

return $breadCrumbs;
PHP);
		}

	private function getButton() : void
		{
		$this->section('Button', <<<'PHP'
$container = new \PHPFUI\Container();

$container->add(new \PHPFUI\Button('Learn More', '#0'));
$container->add(new \PHPFUI\Button('View All Features', '#features'));

$save = new \PHPFUI\Button('Save');
$save->addClass('success');
$container->add($save);

$save = new \PHPFUI\Button('Delete');
$save->addClass('alert');
$container->add($save);

$tiny = new \PHPFUI\Button('So Tiny', '#0');
$tiny->addClass('tiny');
$container->add($tiny);

$small = new \PHPFUI\Button('So Small', '#0');
$small->addClass('small');
$container->add($small);

$large = new \PHPFUI\Button('So Large', '#0');
$large->addClass('large');
$container->add($large);

$expand = new \PHPFUI\Button('Such Expand', '#0');
$expand->addClass('expanded');
$container->add($expand);

$group = new \PHPFUI\ButtonGroup();
$group->addButton(new \PHPFUI\Button('One'));
$group->addButton(new \PHPFUI\Button('Two'));
$group->addButton(new \PHPFUI\Button('Three'));
$container->add($group);

return $container;
PHP);
		}

	private function getCallout() : void
		{
		$this->section('Callout', <<<'PHP'
$container = new \PHPFUI\Container();

foreach (['', 'primary', 'secondary', 'success', 'warning', 'alert'] as $type)
 	{
 	$callout = new \PHPFUI\Callout($type);
 	$callout->add(new \PHPFUI\Header("This is a {$type} callout.", 4));
 	$callout->add('<p>It has an easy to override visual style, and is appropriately subdued.</p>');
 	$callout->add(new \PHPFUI\Link('#', "It's dangerous to go alone, take this."));
 	$container->add($callout);
 	}

return $container;
PHP);
		}

	private function getCard() : void
		{
		$this->section('Card', <<<'PHP'
$card = new \PHPFUI\Card();
$card->addAttribute('style', 'width: 300px');
$card->addDivider(new \PHPFUI\Header("I'm featured", 4));
$card->addImage(new \PHPFUI\Image('/images/rectangle-1.jpg'));
$card->addSection('This card makes use of the card-divider element.');

return $card;
PHP);
		}

	private function getCloseButton() : void
		{
		$this->section('Close Button', <<<'PHP'
$container = new \PHPFUI\Container();

$closeBox = new \PHPFUI\Callout();
$close = new \PHPFUI\CloseButton($closeBox);
$closeBox->add('<p>You can so totally close this!</p>');
$closeBox->add($close);
$container->add($closeBox);

$closeBox = new \PHPFUI\Callout();
$closeBox->addClass('success');
$close = new \PHPFUI\CloseButton($closeBox, 'slide-out-right');
$closeBox->add('<p>You can close me too, and I close using a Motion UI animation.</p>');
$closeBox->add($close);
$container->add($closeBox);

return $container;
PHP);
		}

	private function getDebugExample() : void
		{
		$this->section('Debug', <<<'PHP'
$container = new \PHPFUI\Container();
return new \PHPFUI\Debug($container, 'Debug $this!');
PHP);
		}

	private function getDrilldownMenu() : void
		{
		$this->section('Drilldown Menu', <<<'PHP'
$container = new \PHPFUI\Container();

$container->add($this->makeMenu(new \PHPFUI\DrillDownMenu(), 'Drill Down Menu', '', $this->subMenu()));

$drillDown = $this->makeMenu(new \PHPFUI\DrillDownMenu(), 'Drill Down Menu Auto Height', '', $this->subMenu());
$drillDown->setAutoHeight();
$container->add($drillDown);

return $container;
PHP);
		}

	private function getDropdownButton() : void
		{
		$this->section('Dropdown Button', <<<'PHP'
$dropDownButton = new \PHPFUI\DropDownButton('Drop Down Button');
$dropDownButton->addMenuItem(new \PHPFUI\MenuItem('Option 4', '#'));
$dropDownButton->addMenuItem(new \PHPFUI\MenuItem('Option 3', '#'));
$dropDownButton->addMenuItem(new \PHPFUI\MenuItem('Option 5', '#'));
$dropDownButton->addMenuItem(new \PHPFUI\MenuItem('Option 1', '#'));
$dropDownButton->addMenuItem(new \PHPFUI\MenuItem('Option 2', '#'));
$dropDownButton->sort();

return $dropDownButton;
PHP);
		}

	private function getDropdownMenu() : void
		{
		$this->section('Dropdown Menu', <<<'PHP'
$container = new \PHPFUI\Container();

$container->add($this->makeMenu(new \PHPFUI\DropDownMenu(), 'Drop Down Menu', '', $this->subMenu()));
$dropDown = $this->makeMenu(new \PHPFUI\DropDownMenu(), 'Drop Down Menu Vertical', 'vertical', $this->subMenu());
$dropDown->computeWidth();
$container->add($dropDown);

return $container;
PHP);
		}

	private function getDropdownPane() : void
		{
		$this->section('Dropdown Pane', <<<'PHP'
$container = new \PHPFUI\Container();

$toggleDropdownButton = new \PHPFUI\Button('Toggle Dropdown');
$panel = new \PHPFUI\HTML5Element('div');
$panel->add('Just some junk that needs to be said. Or not. Your choice.');

$toggleDropdown = new \PHPFUI\DropDown($toggleDropdownButton, $panel);
$container->add($toggleDropdown);

$hoverDropdownButton = new \PHPFUI\Button('Hoverable Dropdown');
$panel = new \PHPFUI\HTML5Element('div');
$panel->add('Just some junk that needs to be said. Or not. Your choice.');

$hoverDropdown = new \PHPFUI\DropDown($hoverDropdownButton, $panel);
$hoverDropdown->setHover();
$container->add($hoverDropdown);

return $container;
PHP);
		}

	private function getEqualizer() : void
		{
		$this->section('Equalizer', <<<'PHP'
$innerEqualizer = new \PHPFUI\Equalizer(new \PHPFUI\Callout());
$co1 = new \PHPFUI\Callout('primary');
$co1->add('This is a callout');
$co2 = new \PHPFUI\Callout('warning');
$co2->add('Warning Will Robinson');
$co3 = new \PHPFUI\Callout('error');
$co3->add('Stack Overflow with much more text and it just keeps going and going.  I wish there was some way to autogenerate text in PHP.');
$innerEqualizer->addElement(new \PHPFUI\Image('/images/square-1.jpg'));
//$innerEqualizer->addElement($co2);
//$innerEqualizer->addElement($co3);

$equalizer = new \PHPFUI\Equalizer();
$co2 = new \PHPFUI\Callout();
$co2->add('Pellentesque habitant morbi tristique senectus et netus et, ante.');
$co3 = new \PHPFUI\Callout();
$co3->add(new \PHPFUI\Image('/images/rectangle-1.jpg'));
$equalizer->addColumn($innerEqualizer);
$equalizer->addColumn($co2);
$equalizer->addColumn($co3);

return $equalizer;
PHP);
		}

	private function getHeader() : void
		{
		$this->section('Header', <<<'PHP'
$container = new \PHPFUI\Container();
for ($i = 1; $i <= 6; ++$i)
	{
	$container->add(new \PHPFUI\Header('Header ' . $i, $i));
	}

return $container;
PHP);
		}

	private function getForms() : void
		{
		$this->section('Forms', <<<'PHP'
$container = new \PHPFUI\Container();

$input = new \PHPFUI\Input\Text('inputLabel', 'Input Label');
$helpText = new \PHPFUI\HTML5Element('p');
$helpText->add("Here's how you use this input field!");
$helpText->addClass('help-text');
$input->addAttribute('placeholder', '.small-12.columns');
$input->addAttribute('aria-describedby', $helpText->getId());
$container->add($input);
$container->add($helpText);

$container->add(new \PHPFUI\Input\Number('puppies', 'How many puppies?', 100));
$books = new \PHPFUI\Input\TextArea('books', 'What books did you read over summer break?');
$books->addAttribute('placeholder', 'None');
$container->add($books);

$selectMenu = new \PHPFUI\Input\Select('menu', 'Select Menu');
$selectMenu->addOption('Husker', 'husker');
$selectMenu->addOption('Starbuck', 'starbuck');
$selectMenu->addOption('Hot Dog', 'hotdog');
$selectMenu->addOption('Apollo', 'apollo');
$container->add($selectMenu);

$color = new \PHPFUI\Input\RadioGroup('color', 'Choose Your Favorite');
$color->addButton('Red');
$color->addButton('Blue');
$color->addButton('Yellow');

$checkBoxes = new \PHPFUI\CheckBoxGroup('Check these out');
for ($i = 1; $i <= 3; ++$i)
	{
	$checkBoxes->addCheckBox(new \PHPFUI\Input\CheckBoxBoolean('cb' . $i, 'Checkbox ' . $i));
	}
$container->add(new \PHPFUI\MultiColumn($color, $checkBoxes));

$inputGroup = new \PHPFUI\InputGroup();
$inputGroup->addLabel('$');
$inputGroup->addInput(new \PHPFUI\Input\Text('currency', ''));
$inputGroup->addButton(new \PHPFUI\Submit('Submit'));
$container->add($inputGroup);

return $container;
PHP);
		}

	private function getIcon() : void
		{
		$this->section('Icon', <<<'PHP'
$container = new \PHPFUI\Container();

$iconPlain = new \PHPFUI\Icon('edit');
$container->add($iconPlain);
$iconPlainTip = new \PHPFUI\Icon('edit');
$iconPlainTip->setTooltip('I am a plain icon with a tooltip');
$container->add($iconPlainTip);
$iconLink = new \PHPFUI\Icon('edit', '#');
$container->add($iconLink);
$iconLinkTip = new \PHPFUI\Icon('edit', '#');
$iconLinkTip->setTooltip('I can even have a tooltip and a link!');
$container->add($iconLinkTip);

return $container;
PHP);
		}

	private function getLabel() : void
		{
		$this->section('Label', <<<'PHP'
$container = new \PHPFUI\Container();

$label = new \PHPFUI\Label('Primary Label');
$label->addClass('primary');
$container->add($label);

$label = new \PHPFUI\Label('Secondary Label');
$label->addClass('secondary');
$container->add($label);

$label = new \PHPFUI\Label('Success Label');
$label->addClass('success');
$container->add($label);

$label = new \PHPFUI\Label('Alert Label');
$label->addClass('alert');
$container->add($label);

$label = new \PHPFUI\Label('Warning Label');
$label->addClass('warning');
$container->add($label);

return $container;
PHP);
		}

	private function getMediaObject() : void
		{
		$this->section('Menu', <<<'PHP'
$mediaObject = new \PHPFUI\MediaObject();
$image = new \PHPFUI\Image('/images/people.jpg');
$mediaObject->addSection("{$image}");
$header = new \PHPFUI\Header("Dreams feel real while we're in them.", 4);
$p = new \PHPFUI\HTML5Element('p');
$p->add("I'm going to improvise. Listen, there's something you should know about me... about inception. An idea is like a virus, resilient, highly contagious. The smallest seed of an idea can grow. It can grow to define or destroy you.");
$mediaObject->addSection($header . $p);

return $mediaObject;
PHP);
		}

	private function getMenuExample() : void
		{
		$this->section('Menu', <<<'PHP'
$container = new \PHPFUI\Container();

$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu'));
$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu Right', 'align-right'));
$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu Center', 'align-center'));
$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu Expanded', 'expanded'));
$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu Vertical', 'vertical'));
$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu Vertical Right', 'vertical align-right'));
$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu Vertical Center', 'vertical align-center'));
$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu Simple', 'simple'));

return $container;
PHP);
		}

	private function getOrbit() : void
		{
		$this->section('Orbit', <<<'PHP'
$orbit = new \PHPFUI\Orbit('Some out of the world images');
$orbit->addImageSlide(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/orbit/01.jpg'), 'Space, the final frontier.');
$orbit->addImageSlide(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/orbit/02.jpg'), 'Lets Rocket!', true);
$orbit->addImageSlide(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/orbit/03.jpg'), 'Encapsulating');
$orbit->addImageSlide(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/orbit/04.jpg'), 'Outta This World');

return $orbit;
PHP);
		}

	private function getOffCanvas() : void
		{
		$this->section('Off Canvas', <<<'PHP'
$container = new \PHPFUI\Container();

$main = new \PHPFUI\HTML5Element('div');
$main->add('This is the main content for the off canvas');

$offCanvas = new \PHPFUI\OffCanvas($main);

$off = new \PHPFUI\HTML5Element('div');
$off->add('
		<button class="close-button" aria-label="Close menu" type="button" data-close>
			<span aria-hidden="true">&times;</span>
		</button>
		<ul class="vertical menu">
			<li><a href="#">Foundation</a></li>
			<li><a href="#">Dot</a></li>
			<li><a href="#">ZURB</a></li>
			<li><a href="#">Com</a></li>
			<li><a href="#">Slash</a></li>
			<li><a href="#">Sites</a></li>
		</ul>');

$toggle = new \PHPFUI\Button('Toggle OffCanvas');
$offCanvas->addOff($off, $toggle);

$container->add($offCanvas);
$container->add($toggle);

return $container;
PHP);
		}

	private function getPagination() : void
		{
		$this->section('Pagination', <<<'PHP'
return new \PHPFUI\Pagination(0, 13, '#');
PHP);
		}

	private function getProgressBar() : void
		{
		$this->section('Progress Bar', <<<'PHP'
$container = new \PHPFUI\Container();

$bar = new \PHPFUI\ProgressBar();
$bar->addClass('primary');
$bar->setCurrent(25);
$container->add($bar);

$bar = new \PHPFUI\ProgressBar();
$bar->addClass('warning');
$bar->setCurrent(50);
$container->add($bar);

$bar = new \PHPFUI\ProgressBar();
$bar->addClass('alert');
$bar->setCurrent(75);
$container->add($bar);

$bar = new \PHPFUI\ProgressBar();
$bar->addClass('success');
$bar->setCurrent(100);
$container->add($bar);

return $container;
PHP);
		}

	private function getResponsiveEmbed() : void
		{
		$this->section('Responsive Embed', <<<'PHP'
$embed = new \PHPFUI\Embed();
$embed->add(new \PHPFUI\YouTube('WUgvvPRH7Oc'));

return $embed;
PHP);
		}

	private function getResponsiveMenu() : void
		{
		$this->section('Responsive Menu', <<<'PHP'
$menu = new \PHPFUI\Menu();
$menu->setIconAlignment('left');
$menu->addClass('vertical medium-horizontal');
$item = new \PHPFUI\MenuItem('One', '#');
$item->setIcon(new \PHPFUI\IconBase('fas fa-bars'));
$menu->addMenuItem($item);
$item = new \PHPFUI\MenuItem('Two', '#');
$item->setIcon(new \PHPFUI\IconBase('fas fa-bars'));
$menu->addMenuItem($item);
$item = new \PHPFUI\MenuItem('Three', '#');
$item->setIcon(new \PHPFUI\IconBase('fas fa-bars'));
$menu->addMenuItem($item);
$item = new \PHPFUI\MenuItem('Four', '#');
$item->setIcon(new \PHPFUI\IconBase('fas fa-bars'));
$menu->addMenuItem($item);

return $menu;
PHP);
		}

	private function getReveal() : void
		{
		$this->section('Reveal', <<<'PHP'
$container = new \PHPFUI\Container();

$openButton = new \PHPFUI\Button('Click me for a modal');
$container->add($openButton);

$reveal = new \PHPFUI\Reveal($this, $openButton);
$reveal->add(new \PHPFUI\Header('Awesome. I Have It.'));
$reveal->add('<p class="lead">Your couch. It is mine.</p>');
$reveal->add("<p>I'm a cool paragraph that lives inside of an even cooler modal. Wins!</p>");

$nestedButton = new \PHPFUI\Button('Click me for a nested modal');
$container->add($nestedButton);

$nestedReveal = new \PHPFUI\Reveal($this, $nestedButton);
$nestedReveal->add(new \PHPFUI\Header('Awesome!'));
$nestedReveal->add('<p class="lead">I have another modal inside of me!</p>');

$nestedRevealButton = new \PHPFUI\Button('Click me for another modal!');
$nestedReveal->add($nestedRevealButton);

$nestedReveal2 = new \PHPFUI\Reveal($this, $nestedRevealButton);
$nestedReveal2->add(new \PHPFUI\Header('ANOTHER MODAL!!!'));

return $container;
PHP);
		}

	private function getSlider() : void
		{
		$this->section('Slider', <<<'PHP'
$container = new \PHPFUI\Container();

$container->add(new \PHPFUI\Slider(25));

$data = new \PHPFUI\Input('number', 'data');
$slider = new \PHPFUI\Slider(12, new \PHPFUI\SliderHandle(12, $data));
$slider->setVertical();
$container->add($slider);
$container->add($data);

$firstHandle = new \PHPFUI\Input('number', 'first');
$secondHandle = new \PHPFUI\Input('number', 'second');
$slider = new \PHPFUI\Slider(25, new \PHPFUI\SliderHandle(25, $firstHandle));
$slider->setRangeHandle(new \PHPFUI\SliderHandle(75, $secondHandle));
$container->add($slider);
$container->add(new \PHPFUI\MultiColumn($firstHandle, $secondHandle));

return $container;
PHP);
		}

	private function getSplitButton() : void
		{
		$this->section('Split Button', <<<'PHP'
$splitButton = new \PHPFUI\SplitButton('Split', '#');
$splitButton->addMenuItem(new \PHPFUI\MenuItem('Option 4', '#'));
$splitButton->addMenuItem(new \PHPFUI\MenuItem('Option 3', '#'));
$splitButton->addMenuItem(new \PHPFUI\MenuItem('Option 5', '#'));
$splitButton->addMenuItem(new \PHPFUI\MenuItem('Option 1', '#'));
$splitButton->addMenuItem(new \PHPFUI\MenuItem('Option 2', '#'));
$splitButton->sort();

return $splitButton;
PHP);
		}

	private function getSwitch() : void
		{
		$this->section('Switch', <<<'PHP'
$container = new \PHPFUI\Container();

$tiny = new \PHPFUI\Input\SwitchCheckBox('tiny');
$tiny->addClass('tiny');
$container->add($tiny);
$container->add(new \PHPFUI\Input\SwitchCheckBox('normal'));
$switchCB = new \PHPFUI\Input\SwitchCheckBox('name', true, 'Do you like me?');
$switchCB->setActiveLabel('Yes')->setInactiveLabel('No')->addClass('large');
$container->add($switchCB);
return $container;
PHP);
		}

	private function getSwitchRadio() : void
		{
		$this->section('Switch Radio', <<<'PHP'
$container = new \PHPFUI\GridX();
$switchRB1 = new \PHPFUI\Input\SwitchRadio('radio', 1);
$switchRB1->setActiveLabel('Yes')->setInactiveLabel('No')->addClass('large');
$container->add($switchRB1);
$container->add(' &nbsp; ');

$switchRB2 = new \PHPFUI\Input\SwitchRadio('radio', 2);
$container->add($switchRB2->setChecked());
$container->add(' &nbsp; ');

$switchRB3 = new \PHPFUI\Input\SwitchRadio('radio', 3);
$container->add($switchRB3->addClass('tiny'));

return $container;
PHP);
		}

	private function getTable() : void
		{
		$this->section('Table', <<<'PHP'
$table = new \PHPFUI\Table();
$table->setCaption('This is the table caption');
$table->addArrowNavigation($this);
$headers = ['Some', 'Numbers', '4', 'U', 'Edit', 'CheckBox'];
$table->setHeaders($headers);
$table->addColumnAttribute('Numbers', ['class' => 'warning']);

for ($i = 0; $i < 10; ++$i)
	{
	$numbers = [];

	foreach ($headers as $field)
		{
		$numbers[$field] = rand();
		}

	$numbers['Edit'] = new \PHPFUI\Input\Text('edit[]');
	$numbers['CheckBox'] = new \PHPFUI\Input\CheckBox('check[]');
	$table->addRow($numbers);
	}

return $table;
PHP);
		}

	private function getTabs() : void
		{
		$this->section('Tabs', <<<'PHP'
$container = new \PHPFUI\Container();
$tabs = new \PHPFUI\Tabs();
$tabs->addTab('One', 'Check me out! I\'m a super cool Tab panel with text content!');
$image = new \PHPFUI\Thumbnail(new \PHPFUI\Image('/images/rectangle-7.jpg'));
$tabs->addTab('Two', $image, true);
$tabs->addTab('Three', 'Nothing to see here.');
$image = new \PHPFUI\Thumbnail(new \PHPFUI\Image('/images/rectangle-2.jpg'));
$tabs->addTab('Four', $image);
$tabs->addTab('Five', 'Still nothing to see here.');
$image = new \PHPFUI\Thumbnail(new \PHPFUI\Image('/images/rectangle-8.jpg'));
$tabs->addTab('Six', $image);
$container->add($tabs);

return $container;
PHP);
		}

	private function getThumbnail() : void
		{
		$this->section('Thumbnail', <<<'PHP'
$container = new \PHPFUI\Container();

$container->add(new \PHPFUI\Thumbnail(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/01.jpg')));
$container->add(new \PHPFUI\Thumbnail(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/02.jpg')));
$container->add(new \PHPFUI\Thumbnail(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/03.jpg')));

return $container;
PHP);
		}

	private function getTitleBar() : void
		{
		$this->section('Title Bar', <<<'PHP'
$titlebar = new \PHPFUI\TitleBar('Foundation');
$titlebar->addLeft('<button class="menu-icon" type="button"></button>');
$titlebar->addRight('<button class="menu-icon" type="button"></button>');

return $titlebar;
PHP);
		}

	private function getToggler() : void
		{
		$this->section('Toggler', <<<'PHP'
$container = new \PHPFUI\Container();

$toggleAll = new \PHPFUI\Button('Toggle All These');

$image1 = new \PHPFUI\Thumbnail(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/01.jpg'));
$image2 = new \PHPFUI\Thumbnail(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/02.jpg'));
$image3 = new \PHPFUI\Thumbnail(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/03.jpg'));

$toggleAll->toggleAnimate($image1, 'hinge-in-from-left spin-out');
$toggleAll->toggleAnimate($image2, 'hinge-in-from-bottom fade-out');
$toggleAll->toggleAnimate($image3, 'slide-in-down slide-out-up');

$container->add(new \PHPFUI\MultiColumn($toggleAll));
$container->add($image1);
$container->add($image2);
$container->add($image3);

$toggleFocus = new \PHPFUI\Input\Text('test', 'Toggle on Focus');

$callout = new \PHPFUI\Callout('secondary');
$callout->add('<p>This is only visible when the above field has focus.</p>');

$toggleFocus->toggleFocus($callout, 'hinge-in-from-top hinge-out-from-bottom');

$container->add(new \PHPFUI\MultiColumn($toggleFocus));
$container->add($callout);

return $container;
PHP);
		}

	private function getTooltip() : void
		{
		$this->section('Tooltip', <<<'PHP'
$container = new \PHPFUI\Container();

$toolTip = new \PHPFUI\ToolTip('scarabaeus', 'Fancy word for a beetle');
$container->add("<p>The {$toolTip} hung quite clear of any branches, and, if allowed to fall, would have fallen at our feet. Legrand immediately took the scythe, and cleared with it a circular space, three or four yards in diameter, just beneath the insect, and, having accomplished this, ordered Jupiter to let go the string and come down from the tree.</p>");

return $container;
PHP);
		}

	private function getTopBar() : void
		{
		$this->section('Top Bar', <<<'PHP'
$topbar = new \PHPFUI\TopBar();
$topbar->addLeft($this->makeMenu(new \PHPFUI\DropDownMenu(), 'Site Title', '', $this->subMenu()));

$menu = new \PHPFUI\Menu();
$search = new \PHPFUI\Input('search', '');
$search->addAttribute('placeholder', 'Search');
$menu->addMenuItem(new \PHPFUI\MenuItem($search));
$menu->addMenuItem(new \PHPFUI\MenuItem(new \PHPFUI\Button('Search')));
$topbar->addRight($menu);

return $topbar;
PHP);
		}

	private function runPHP(string $php) : string
		{
		return eval($php);
		}

	private function section(string $name, string $php) : void
		{
		$container = new \PHPFUI\HTML5Element('section');

		$container->add(new \PHPFUI\HTML5Element('hr'));
		$container->addAttribute('data-magellan-target', $container->getId());
		$container->add(new \PHPFUI\Header($name, 2));

		$toggleLink = new \PHPFUI\HTML5Element('a');
		$toggleLink->addAttribute('style', 'font-weight: 700');
		$toggleLink->add('Toggle Code');
		$php = trim($php, " \n");
		// Highlight some code.
		$highlighted = $this->hl->highlight('php', $php);
		$codeBlock = new \PHPFUI\HTML5Element('pre');
		$code = new \PHPFUI\HTML5Element('code');
		$code->addClass('hljs');
		$code->addClass($highlighted->language);
		$code->add($highlighted->value);
		$codeBlock->add($code);
		$codeBlock->addClass('hide');
		$div = new \PHPFUI\HTML5Element('div');
		$div->addClass('clearfix');
		$copyButton = new \PHPFUI\Button('Copy');
		$copyButton->addClass('float-right');
		$copyButton->addClass('hide');
		$toggleLink->addAttribute('onclick', '$("#' . $codeBlock->getId() . '").toggleClass("hide");$("#' . $copyButton->getId() . '").toggleClass("hide")');
		$copyButton->setAttribute('onclick', 'copyCode($("#' . $copyButton->getId() . '"),$("#' . $code->getId() . '"))');
		$div->add($toggleLink);
		$div->add($copyButton);
		$container->add($div);
		$container->add('<br>');

		$container->add($codeBlock);

		$this->magellanMenu->addMenuItem(new \PHPFUI\MenuItem($name, '#' . $container->getId()));

		$container->add($this->runPHP($php));

		$this->sections->add($container);
		}

	private function generateMenu(string $name, int $count, bool $active = false) : \PHPFUI\Menu
		{
		$names = ['One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten'];
		$menu = new \PHPFUI\Menu();
		$count = min($count, 10);

		for ($i = 0; $i < $count; ++$i)
			{
			$item = new \PHPFUI\MenuItem($names[$i] . ' ' . $name, '#');
			$item->setActive($active);
			$active = false;
			$menu->addMenuItem($item);
			}

		return $menu;
		}

	private function makeMenu(\PHPFUI\Menu $menu, string $name, ?string $class = '', ?\PHPFUI\Menu $subMenu = null) : \PHPFUI\Menu
		{
		$menu->addMenuItem(new \PHPFUI\MenuItem($name));
		$menu->addMenuItem(new \PHPFUI\MenuItem('One', '#'));
		$menu->addMenuItem(new \PHPFUI\MenuItem('Two', '#'));
		$three = new \PHPFUI\MenuItem('Three', '#');

		if ($subMenu)
			{
			$menu->addSubMenu($three, $subMenu);
			}
		else
			{
			$three->setActive(true);
			$menu->addMenuItem($three);
			}

		$menu->addMenuItem(new \PHPFUI\MenuItem('Four', '#'));

		if ($class)
			{
			$menu->addClass($class);
			}

		return $menu;
		}

	private function subMenu() : \PHPFUI\Menu
		{
		$menu = new \PHPFUI\Menu();
		$menu->addMenuItem(new \PHPFUI\MenuItem('One A', '#'));
		$menu->addMenuItem(new \PHPFUI\MenuItem('Two A', '#'));
		$menu->addMenuItem(new \PHPFUI\MenuItem('Three A', '#'));
		$menu->addSubMenu(new \PHPFUI\MenuItem('Four A', '#'), $this->generateMenu('B', 3, true));
		$menu->addSubMenu(new \PHPFUI\MenuItem('Five A', '#'), $this->generateMenu('C', 10));

		return $menu;
		}

	protected function getMagellanMenu() : \PHPFUI\Menu | null
		{
		$this->magellanMenu = new \PHPFUI\Menu();
		$this->magellanMenu->addMenuItem(new \PHPFUI\MenuItem('Kitchen Sink'));
		$this->magellanMenu->addClass('vertical');
		$this->magellanMenu->addAttribute('data-magellan');

		return $this->magellanMenu;
		}

	}
