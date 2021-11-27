<?php

$php = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? 'php' : '/usr/bin/php8.0';

exec($php . ' composer.phar self-update');

include 'commonbase.php';

// get the latest
$repo = new \Gitonomy\Git\Repository(__DIR__);
$repo->run('checkout', ['master']);
$repo->run('pull');

exec($php . ' composer.phar update');

// Localize files
$updater = new ComposerUpdate();

$updater->setIgnoredRepos([
	'components',
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
$updater->deleteNamespace('Highlight\Highlight');
$updater->deleteNamespace('Highlight\HighlightUtilities');
$updater->deleteNamespace('HighlightUtilities');
$updater->deleteNamespace('cebe\markdown\tests');
$updater->deleteFileInNamespace('NoNameSpace', 'fpdf.php');
$updater->deleteFileInNamespace('DeepCopy', 'deep_copy.php');
$updater->deleteFileInNamespace('GuzzleHttp', 'functions.php');
$updater->deleteFileInNamespace('GuzzleHttp', 'functions_include.php');

// update the public files
exec($php . ' vendor/phpfui/instadoc/install.php www/PHPFUI');

// don't update if running under windows
if ($php == 'php')
	{
	exit;
	}

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

