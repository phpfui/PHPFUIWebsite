<?php
$container = new \PHPFUI\Container();

$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu'));
$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu Right', 'align-right'));
$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu Center', 'align-center'));
$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu Expanded', 'expanded'));
$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu Vertical', 'vertical'));
$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu Vertical Right', 'vertical align-right'));
$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu Vertical Center', 'vertical align-center'));
$container->add($this->makeMenu(new \PHPFUI\Menu(), 'Menu Simple', 'simple'));

return $container;