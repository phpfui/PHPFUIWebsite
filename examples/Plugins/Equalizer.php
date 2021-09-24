<?php
$innerEqualizer = new \PHPFUI\Equalizer(new \PHPFUI\Callout());
$co1 = new \PHPFUI\Callout('primary');
$co1->add('This is a callout');
$co2 = new \PHPFUI\Callout('warning');
$co2->add('Warning Will Robinson');
$co3 = new \PHPFUI\Callout('error');
$co3->add('Stack Overflow with much more text and it just keeps going and going.  I wish there was some way to autogenerate text in PHP.');
$innerEqualizer->addElement(new \PHPFUI\Image('/images/square-1.jpg'));
//$innerEqualizer->addElement($co2);
//$innerEqualizer->addElement($co3);

$equalizer = new \PHPFUI\Equalizer();
$co2 = new \PHPFUI\Callout();
$co2->add('Pellentesque habitant morbi tristique senectus et netus et, ante.');
$co3 = new \PHPFUI\Callout();
$co3->add(new \PHPFUI\Image('/images/rectangle-1.jpg'));
$equalizer->addColumn($innerEqualizer);
$equalizer->addColumn($co2);
$equalizer->addColumn($co3);

return $equalizer;