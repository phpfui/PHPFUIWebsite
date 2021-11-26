<?php
include '../common.php';

set_time_limit(99999);

$generateStaticFiles = false;
$useComposer = false;
$addExamples = true;

if ($useComposer)
	{
	$fileManager = new \PHPFUI\InstaDoc\FileManager('../');
	}
else
	{
	$libraries = [
		'cebe',
		'Composer',
		'DeepCopy',
		'Example',
		'Gitonomy',
		'GuzzleHttp',
		'Highlight',
		'HtmlValidator',
		'ICalendarOrg',
		'NXP',
		'phpDocumentor',
		'PHPFUI',
		'PhpParser',
		'Psr',
		'Symfony',
		'Symfony',
		'voku',
		'Webmozart',
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
\PHPFUI\InstaDoc\NamespaceTree::deleteNameSpace('cebe\markdown\tests');
$controller = new \PHPFUI\InstaDoc\Controller($fileManager);
$controller->setGitRoot(getcwd() . '/../');
$controller->addHomePageMarkdown('../PHPFUI/README.md');
$controller->addHomePageMarkdown('../PHPFUI/InstaDoc/README.md');
$controller->setHomeUrl('/');
$controller->getControllerPage()->addHeadTag('<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#ffc40d">
<meta name="theme-color" content="#ffffff">');

if ($generateStaticFiles)
	{
	echo '<pre>';
	$controller->setGitFileOffset('..');
	print_r($controller->generate('static', [\PHPFUI\InstaDoc\Controller::DOC_PAGE, \PHPFUI\InstaDoc\Controller::FILE_PAGE, \PHPFUI\InstaDoc\Controller::GIT_PAGE, ]));
	}
else
	{
	if ($addExamples)
		{
		$menu = $controller->getMenu();
		$exampleMenu = \Example\Page::getMenu();
		$menu->addSubMenu(new \PHPFUI\MenuItem('Examples'), $exampleMenu);
		}

	echo $controller->display();
	}


