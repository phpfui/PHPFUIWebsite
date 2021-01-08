<?php
$orbit = new \PHPFUI\Orbit('Some out of the world images');
$orbit->addImageSlide(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/orbit/01.jpg'), 'Space, the final frontier.');
$orbit->addImageSlide(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/orbit/02.jpg'), 'Lets Rocket!', true);
$orbit->addImageSlide(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/orbit/03.jpg'), 'Encapsulating');
$orbit->addImageSlide(new \PHPFUI\Image('https://foundation.zurb.com/sites/docs/assets/img/orbit/04.jpg'), 'Outta This World');

return $orbit;