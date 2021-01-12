<?php
$form = new \PHPFUI\Form($this);
$form->setAreYouSure(false);
$post = \PHPFUI\Session::getFlash('post');
if ($post)
	{
	$post = json_decode($post, true);
	}
else
	{
	$post = [];
	}
$form->add(new \PHPFUI\FormError('There are some errors in your form.'));

$number = new \PHPFUI\Input\Text('number', 'Number Required', $post['number'] ?? '');
$number->setPlaceholder(1234);
$number->setRequired();
$number->setHint("Here's how you use this input field!");
$number->setErrorMessages(["Yo, you had better fill this out, it's required."]);
$number->setAttribute('pattern', 'number');
$form->add($number);

$text = new \PHPFUI\Input\Text('text', 'Nothing Required!', $post['text'] ?? '');
$text->setPlaceholder("Use me, or don&apos;t");
$text->setHint('This input is ignored by Abide using `data-abide-ignore`');
$form->add($text);

$password = new \PHPFUI\Input\Password('password', 'Password Required', $post['password'] ?? '');
$password->setRequired();
$password->setErrorMessages(["I'm required"]);
$password->setHint('Enter a password please.');
$password->setPlaceholder('yeti4preZ');
$form->add($password);

$passwordConfirm = new \PHPFUI\Input\Password('passwordConfirm', 'Re-enter Password', $post['passwordConfirm'] ?? '');
$passwordConfirm->setRequired();
$passwordConfirm->setErrorMessages(["Hey, passwords are supposed to match!"]);
$passwordConfirm->setHint('This field is using the `data-equalto="password"` attribute, causing it to match the password field above.');
$passwordConfirm->setPlaceholder('yeti4preZ');
$passwordConfirm->setAttribute('data-equalto', $password->getId());
$form->add($passwordConfirm);

$url = new \PHPFUI\Input\Text('url', "URL Pattern, not required, but throws error if it doesn't match the Regular Expression for a valid URL.");
$url->setAttribute('pattern', 'url', $post['url'] ?? '');
$url->setPlaceholder('https://get.foundation');

$carSelect = new \PHPFUI\Input\Select('car', "European Cars, Choose One, it can't be the blank option.");
$carSelect->setRequired();
$carSelect->addOption('');
$carSelect->addOption('Volvo', 'volvo');
$carSelect->addOption('Saab', 'saab');
$carSelect->addOption('Mercedes', 'mercedes');
$carSelect->addOption('Audi', 'audi');
$carSelect->select($post['car'] ?? '');

$form->add(new \PHPFUI\MultiColumn($url, $carSelect));

$colorRequired = new \PHPFUI\Input\RadioGroup('colorRequired', 'Choose Your Favorite, and this is required, so you have to pick one.', $post['colorRequired'] ?? '');
$colorRequired->setRequired();
$colorRequired->addButton('Red');
$colorRequired->addButton('Blue');
$colorRequired->addButton('Yellow');

$color = new \PHPFUI\Input\RadioGroup('color', 'Choose Your Favorite - not required, you can leave this one blank.', $post['color'] ?? '');
$color->addButton('Red');
$color->addButton('Blue');
$color->addButton('Yellow');

$form->add(new \PHPFUI\MultiColumn($colorRequired, $color));

$checkBoxes = new \PHPFUI\CheckBoxGroup('Check these out');
for ($i = 1; $i <= 3; ++$i)
	{
	$field = 'CB' . $i;
	$checkBoxes->addCheckBox(new \PHPFUI\Input\CheckBoxBoolean($field, 'Checkbox ' . $i, $post[$field] ?? false));
	}

$form->add($checkBoxes);
$form->add(new \PHPFUI\MultiColumn(new \PHPFUI\Submit(), new \PHPFUI\Reset()));
return $form;