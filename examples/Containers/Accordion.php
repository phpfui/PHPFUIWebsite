<?php
$accordion = new \PHPFUI\Accordion();
$accordion->addTab('Accordion 1', '<p>Panel 1. Lorem ipsum dolor</p><a href="#">Nowhere to Go</a>');
$textArea = new \PHPFUI\Input\TextArea('textarea', '');
$button = new \PHPFUI\Button('I do nothing!');
$accordion->addTab('Accordion 2', $textArea . $button);
$accordion->addTab('Accordion 3', new \PHPFUI\Input\Text('name', 'Type your name!'));
return $accordion;