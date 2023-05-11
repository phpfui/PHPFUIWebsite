<?php

$container = new \PHPFUI\Container();

$closeBox = new \PHPFUI\Callout();
$close = new \PHPFUI\CloseButton($closeBox);
$closeBox->add('<p>You can so totally close this!</p>');
$closeBox->add($close);
$container->add($closeBox);

$closeBox = new \PHPFUI\Callout();
$closeBox->addClass('success');
$close = new \PHPFUI\CloseButton($closeBox, 'slide-out-right');
$closeBox->add('<p>You can close me too, and I close using a Motion UI animation.</p>');
$closeBox->add($close);
$container->add($closeBox);

return $container;
