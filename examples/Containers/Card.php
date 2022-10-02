<?php

$card = new \PHPFUI\Card();
$card->addAttribute('style', 'width: 300px');
$card->addDivider(new \PHPFUI\Header("I'm featured", 4));
$card->addImage(new \PHPFUI\Image('/images/rectangle-1.jpg'));
$card->addSection('This card makes use of the card-divider element.');

return $card;
