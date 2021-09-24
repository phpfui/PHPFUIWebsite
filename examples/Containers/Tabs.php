<?php
$container = new \PHPFUI\Container();
$tabs = new \PHPFUI\Tabs();
$tabs->addTab('One', 'Check me out! I\'m a super cool Tab panel with text content!');
$image = new \PHPFUI\Thumbnail(new \PHPFUI\Image('/images/rectangle-7.jpg'));
$tabs->addTab('Two', $image, true);
$tabs->addTab('Three', 'Nothing to see here.');
$image = new \PHPFUI\Thumbnail(new \PHPFUI\Image('/images/rectangle-2.jpg'));
$tabs->addTab('Four', $image);
$tabs->addTab('Five', 'Still nothing to see here.');
$image = new \PHPFUI\Thumbnail(new \PHPFUI\Image('/images/rectangle-8.jpg'));
$tabs->addTab('Six', $image);
$container->add($tabs);

return $container;