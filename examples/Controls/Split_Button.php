<?php
$splitButton = new \PHPFUI\SplitButton('Split', '#');
$splitButton->addMenuItem(new \PHPFUI\MenuItem('Option 4', '#'));
$splitButton->addMenuItem(new \PHPFUI\MenuItem('Option 3', '#'));
$splitButton->addMenuItem(new \PHPFUI\MenuItem('Option 5', '#'));
$splitButton->addMenuItem(new \PHPFUI\MenuItem('Option 1', '#'));
$splitButton->addMenuItem(new \PHPFUI\MenuItem('Option 2', '#'));
$splitButton->sort();

return $splitButton;