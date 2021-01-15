<?php

include '../common.php';

\PHPFUI\Base::setDebug(1);

$number = new \PHPFUI\Input\Text('number', 'Number Required', 99999);
$number->setPlaceholder(1234);
$number->setRequired();
$number->setHint("Here's how you use this input field!");
$number->setErrorMessages(["Yo, you had better fill this out, it's required."]);
$number->setAttribute('pattern', 'number');


echo htmlspecialchars($number);
