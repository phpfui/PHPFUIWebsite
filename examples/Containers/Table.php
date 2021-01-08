<?php
$table = new \PHPFUI\Table();
$table->setCaption('This is the table caption');
$table->addArrowNavigation($this);
$headers = ['Some', 'Numbers', '4', 'U', 'Edit', 'CheckBox'];
$table->setHeaders($headers);
$table->addColumnAttribute('Numbers', ['class' => 'warning']);

for ($i = 0; $i < 10; ++$i)
	{
	$numbers = [];

	foreach ($headers as $field)
		{
		$numbers[$field] = rand();
		}

	$numbers['Edit'] = new \PHPFUI\Input\Text('edit[]');
	$numbers['CheckBox'] = new \PHPFUI\Input\CheckBox('check[]');
	$table->addRow($numbers);
	}

return $table;