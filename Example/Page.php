<?php

namespace Example;

class Page extends \PHPFUI\Page
	{
	private \PHPFUI\Menu $footerMenu;
	private \PHPFUI\Cell $mainColumn;

	public function __construct()
		{
		parent::__construct();
		$this->mainColumn = new \PHPFUI\Cell(12, 8, 9);
		$this->addStyleSheet('css/styles.css');

		$link = new \PHPFUI\Link('/', 'PHPFUI', false);
		$exampleLink = new \PHPFUI\Link('/Examples/index.php', 'Examples', false);

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
		$grid = new \PHPFUI\GridX();
		$menuColumn = new \PHPFUI\Cell(4, 4, 3);
		$menuColumn->addClass('show-for-medium');
		$menu = $this->getMenu();
		$menu->addClass('vertical');
		$menuId = $menu->getId();
		$menuColumn->add($menu);
		$grid->add($menuColumn);

		$this->mainColumn->addClass('main-column');
		$grid->add($this->mainColumn);
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
				\PHPFUI\Session::setFlash('post', json_encode($_POST));
				$this->redirect();

				return;
				}
			$sourceMenu = new \PHPFUI\Menu();
			$link = '/?n=Example&c=' . $class;
			$link .= '&p=f';
			$sourceMenu->addMenuItem(new \PHPFUI\MenuItem('All Examples', '/Examples/index.php'));
			$sourceMenu->addMenuItem(new \PHPFUI\MenuItem('Example Source', $link));
			$this->addBody($sourceMenu);
			// add markdown if there
			$docFile = $_SERVER['DOCUMENT_ROOT'] . '/../Example/docs/' . $class . '.md';
			$parser = new \PHPFUI\InstaDoc\MarkDownParser();
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
		$exampleMenu = new \PHPFUI\Menu();
		$exampleMenu->addMenuItem(new \PHPFUI\MenuItem('Pagination', '/Examples/Paginate.php'));
		$exampleMenu->addMenuItem(new \PHPFUI\MenuItem('Sortable Table', '/Examples/SortableTable.php'));
		$exampleMenu->addMenuItem(new \PHPFUI\MenuItem('Orderable Table', '/Examples/OrderableTable.php'));
		$exampleMenu->addMenuItem(new \PHPFUI\MenuItem('SelectAutoComplete', '/Examples/SelectAutoComplete.php'));
		$exampleMenu->addMenuItem(new \PHPFUI\MenuItem('AutoComplete', '/Examples/AutoComplete.php'));
		$exampleMenu->addMenuItem(new \PHPFUI\MenuItem('Abide', '/Examples/Abide.php'));
		$exampleMenu->addMenuItem(new \PHPFUI\MenuItem('Orbit Carousel', '/Examples/Orbit.php'));
		$exampleMenu->addMenuItem(new \PHPFUI\MenuItem('To From List', '/Examples/ToFromList.php'));
		$exampleMenu->addMenuItem(new \PHPFUI\MenuItem('Accordion To From List', '/Examples/AccordionToFromList.php'));
		$exampleMenu->sort();

		return $exampleMenu;
		}

	}
