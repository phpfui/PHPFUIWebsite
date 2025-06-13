<?php

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
	{
	$php = 'php';
	$composer = 'C:\ProgramData\ComposerSetup\bin\composer';
	}
else
	{
	$php = '/usr/bin/php8.2-cli';
	$composer = 'composer.phar';
	}

$composer = $php . ' ' . $composer;

exec($composer . ' self-update');

include 'commonbase.php';

//// get the latest
$repo = new \Gitonomy\Git\Repository(__DIR__);
$repo->run('checkout', ['master']);
$repo->run('pull');

$updater = new ComposerUpdate();
exec($composer . ' update');

// Localize files
$updater->setNoNameSpaceDirectory(__DIR__);
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
$updater->deleteFileInNamespace('DeepCopy', 'deep_copy.php');
$updater->deleteFileInNamespace('GuzzleHttp', 'functions.php');
$updater->deleteFileInNamespace('GuzzleHttp', 'functions_include.php');
$updater->deleteFileInNamespace('Google\Auth\Cache', 'Item.php');

// update the public files
exec($php . ' vendor/phpfui/instadoc/install.php www/PHPFUI');

// copy docs to correct locations
$vendorDir = 'vendor/phpfui/';
copy($vendorDir . 'phpfui/README.md', 'PHPFUI/README.md');
copy($vendorDir . 'phpfui/src/PHPFUI/PayPal.md', 'PHPFUI/PayPal.md');
copy($vendorDir . 'phpfui/src/PHPFUI/PayPal.md', 'PHPFUI/PayPal.md');
// copy ORM docs in to ORM directory
foreach (new \DirectoryIterator($vendorDir . 'orm/docs') as $fileInfo)
	{
	$file = $fileInfo->getFilename();
	if (str_ends_with($file, '.md'))
		{
		copy($fileInfo->getPathname(), 'PHPFUI/ORM/' . $file);
		}
	}

upperCaseFile('fpdf.php');

// don't update if running under windows
if ($php == 'php')
	{
	echo "Running under Windows, exiting.\n";
	exit;
	}

// Stage all changed files
$repo->run('add', ['.']);

// if any files are staged, then make new version, else bail as we are done
$output = $repo->run('status', ['--porcelain']);
echo $output;
if (! strlen(trim($output)))
	{
	echo "No changes detected, exiting.\n";
	exit;
	}

$date = date('Y-m-d');
$repo->run('commit', ['-m', "Composer update on {$date}"]);

// push and publish
$repo->run('push');

// refresh the web site
file('http://www.phpfui.com/update.php');

echo "http://www.phpfui.com updated.\n";

function upperCaseFile(string $file)
	{
	$contents = file_get_contents($file);
	if (is_file($file))
		{
		unlink($file);
		}
	$parts = explode('.', $file);
	$parts[0] = strtoupper($parts[0]);
	$file = implode('.', $parts);
	if (is_file($file))
		{
		unlink($file);
		}
	file_put_contents($file, $contents);
	}

