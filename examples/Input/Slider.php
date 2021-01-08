<?php
$container = new \PHPFUI\Container();

$container->add(new \PHPFUI\Slider(25));

$data = new \PHPFUI\Input('number', 'data');
$slider = new \PHPFUI\Slider(12, new \PHPFUI\SliderHandle(12, $data));
$slider->setVertical();
$container->add($slider);
$container->add($data);

$firstHandle = new \PHPFUI\Input('number', 'first');
$secondHandle = new \PHPFUI\Input('number', 'second');
$slider = new \PHPFUI\Slider(25, new \PHPFUI\SliderHandle(25, $firstHandle));
$slider->setRangeHandle(new \PHPFUI\SliderHandle(75, $secondHandle));
$container->add($slider);
$container->add(new \PHPFUI\MultiColumn($firstHandle, $secondHandle));

return $container;