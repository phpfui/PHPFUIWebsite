<?php

$container = new \PHPFUI\Container();

$iconPlain = new \PHPFUI\Icon('edit');
$container->add($iconPlain);
$iconPlainTip = new \PHPFUI\Icon('edit');
$iconPlainTip->setTooltip('I am a plain icon with a tooltip');
$container->add($iconPlainTip);
$iconLink = new \PHPFUI\Icon('edit', '#');
$container->add($iconLink);
$iconLinkTip = new \PHPFUI\Icon('edit', '#');
$iconLinkTip->setTooltip('I can even have a tooltip and a link!');
$container->add($iconLinkTip);

return $container;
