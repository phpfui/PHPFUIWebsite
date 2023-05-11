<?php

$container = new \PHPFUI\Container();

$label = new \PHPFUI\Label('Primary Label');
$label->addClass('primary');
$container->add($label);

$label = new \PHPFUI\Label('Secondary Label');
$label->addClass('secondary');
$container->add($label);

$label = new \PHPFUI\Label('Success Label');
$label->addClass('success');
$container->add($label);

$label = new \PHPFUI\Label('Alert Label');
$label->addClass('alert');
$container->add($label);

$label = new \PHPFUI\Label('Warning Label');
$label->addClass('warning');
$container->add($label);

return $container;
