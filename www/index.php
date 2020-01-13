<?php
include '../commonbase.php';

set_time_limit(99999);

if (true)
	{
	$fileManager = new \PHPFUI\InstaDoc\FileManager();
	$fileManager->addNamespace('PHPFUI', '../PHPFUI', true);
	$fileManager->addNamespace('PHPUnit', '../PHPUnit', true);
	$fileManager->addNamespace('Gitonomy', '../Gitonomy', true);
	$fileManager->addNamespace('Highlight', '../Highlight', true);
	$fileManager->addNamespace('Symfony', '../Symfony', true);
	$fileManager->addNamespace('phpDocumentor', '../phpDocumentor', true);
	$fileManager->addNamespace('Webmozart', '../Webmozart', true);
	$fileManager->addNamespace('\\', '../NoNameSpace', true);
	}
else
	{
	$fileManager = new \PHPFUI\InstaDoc\FileManager('../');
	}

$fileManager->load();
$controller = new \PHPFUI\InstaDoc\Controller($fileManager);
$controller->setGitRoot('../');
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


