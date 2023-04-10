<?php

$container = new \PHPFUI\Container();

$container->add(\PHPFUI\KitchenSink::makeMenu(new \PHPFUI\DropDownMenu(), 'Drop Down Menu', '', $this->subMenu()));
$dropDown = \PHPFUI\KitchenSink::makeMenu(new \PHPFUI\DropDownMenu(), 'Drop Down Menu Vertical', 'vertical', $this->subMenu());
$dropDown->computeWidth();
$container->add($dropDown);

return $container;
