<?php
$menu = new \PHPFUI\Menu();
$menu->setIconAlignment('left');
$menu->addClass('vertical medium-horizontal');
$item = new \PHPFUI\MenuItem('One', '#');
$item->setIcon(new \PHPFUI\IconBase('fas fa-bars'));
$menu->addMenuItem($item);
$item = new \PHPFUI\MenuItem('Two', '#');
$item->setIcon(new \PHPFUI\IconBase('fas fa-bars'));
$menu->addMenuItem($item);
$item = new \PHPFUI\MenuItem('Three', '#');
$item->setIcon(new \PHPFUI\IconBase('fas fa-bars'));
$menu->addMenuItem($item);
$item = new \PHPFUI\MenuItem('Four', '#');
$item->setIcon(new \PHPFUI\IconBase('fas fa-bars'));
$menu->addMenuItem($item);

return $menu;