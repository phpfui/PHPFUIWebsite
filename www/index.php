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
		'DeepCopy',
		'Firebase',
		'cebe',
		'Example',
		'Gitonomy',
		'Grpc',
		'GuzzleHttp',
		'Highlight',
		'Monolog',
		'NXP',
		'phpDocumentor',
		'PHPFUI',
		'PHPHtmlParser',
		'PhpParser',
		'Psr',
		'Rize',
		'Symfony',
		'Symfony',
		'Webmozart',
		];

	$fileManager = new \PHPFUI\InstaDoc\FileManager();
	foreach ($libraries as $library)
		{
		$fileManager->addNamespace($library, '../' . $library, true);
		}
	$fileManager->addNamespace('\\', '../NoNameSpace', true);
	}

$fileManager->load();
$childClasses = new \PHPFUI\InstaDoc\ChildClasses('../');
$childClasses->load();
\PHPFUI\InstaDoc\NamespaceTree::deleteNameSpace('Grpc\Gcp\generated');
\PHPFUI\InstaDoc\NamespaceTree::deleteNameSpace('cebe\markdown\tests');
$controller = new \PHPFUI\InstaDoc\Controller($fileManager);
//$controller->setChildClasses($childClasses);
$controller->setGitRoot(getcwd() . '/../');
$controller->addHomePageMarkdown('../PHPFUI/README.md');
$controller->addHomePageMarkdown('../PHPFUI/InstaDoc/README.md');
$controller->setHomeUrl('/');

if ($generateStaticFiles)
	{
	echo '<pre>';
	print_r($controller->generate('static', [\PHPFUI\InstaDoc\Controller::DOC_PAGE, \PHPFUI\InstaDoc\Controller::FILE_PAGE, ]));
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


