<?php

exec('/usr/bin/php8.0 composer.phar self-update');

include 'commonbase.php';

// get the latest
$repo = new \Gitonomy\Git\Repository(__DIR__);
$wc = $repo->getWorkingCopy();
$wc->checkout('master');
$repo->run('pull');

exec('/usr/bin/php8.0 composer.phar update');

// Localize files
$updater = new ComposerUpdate();

$updater->setIgnoredRepos([
	'components',
	'Composer',
	'doctrine',
	'GPBMetadata',
	'Jean85',
	'OndraM',
	'PackageVersions',
	'phar-io',
	'PHPStan',
	'sebastian',
	'phpunit',
	'phpspec',
	'ralouphie',
	'Symplify',
	'tecnickcom',
	'theseer',
	'tinify',
	'twig',
]);

$updater->setBaseDirectory(PROJECT_ROOT . '/');
$updater->update();
$updater->deleteNamespace('Symfony\Polyfill');
$updater->deleteNamespace('HighlightUtilities');
$updater->deleteNamespace('cebe\markdown\tests');
$updater->deleteFileInNamespace('NoNameSpace', 'fpdf.php');
$updater->deleteFileInNamespace('DeepCopy', 'deep_copy.php');
$updater->deleteFileInNamespace('GuzzleHttp', 'functions.php');
$updater->deleteFileInNamespace('GuzzleHttp', 'functions_include.php');

// update the public files
exec('/usr/bin/php8.0 vendor/phpfui/instadoc/install.php www/PHPFUI');

// Stage all changed files
$repo->run('add', ['.']);

// if any files are staged, then make new version, else bail as we are done
$output = $repo->run('status', ['--porcelain']);
if (! strlen(trim($output)))
	{
	exit;
	}

$date = date('Y-m-d');
$repo->run('commit', ['-m', "Composer update on {$date}"]);

// push and publish
$repo->run('push');

// refresh the web site
file('http://www.phpfui.com/update.php');
