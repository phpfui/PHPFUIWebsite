<?php

include '../commonbase.php';

// start the session
\SessionManager::start();

$page = new \PHPFUI\Page();
if ($_POST)
	{
	\PHPFUI\Session::setFlash('post', $_POST);
	$page->redirect();
	exit;
	}
$page->setDebug(1);
$page->addStyleSheet('css/styles.css');
$form = new \PHPFUI\Form($page);

$post = \PHPFUI\Session::getFlash('post');
if ($post)
	{
	$callout = new \PHPFUI\Callout('success');
	$callout->add(new \PHPFUI\SubHeader('POST Values'));
	$pre = new \PHPFUI\HTML5Element('pre');
	$pre->add(print_r($post, 1));
	$callout->add($pre);
	$form->add($callout);
	}

$scripts = [];
foreach (['jquery', 'what-input', ] as $library)
	{
	$value = ! empty($post[$library]);
	if ($value)
		{
		$scripts[] = $library . '.min.js';
		}
	$cb = new \PHPFUI\Input\CheckBoxBoolean($library, $library, $value);
	$cb->setToolTip("Include the $library library");
	$form->add($cb);
	}

$value = $post['foundation'] ?? 0;
$rg = new \PHPFUI\Input\RadioGroup('foundation', 'Foundation', $value);
$rg->setToolTip('Select the version of Foundation to include');
$rg->addButton('None', 0);
$rg->addButton(6.5);
$rg->addButton(6.6);
$form->add($rg);

if ($value)
	{
	$scripts[] = "foundation/js/foundation{$value}.js";
	}
$page->setBaseScripts($scripts);

$form->add(new \PHPFUI\Input\Hidden('time', date('h:i:s A')));
$form->setAreYouSure(false);
$form->add(new \PHPFUI\Submit('Submit', 'submitName'));
$form->add(new \PHPFUI\Submit('Save'));
$form->add(new \PHPFUI\Submit('Join', 'join'));
$page->add($form);

$callout = new \PHPFUI\Callout('warning');
$callout->add(new \PHPFUI\SubHeader('Scripts used'));
$pre = new \PHPFUI\HTML5Element('pre');
$pre->add(print_r($scripts, 1));
$callout->add($pre);
$form->add($callout);

echo $page;
