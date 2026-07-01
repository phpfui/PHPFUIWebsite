<?php

include '../common.php';

\set_time_limit(99999);

$uri = $_SERVER['REQUEST_URI'] ?? '';

$controller = new \PHPFUI\NanoController($uri);

if (str_starts_with($uri, '/BuriedTreasure'))
	{
	$path = __DIR__ . '/../data/buriedtreasure.sqlite';
	\PHPFUI\ORM::addConnection(new \PHPFUI\ORM\PDOInstance('sqlite:' . $path));
	\PHPFUI\ORM::setLogger(new \PHPFUI\ORM\StandardErrorLogger());
	\PHPFUI\Translation\Translator::setTranslationDirectory(__DIR__ . '/languages');
	\PHPFUI\Translation\Translator::setLocale('en_US');

	$controller->setHomePageClass(\App\View\BuriedTreasure\HomePage::class);
	$controller->setHomePageUri('BuriedTreasure');
	$controller->setMissingMethod('home');
	$controller->setMissingClass(\App\View\BuriedTreasure\Missing::class);
	$controller->setRootNamespace('App\\WWW');
	}
else
	{
	$controller->setHomePageClass(\App\View\PHPFUIPage::class);
	$controller->setRootNamespace('App\\WWW');
	$controller->setMissingClass('App\Missing');
	}

echo $controller->run();


