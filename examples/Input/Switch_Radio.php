<?php
$container = new \PHPFUI\GridX();
$switchRB1 = new \PHPFUI\Input\SwitchRadio('radio', 1);
$switchRB1->setActiveLabel('Yes')->setInactiveLabel('No')->addClass('large');
$container->add($switchRB1);
$container->add(' &nbsp; ');

$switchRB2 = new \PHPFUI\Input\SwitchRadio('radio', 2);
$container->add($switchRB2->setChecked());
$container->add(' &nbsp; ');

$switchRB3 = new \PHPFUI\Input\SwitchRadio('radio', 3);
$container->add($switchRB3->addClass('tiny'));

return $container;