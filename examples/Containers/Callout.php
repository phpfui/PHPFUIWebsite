<?php
$container = new \PHPFUI\Container();

foreach (['', 'primary', 'secondary', 'success', 'warning', 'alert'] as $type)
 	{
 	$callout = new \PHPFUI\Callout($type);
 	$callout->add(new \PHPFUI\Header("This is a {$type} callout.", 4));
 	$callout->add('<p>It has an easy to override visual style, and is appropriately subdued.</p>');
 	$callout->add(new \PHPFUI\Link('#', "It's dangerous to go alone, take this."));
 	$container->add($callout);
 	}

return $container;