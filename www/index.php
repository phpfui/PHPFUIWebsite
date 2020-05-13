<?php
include '../commonbase.php';

set_time_limit(99999);

if (true)
	{
	$libraries = [
		'DeepCopy',
		'Firebase',
		'cebe',
		'Gitonomy',
		'Google',
		'Grpc',
		'GuzzleHttp',
		'Highlight',
		'HighlightUtilities',
		'Monolog',
		'NXP',
		'phpDocumentor',
		'PHPFUI',
		'PHPHtmlParser',
		'PhpParser',
		'PHPUnit',
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
else
	{
	$fileManager = new \PHPFUI\InstaDoc\FileManager('../');
	}

$fileManager->load();
$controller = new \PHPFUI\InstaDoc\Controller($fileManager);
$controller->setGitRoot(getcwd() . '/../');
$controller->addHomePageMarkdown('../PHPFUI/README.md');
$controller->addHomePageMarkdown('../PHPFUI/InstaDoc/README.md');

if (true)
	{
	echo $controller->display();
	}
else
	{
	echo '<pre>';
	print_r($controller->generate('static', [\PHPFUI\InstaDoc\Controller::DOC_PAGE, \PHPFUI\InstaDoc\Controller::FILE_PAGE, ]));
	}


