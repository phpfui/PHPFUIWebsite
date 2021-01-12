<?php
$container = new \PHPFUI\Container();

$bar = new \PHPFUI\ProgressBar();
$bar->addClass('primary');
$bar->setCurrent(25);
$container->add($bar);

$bar = new \PHPFUI\ProgressBar();
$bar->addClass('warning');
$bar->setCurrent(50);
$container->add($bar);

$bar = new \PHPFUI\ProgressBar();
$bar->addClass('alert');
$bar->setCurrent(75);
$container->add($bar);

$bar = new \PHPFUI\ProgressBar();
$bar->addClass('success');
$bar->setCurrent(100);
$container->add($bar);

return $container;