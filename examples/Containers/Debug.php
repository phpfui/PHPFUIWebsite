<?php

$container = new \PHPFUI\Container();
$container->add('Some random thing');

return new \PHPFUI\Debug($container, 'Debug $container!');
