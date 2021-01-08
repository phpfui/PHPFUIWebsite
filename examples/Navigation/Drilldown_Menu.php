<?php
$container = new \PHPFUI\Container();

$container->add($this->makeMenu(new \PHPFUI\DrillDownMenu(), 'Drill Down Menu', '', $this->subMenu()));

$drillDown = $this->makeMenu(new \PHPFUI\DrillDownMenu(), 'Drill Down Menu Auto Height', '', $this->subMenu());
$drillDown->setAutoHeight();
$container->add($drillDown);

return $container;