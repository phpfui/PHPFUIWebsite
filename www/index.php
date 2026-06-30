<?php

include '../common.php';

\set_time_limit(99999);

$uri = $_SERVER['REQUEST_URI'] ?? '';

$controller = new \PHPFUI\NanoController($uri);

if (str_starts_with($uri, '/BuriedTreasure'))
	{
	$controller->setHomePageClass(\App\View\BuriedTreasure\HomePage::class);
	$controller->setHomePageUri('BuriedTreasure');
	$controller->setMissingMethod('home');
	$controller->setRootNamespace('App\\WWW');
	}
else
	{
	$controller->setHomePageClass(\App\View\PHPFUIPage::class);
	$controller->setRootNamespace('App\\WWW');
	}
	$controller->setMissingClass('App\Missing');

echo $controller->run();


