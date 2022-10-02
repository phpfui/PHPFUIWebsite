<?php

$dropDownButton = new \PHPFUI\DropDownButton('Drop Down Button');
$dropDownButton->addMenuItem(new \PHPFUI\MenuItem('Option 4', '#'));
$dropDownButton->addMenuItem(new \PHPFUI\MenuItem('Option 3', '#'));
$dropDownButton->addMenuItem(new \PHPFUI\MenuItem('Option 5', '#'));
$dropDownButton->addMenuItem(new \PHPFUI\MenuItem('Option 1', '#'));
$dropDownButton->addMenuItem(new \PHPFUI\MenuItem('Option 2', '#'));
$dropDownButton->sort();

return $dropDownButton;
