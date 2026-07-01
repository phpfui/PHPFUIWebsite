<?php

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
	{
	$php = 'php ';
	$composer = 'composer';
	}
else
	{
	$php = '/usr/bin/php8.5-cli ';
	$composer = $php . 'composer.phar';

	$ip4Addresses = [
		'173.245.48.0/20',
		'103.21.244.0/22',
		'103.22.200.0/22',
		'103.31.4.0/22',
		'141.101.64.0/18',
		'108.162.192.0/18',
		'190.93.240.0/20',
		'188.114.96.0/20',
		'197.234.240.0/22',
		'198.41.128.0/17',
		'162.158.0.0/15',
		'104.16.0.0/13',
		'104.24.0.0/14',
		'172.64.0.0/13',
		'131.0.72.0/22',
		];
	foreach ($ip4Addresses as $ip)
		{
		system("iptables -I INPUT -p tcp -m multiport --dports http,https -s {$ip} -j ACCEPT");
		echo "\n";
		}

	$ip6Addresses = [
		'173.245.48.0/20',
		'103.21.244.0/22',
		'103.22.200.0/22',
		'103.31.4.0/22',
		'141.101.64.0/18',
		'108.162.192.0/18',
		'190.93.240.0/20',
		'188.114.96.0/20',
		'197.234.240.0/22',
		'198.41.128.0/17',
		'162.158.0.0/15',
		'104.16.0.0/13',
		'104.24.0.0/14',
		'172.64.0.0/13',
		'131.0.72.0/22',
		];
	foreach ($ip6Addresses as $ip)
		{
		system("ip6tables -I INPUT -p tcp -m multiport --dports http,https -s {$ip} -j ACCEPT");
		echo "\n";
		}
	}

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
$updater->deleteFileInNamespace('voku', 'README.md');

// update the public files
exec($php . 'vendor/phpfui/instadoc/install.php www/PHPFUI');

// copy docs to correct locations
$vendorDir = 'vendor/phpfui/';
copy($vendorDir . 'phpfui/README.md', 'PHPFUI/README.md');
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
if ($php == 'php ')
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

