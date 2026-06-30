<?php

include '../common.php';

\set_time_limit(99999);

$uri = $_SERVER['REQUEST_URI'] ?? '';

$controller = new \PHPFUI\NanoController($uri);

$controller->setMissingClass('App\Missing');
$controller->setHomePageClass('App\\View\\PHPFUIPage');
$controller->setRootNamespace('App');

echo $controller->run();

