<?php
$container = new \PHPFUI\Container();

$container->add(new \PHPFUI\Thumbnail(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/01.jpg')));
$container->add(new \PHPFUI\Thumbnail(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/02.jpg')));
$container->add(new \PHPFUI\Thumbnail(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/thumbnail/03.jpg')));

return $container;