<?php
$container = new \PHPFUI\Container();

$toggleAll = new \PHPFUI\Button('Toggle All These');

$image1 = new \PHPFUI\Thumbnail(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/01.jpg'));
$image2 = new \PHPFUI\Thumbnail(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/02.jpg'));
$image3 = new \PHPFUI\Thumbnail(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/03.jpg'));

$toggleAll->toggleAnimate($image1, 'hinge-in-from-left spin-out');
$toggleAll->toggleAnimate($image2, 'hinge-in-from-bottom fade-out');
$toggleAll->toggleAnimate($image3, 'slide-in-down slide-out-up');

$container->add(new \PHPFUI\MultiColumn($toggleAll));
$container->add($image1);
$container->add($image2);
$container->add($image3);

$toggleFocus = new \PHPFUI\Input\Text('test', 'Toggle on Focus');

$callout = new \PHPFUI\Callout('secondary');
$callout->add('<p>This is only visible when the above field has focus.</p>');

$toggleFocus->toggleFocus($callout, 'hinge-in-from-top hinge-out-from-bottom');

$container->add(new \PHPFUI\MultiColumn($toggleFocus));
$container->add($callout);

return $container;