<?php

namespace Example;

class Page extends \PHPFUI\Page
	{
	private \PHPFUI\Menu $footerMenu;
	private \PHPFUI\Cell $mainColumn;
	private \PHPFUI\OffCanvas $offCanvas;
	private string $menuId;

	public function __construct(private $callback = null)
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

		$this->addCSS("code{tab-size:2;-moz-tab-size:2;}");

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
		$this->menuId = $menu->getId();
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

		$this->offCanvas = new \PHPFUI\OffCanvas($body);

		$parts = parse_url($_SERVER['REQUEST_URI']);
		$parts = explode('/', $parts['path']);
		$file = array_pop($parts);
		$class = str_replace('.php', '', $file);

		if (ctype_upper($class[0]))
			{
			$this->setDebug(1);

			if (! empty($_POST['save']) && \PHPFUI\Session::checkCSRF())
				{
				if (is_callable($this->callback))
					{
					call_user_func($this->callback, $_POST);
					}
				else
					{
					\PHPFUI\Session::setFlash('post', json_encode($_POST));
					}
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
			$parser = new \PHPFUI\InstaDoc\MarkDownParser();
			$this->addBody($parser->fileText($docFile));

			$post = \PHPFUI\Session::getFlash('post');

			foreach (['alert', 'warning', 'success', 'secondary', ] as $type)
				{
				$message = \PHPFUI\Session::getFlash($type);
				if ($message)
					{
					$callout = new \PHPFUI\Callout($type);
					$callout->add(json_decode($message, true));
					$this->addBody($callout);
					}
				}

			if (is_array($post) && ! is_callable($this->callback))
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

		$this->footerMenu = new \PHPFUI\Menu();
		$this->footerMenu->addClass('simple');
		$this->footerMenu->addMenuItem(new \PHPFUI\MenuItem('Powered By'));
		$this->footerMenu->addMenuItem(new \PHPFUI\MenuItem('PHPFUI', 'http://phpfui.com/?n=PHPFUI'));
		$this->footerMenu->addMenuItem(new \PHPFUI\MenuItem('github', 'https://github.com/phpfui/phpfui'));
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
			'Abide Validation' => '/Examples/AbideValidation.php',
			'Accordion To From List' => '/Examples/AccordionToFromList.php',
			'AutoComplete' => '/Examples/AutoComplete.php',
			'CheckBoxMenu' => '/Examples/CheckBoxMenu.php',
			'Composer Version Checker' => '/Examples/ComposerVersion.php',
			'GPX to CueSheet' => '/Examples/GPX2CueSheet.php',
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

	protected function getStart() : string
		{
		$div = new \PHPFUI\HTML5Element('div');
		$stickyTitleBar = new \PHPFUI\Sticky($div);
		$link = new \PHPFUI\Link('/', 'PHPFUI', false);
		$exampleLink = new \PHPFUI\Link('/Examples/index.php', 'Examples', false);
		$titleBar = new \PHPFUI\TitleBar($link . ' - ' . $exampleLink);
		$hamburger = new \PHPFUI\FAIcon('fas', 'bars', '#');
		$hamburger->addClass('show-for-small-only');
		$titleBar->addLeft($hamburger);
		$titleBar->addLeft('&nbsp;');
		$stickyTitleBar->add($titleBar);
		$stickyTitleBar->addAttribute('data-options', 'marginTop:0;');
		$this->add("{$stickyTitleBar}");

		$offCanvasDiv = new \PHPFUI\HTML5Element('div');
		$offCanvasId = $offCanvasDiv->getId();
		// copy over the menu with JQuery at run time
		$this->addJavaScriptFirst('$("#' . $this->menuId . '").clone().prependTo("#' . $offCanvasId . '");');
		$offId = $this->offCanvas->addOff($offCanvasDiv, $hamburger);
		$this->offCanvas->setPosition($offId, 'left')->setTransition($offId, 'over');

		$this->add("{$this->offCanvas}");

		$footer = new \PHPFUI\TopBar();
		$footer->addLeft($this->footerMenu);
		$year = date('Y');
		$footer->addRight("&copy; {$year} Bruce Wells");
		$this->add("{$footer}");

		return parent::getStart();
		}

	}
