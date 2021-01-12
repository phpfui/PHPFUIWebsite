<?php
$container = new \PHPFUI\Container();

$primaryBadge = new \PHPFUI\Badge('1');
$primaryBadge->addClass('primary');
$container->add($primaryBadge);

$secondaryBadge = new \PHPFUI\Badge('2');
$secondaryBadge->addClass('secondary');
$container->add($secondaryBadge);

$successBadge = new \PHPFUI\Badge('3');
$successBadge->addClass('success');
$container->add($successBadge);

$alertBadge = new \PHPFUI\Badge('A');
$alertBadge->addClass('alert');
$container->add($alertBadge);

$warningBadge = new \PHPFUI\Badge('B');
$warningBadge->addClass('warning');
$container->add($warningBadge);

return $container;