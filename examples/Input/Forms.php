<?php
$container = new \PHPFUI\Container();

$input = new \PHPFUI\Input\Text('inputLabel', 'Input Label');
$helpText = new \PHPFUI\HTML5Element('p');
$helpText->add("Here's how you use this input field!");
$helpText->addClass('help-text');
$input->addAttribute('placeholder', '.small-12.columns');
$input->addAttribute('aria-describedby', $helpText->getId());
$container->add($input);
$container->add($helpText);

$container->add(new \PHPFUI\Input\Number('puppies', 'How many puppies?', 100));
$books = new \PHPFUI\Input\TextArea('books', 'What books did you read over summer break?');
$books->addAttribute('placeholder', 'None');
$container->add($books);

$selectMenu = new \PHPFUI\Input\Select('menu', 'Select Menu');
$selectMenu->addOption('Husker', 'husker');
$selectMenu->addOption('Starbuck', 'starbuck');
$selectMenu->addOption('Hot Dog', 'hotdog');
$selectMenu->addOption('Apollo', 'apollo');
$container->add($selectMenu);

$color = new \PHPFUI\Input\RadioGroup('color', 'Choose Your Favorite');
$color->addButton('Red');
$color->addButton('Blue');
$color->addButton('Yellow');

$checkBoxes = new \PHPFUI\CheckBoxGroup('Check these out');
$checkBoxes->setToolTip('This is a tool tip you can add to any input field');
for ($i = 1; $i <= 3; ++$i)
	{
	$checkBoxes->addCheckBox(new \PHPFUI\Input\CheckBoxBoolean('cb' . $i, 'Checkbox ' . $i));
	}
$container->add(new \PHPFUI\MultiColumn($color, $checkBoxes));

$inputGroup = new \PHPFUI\InputGroup();
$inputGroup->addLabel('$');
$inputGroup->addInput(new \PHPFUI\Input\Text('currency', ''));
$inputGroup->addButton(new \PHPFUI\Submit('Submit'));
$container->add($inputGroup);

return $container;