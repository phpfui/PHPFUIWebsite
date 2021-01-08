<?php
$container = new \PHPFUI\Container();

$toggleDropdownButton = new \PHPFUI\Button('Toggle Dropdown');
$panel = new \PHPFUI\HTML5Element('div');
$panel->add('Just some junk that needs to be said. Or not. Your choice.');

$toggleDropdown = new \PHPFUI\DropDown($toggleDropdownButton, $panel);
$container->add($toggleDropdown);

$hoverDropdownButton = new \PHPFUI\Button('Hoverable Dropdown');
$panel = new \PHPFUI\HTML5Element('div');
$panel->add('Just some junk that needs to be said. Or not. Your choice.');

$hoverDropdown = new \PHPFUI\DropDown($hoverDropdownButton, $panel);
$hoverDropdown->setHover();
$container->add($hoverDropdown);

return $container;