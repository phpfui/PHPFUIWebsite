<?php
$container = new \PHPFUI\Container();

$container->add(new \PHPFUI\Button('Learn More', '#0'));
$container->add(new \PHPFUI\Button('View All Features', '#features'));

$save = new \PHPFUI\Button('Save');
$save->addClass('success');
$container->add($save);

$save = new \PHPFUI\Button('Delete');
$save->addClass('alert');
$container->add($save);

$tiny = new \PHPFUI\Button('So Tiny', '#0');
$tiny->addClass('tiny');
$container->add($tiny);

$small = new \PHPFUI\Button('So Small', '#0');
$small->addClass('small');
$container->add($small);

$large = new \PHPFUI\Button('So Large', '#0');
$large->addClass('large');
$container->add($large);

$expand = new \PHPFUI\Button('Such Expand', '#0');
$expand->addClass('expanded');
$container->add($expand);

$group = new \PHPFUI\ButtonGroup();
$group->addButton(new \PHPFUI\Button('One'));
$group->addButton(new \PHPFUI\Button('Two'));
$group->addButton(new \PHPFUI\Button('Three'));
$container->add($group);

return $container;