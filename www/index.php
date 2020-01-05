<?php
include '../commonbase.php';

set_time_limit(99999);

if (true)
	{
	$fileManager = new \PHPFUI\InstaDoc\FileManager();
	$fileManager->addNamespace('PHPFUI', '../PHPFUI', true);
	$fileManager->addNamespace('Gitonomy', '../Gitonomy', true);
	$fileManager->addNamespace('Highlight', '../Highlight', true);
	$fileManager->addNamespace('Symfony', '../Symfony', true);
	$fileManager->addNamespace('\\', '../NoNameSpace', true);
	}
else
	{
	$fileManager = new \PHPFUI\InstaDoc\FileManager('../');
	}

$fileManager->rescan();
$fileManager->save();
$controller = new \PHPFUI\InstaDoc\Controller($fileManager);
echo $controller->display();
//$controller->generate('static', [\PHPFUI\InstaDoc\Controller::DOC_PAGE, \PHPFUI\InstaDoc\Controller::FILE_PAGE, ]);


