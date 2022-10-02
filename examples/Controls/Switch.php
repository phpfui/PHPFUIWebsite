<?php

$container = new \PHPFUI\Container();

$tiny = new \PHPFUI\Input\SwitchCheckBox('tiny');
$tiny->addClass('tiny');
$container->add($tiny);
$container->add(new \PHPFUI\Input\SwitchCheckBox('normal'));
$switchCB = new \PHPFUI\Input\SwitchCheckBox('name', true, 'Do you like me?');
$switchCB->setActiveLabel('Yes')->setInactiveLabel('No')->addClass('large');
$container->add($switchCB);

return $container;
