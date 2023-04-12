<?php

$topbar = new \PHPFUI\TopBar();
$topbar->addLeft(\PHPFUI\KitchenSink::makeMenu(new \PHPFUI\DropDownMenu(), 'Site Title', '', \PHPFUI\KitchenSink::subMenu()));

$menu = new \PHPFUI\Menu();
$search = new \PHPFUI\Input('search', '');
$search->addAttribute('placeholder', 'Search');
$menu->addMenuItem(new \PHPFUI\MenuItem($search));
$menu->addMenuItem(new \PHPFUI\MenuItem(new \PHPFUI\Button('Search')));
$topbar->addRight($menu);

return $topbar;
