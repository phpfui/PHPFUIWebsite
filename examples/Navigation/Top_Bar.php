<?php

$topbar = new \PHPFUI\TopBar();
$topbar->addLeft($this->makeMenu(new \PHPFUI\DropDownMenu(), 'Site Title', '', $this->subMenu()));

$menu = new \PHPFUI\Menu();
$search = new \PHPFUI\Input('search', '');
$search->addAttribute('placeholder', 'Search');
$menu->addMenuItem(new \PHPFUI\MenuItem($search));
$menu->addMenuItem(new \PHPFUI\MenuItem(new \PHPFUI\Button('Search')));
$topbar->addRight($menu);

return $topbar;
