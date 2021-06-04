<?php

namespace Example;

class Page extends \PHPFUI\Page
	{
	private \PHPFUI\Menu $footerMenu;
	private \PHPFUI\Cell $mainColumn;

	public function __construct()
		{
		parent::__construct();
		$this->addStyleSheet('css/styles.css');
		$this->addHeadTag('<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#ffc40d">
<meta name="theme-color" content="#ffffff">');

		$link = new \PHPFUI\Link('/', 'PHPFUI', false);
		$exampleLink = new \PHPFUI\Link('/Examples/index.php', 'Examples', false);
		$this->addCSS("code{tab-size:2;-moz-tab-size:2;}");

		$titleBar = new \PHPFUI\TitleBar($link . ' - ' . $exampleLink);
		$hamburger = new \PHPFUI\FAIcon('fas', 'bars', '#');
		$hamburger->addClass('show-for-small-only');
		$titleBar->addLeft($hamburger);
		$titleBar->addLeft('&nbsp;');

		$div = new \PHPFUI\HTML5Element('div');
		$stickyTitleBar = new \PHPFUI\Sticky($div);
		$stickyTitleBar->add($titleBar);
		$stickyTitleBar->addAttribute('data-options', 'marginTop:0;');
		$this->add($stickyTitleBar);

		$body = new \PHPFUI\HTML5Element('div');
		$body->addClass('body-info');
		$magellan = $this->getMagellanMenu();
		$grid = new \PHPFUI\GridX();
		if ($magellan)
			{
			$magellan->addClass('ks-toc');
			$menuColumn = new \PHPFUI\Cell(4, 3, 2);
			}
		else
			{
			$menuColumn = new \PHPFUI\Cell(4, 4, 3);
			}
		$menuColumn->addClass('show-for-medium');
		$menu = $this->getMenu();
		$menu->addClass('vertical');
		$menuId = $menu->getId();
		$stickyMenu = new \PHPFUI\Sticky($menuColumn);
		$stickyMenu->add($menu);
		$menuColumn->add($stickyMenu);
		$grid->add($menuColumn);
		if ($magellan)
			{
			$this->mainColumn = new \PHPFUI\Cell(12, 6, 8);
			}
		else
			{
			$this->mainColumn = new \PHPFUI\Cell(12, 8, 9);
			}
		$this->mainColumn->addClass('main-column');
		$grid->add($this->mainColumn);
		if ($magellan)
			{
			$magellanColumn = new \PHPFUI\Cell(2);
			$magellanColumn->addClass('show-for-medium');
			$sticky = new \PHPFUI\Sticky($magellanColumn);
			$sticky->add($magellan);
			$magellanColumn->add($sticky);
			$sticky->add('<br>');
			$sticky->add('<br>');
			$sticky->add('<br>');
			$sticky->add('<br>');
			$sticky->add('<br>');
			$grid->add($magellanColumn);
			}
		$body->add($grid);

		$offCanvas = new \PHPFUI\OffCanvas($body);
		$div = new \PHPFUI\HTML5Element('div');
		$offCanvasId = $div->getId();
		// copy over the menu with JQuery at run time
		$this->addJavaScriptFirst('$("#' . $menuId . '").clone().prependTo("#' . $offCanvasId . '");');
		$offId = $offCanvas->addOff($div, $hamburger);
		$offCanvas->setPosition($offId, 'left')->setTransition($offId, 'over');

		$this->add($offCanvas);

		$parts = parse_url($_SERVER['REQUEST_URI']);
		$parts = explode('/', $parts['path']);
		$file = array_pop($parts);
		$class = str_replace('.php', '', $file);

		if (ctype_upper($class[0]))
			{
			$this->setDebug(1);

			if (! empty($_POST['submit']) && \PHPFUI\Session::checkCSRF())
				{
				$vars = [];

				foreach ($_POST as $key => $value)
					{
					$vars[$key] = $value;
					}
				\PHPFUI\Session::setFlash('post', json_encode($vars));
				$this->redirect();

				return;
				}
			$sourceMenu = new \PHPFUI\Menu();
			$link = '/?n=Example&c=' . $class;
			$link .= '&p=f';
			$sourceMenu->addMenuItem(new \PHPFUI\MenuItem('Example Source', $link));
			$this->addBody($sourceMenu);
			// add markdown if there
			$docFile = $_SERVER['DOCUMENT_ROOT'] . '/../Example/docs/' . $class . '.md';
			$parser = new \PHPFUI\InstaDoc\MarkDownParser($this);
			$this->addBody($parser->fileText($docFile));

			$post = \PHPFUI\Session::getFlash('post');

			if ($post)
				{
				$post = json_decode($post, true);
				$callout = new \PHPFUI\Callout('success');
				$callout->add('You posted the following:');
				$ul = new \PHPFUI\UnorderedList();

				foreach ($post as $key => $value)
					{
					$value = print_r($value, 1);
					$ul->addItem(new \PHPFUI\ListItem("<b>{$key}</b> {$value}"));
					}
				$callout->add($ul);
				$this->addBody($callout);
				}

			}

		$footer = new \PHPFUI\TopBar();
		$this->footerMenu = new \PHPFUI\Menu();
		$this->footerMenu->addClass('simple');
		$this->footerMenu->addMenuItem(new \PHPFUI\MenuItem('Powered By'));
		$this->footerMenu->addMenuItem(new \PHPFUI\MenuItem('PHPFUI', 'http://phpfui.com/?n=PHPFUI'));
		$this->footerMenu->addMenuItem(new \PHPFUI\MenuItem('github', 'https://github.com/phpfui/phpfui'));

		$footer->addLeft($this->footerMenu);

		$year = date('Y');
		$footer->addRight("&copy; {$year} Bruce Wells");

		$this->add($footer);
		}

	protected function getMagellanMenu() : \PHPFUI\Menu | null
		{
		return null;
		}

	public function addBody($item) : self
		{
		$this->mainColumn->add($item);

		return $this;
		}

	public function getFooterMenu() : \PHPFUI\Menu
		{
		return $this->footerMenu;
		}

	public static function getMenu() : \PHPFUI\Menu
		{
		$options = [
			'Abide' => '/Examples/Abide.php',
			'Accordion To From List' => '/Examples/AccordionToFromList.php',
			'AutoComplete' => '/Examples/AutoComplete.php',
			'CheckBoxMenu' => '/Examples/CheckBoxMenu.php',
			'Kitchen Sink' => '/Examples/KitchenSink.php',
			'Orbit Carousel' => '/Examples/Orbit.php',
			'Orderable Table' => '/Examples/OrderableTable.php',
			'Pagination' => '/Examples/Pagination.php',
			'SelectAutoComplete' => '/Examples/SelectAutoComplete.php',
			'Sortable Table' => '/Examples/SortableTable.php',
			'To From List' => '/Examples/ToFromList.php',
			];

		$exampleMenu = new \PHPFUI\Menu();
		foreach ($options as $name => $url)
			{
			$menuItem = new \PHPFUI\MenuItem($name, $url);
			if (str_contains($_SERVER['REQUEST_URI'], $url))
				{
				$menuItem->setActive();
				}
			$exampleMenu->addMenuItem($menuItem);
			}
		$exampleMenu->sort();

		return $exampleMenu;
		}

	}
