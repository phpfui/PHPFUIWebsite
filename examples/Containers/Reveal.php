<?php

$container = new \PHPFUI\Container();

$openButton = new \PHPFUI\Button('Click me for a modal');
$container->add($openButton);

$reveal = new \PHPFUI\Reveal($this, $openButton);
$reveal->add(new \PHPFUI\Header('Awesome. I Have It.'));
$reveal->add('<p class="lead">Your couch. It is mine.</p>');
$reveal->add("<p>I'm a cool paragraph that lives inside of an even cooler modal. Wins!</p>");

$nestedButton = new \PHPFUI\Button('Click me for a nested modal');
$container->add($nestedButton);

$nestedReveal = new \PHPFUI\Reveal($this, $nestedButton);
$nestedReveal->add(new \PHPFUI\Header('Awesome!'));
$nestedReveal->add('<p class="lead">I have another modal inside of me!</p>');

$nestedRevealButton = new \PHPFUI\Button('Click me for another modal!');
$nestedReveal->add($nestedRevealButton);

$nestedReveal2 = new \PHPFUI\Reveal($this, $nestedRevealButton);
$nestedReveal2->add(new \PHPFUI\Header('ANOTHER MODAL!!!'));

return $container;
