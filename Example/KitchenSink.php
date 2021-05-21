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

		$title = $_GET['dir'] ?? '';
		if ($title)
			{
			$title = ' - ' . $title;
			}

		$this->addBody(new \PHPFUI\Header('Kitchen Sink' . $title, 1));
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

		$dir = $_GET['dir'] ?? '';
		if ($dir)
			{
			$dir = '/' . $dir;
			}

		$menu = new \PHPFUI\Menu();
		$menu->addClass('vertical');
		$first = true;

		foreach (new \DirectoryIterator(PROJECT_ROOT . "/examples{$dir}") as $fileInfo)
			{
			$file = $fileInfo->getPathname();
			$title = $fileInfo->getFilename();

			if ($fileInfo->isDir())
				{
				if (! str_contains($file, '.'))
					{
					if ($first)
						{
						$first = false;
						$menu->addMenuItem(new \PHPFUI\MenuItem('Choose a Section'));
						}
					$menu->addMenuItem(new \PHPFUI\MenuItem($title, "/Examples/KitchenSink.php?dir={$title}"));
					}
				}
			else
				{
				$php = file_get_contents($file);
				$php = str_replace("<?php", '', $php);
				$php = trim($php, "\n\r\l\t");

				$title = substr($title, 0, strlen($title) - 4);
				$title = str_replace('_', ' ', $title);
				$this->section($title, $php);
				}
			}
		if (count($menu))
			{
			$this->sections->add($menu);
			}
		else
			{
			$this->sections->add(new \PHPFUI\Button('Back to the Future', '/Examples/KitchenSink.php'));
			}
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
		$title = $_GET['dir'] ?? '';
		if (! $title)
			{
			return null;
			}
		$this->magellanMenu = new \PHPFUI\Menu();
		$this->magellanMenu->addMenuItem(new \PHPFUI\MenuItem($title));
		$this->magellanMenu->addClass('vertical');
		$this->magellanMenu->addAttribute('data-magellan');

		return $this->magellanMenu;
		}

	}
