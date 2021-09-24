<?php
$container = new \PHPFUI\Container();

$toolTip = new \PHPFUI\ToolTip('scarabaeus', 'Fancy word for a beetle');
$container->add("<p>The {$toolTip} hung quite clear of any branches, and, if allowed to fall, would have fallen at our feet. Legrand immediately took the scythe, and cleared with it a circular space, three or four yards in diameter, just beneath the insect, and, having accomplished this, ordered Jupiter to let go the string and come down from the tree.</p>");

return $container;