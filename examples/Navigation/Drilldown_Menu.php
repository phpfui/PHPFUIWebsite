<?php

$container = new \PHPFUI\Container();

$container->add(\PHPFUI\KitchenSink::makeMenu(new \PHPFUI\DrillDownMenu(), 'Drill Down Menu', '', \PHPFUI\KitchenSink::subMenu()));

$drillDown = \PHPFUI\KitchenSink::makeMenu(new \PHPFUI\DrillDownMenu(), 'Drill Down Menu Auto Height', '', \PHPFUI\KitchenSink::subMenu());
$drillDown->setAutoHeight();
$container->add($drillDown);

return $container;
