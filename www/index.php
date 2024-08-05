<?php

include '../common.php';

\set_time_limit(99999);

$generateStaticFiles = false;
$useComposer = false;

$addExamples = true;
$addBlog = true;
$addPetty = true;

if ($useComposer)
	{
	$fileManager = new \PHPFUI\InstaDoc\FileManager('../');
	}
else
	{
	$libraries = [
		'Composer',
		'DeepCopy',
		'Example',
		'Gitonomy',
		'GuzzleHttp',
		'Druidfi',
		'Highlight',
		'HtmlValidator',
		'ICalendarOrg',
		'League',
		'Maknz',
		'NXP',
		'phpDocumentor',
		'PHPFUI',
		'PHPMailer',
		'PhpParser',
		'Symfony',
		'Symfony',
		'Soundasleep',
		'voku',
		'Webmozart',
		'ZBateson',
	];

	$fileManager = new \PHPFUI\InstaDoc\FileManager();

	foreach ($libraries as $library)
		{
		$fileManager->addNamespace($library, '../' . $library, true);
		}
	$fileManager->addGlobalNameSpaceClass('../FPDF.php', true);
	}

$fileManager->load();
\PHPFUI\InstaDoc\ChildClasses::load('../ChildClasses.serial');
\PHPFUI\InstaDoc\NamespaceTree::deleteNameSpace('cebe');
$controller = new \PHPFUI\InstaDoc\Controller($fileManager);
$controller->setGitRoot(\getcwd() . '/../');
$controller->addHomePageMarkdown('../PHPFUI/README.md');
$controller->addHomePageMarkdown('../PHPFUI/InstaDoc/README.md');
$controller->setHomeUrl('/');
$page = $controller->getControllerPage();
$page->addHeadTag('<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#ffc40d">
<meta name="theme-color" content="#ffffff">');
$trackingCode = include '../trackingCode.php';
$page->addHeadScript("https://www.googletagmanager.com/gtag/js?id={$trackingCode}");
$js = "window.dataLayer=window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','{$trackingCode}');";
$page->addHeadJavaScript($js);
if ($generateStaticFiles)
	{
	$controller->setGitFileOffset('..');
	\print_r($controller->generate('static', [\PHPFUI\InstaDoc\Controller::DOC_PAGE, \PHPFUI\InstaDoc\Controller::FILE_PAGE, \PHPFUI\InstaDoc\Controller::GIT_PAGE, ]));
	}
else
	{
 	if ($addExamples)
		{
		$menu = $controller->getMenu();
		$exampleMenu = \Example\Page::getMenu();
		$menu->addSubMenu(new \PHPFUI\MenuItem('Examples'), $exampleMenu);
		}

	if ($addPetty)
		{
		$menu = $controller->getMenu();
		$title = 'Tom Petty Buried Treasure Playlists';
		$menuItem = new \PHPFUI\MenuItem($title, '#');
		$menuItem->setLinkObject(new \PHPFUI\Link('http://buriedtreasure.phpfui.com', $title));
		$menu->addMenuItem($menuItem);
		}

	if ($addBlog)
		{
		$menu = $controller->getMenu();
		$blogTitle = 'Thoughts on PHP blog';
		$menuItem = new \PHPFUI\MenuItem($blogTitle, '#');
		$menuItem->setLinkObject(new \PHPFUI\Link('http://blog.phpfui.com', $blogTitle));
		$menu->addMenuItem($menuItem);
		}

	// handle direct .md or .markdown extensions
	$requestUri = $_SERVER['REQUEST_URI'] ?? '';
	$extensionIndex = \strrpos($requestUri, '.');

	if ($extensionIndex)
		{
		$extension = \strtolower(\substr($requestUri, $extensionIndex + 1));
		$file = PROJECT_ROOT . $requestUri;

		if (\in_array($extension, ['md', 'markdown']) && \file_exists($file))
			{
			$parser = new \PHPFUI\InstaDoc\MarkDownParser();
			$page = $controller->getPage();
			$cell = new \PHPFUI\Cell(12, 12, 12);
			$cell->addClass('main-column');
			$cell->add($parser->fileText($file));
			$page->add($cell);
			echo $page;

			exit;
			}
		}
	echo $controller->display();
	}
