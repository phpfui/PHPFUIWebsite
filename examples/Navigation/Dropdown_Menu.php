<?php

$container = new \PHPFUI\Container();

$container->add(\PHPFUI\KitchenSink::makeMenu(new \PHPFUI\DropDownMenu(), 'Drop Down Menu', '', \PHPFUI\KitchenSink::subMenu()));
$dropDown = \PHPFUI\KitchenSink::makeMenu(new \PHPFUI\DropDownMenu(), 'Drop Down Menu Vertical', 'vertical', \PHPFUI\KitchenSink::subMenu());
$container->add($dropDown);

return $container;
