<?php

$container = new \PHPFUI\Container();

for ($i = 1; $i <= 6; ++$i)
	{
	$container->add(new \PHPFUI\Header('Header ' . $i, $i));
	}

return $container;
