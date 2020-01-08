<?php

include 'commonbase.php';

function deleteFiles(string $dir)
	{
	try
		{
			$iterator = new RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST);
			foreach ($iterator as $filename => $fileInfo)
				{
				if (! $fileInfo->isDir())
					{
					unlink($filename);
					}
				}
		}
	catch (\Exception $e)
		{
		}
	}

function copyFiles(string $source, string $dest)
	{
	if (! file_exists($dest))
		{
		mkdir($dest, 0755, true);
		}
	$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
			\RecursiveIteratorIterator::SELF_FIRST);
	foreach ($iterator as $item)
		{
		$file = $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
		$file = str_replace('/', '\\', $file);
		if ($item->isDir())
			{
			if (! file_exists($file))
				{
				mkdir($file, 755, true);
				}
			}
		else
			{
			copy($item, $file);
			}
		}
	}

$baseDir = "";
$vendorDir = $baseDir.'vendor/';

$ignored = [
	'twig',
	'tinify',
	'ralouphie',
	'tecnickcom',
	'phpunit',
	'sebastian',
	'phar-io',
	'Prophecy',
//	'Webmozart',
//	'phpdocumentor',
	'doctrine',
	'theseer',
	];

$installed = json_decode(file_get_contents($vendorDir.'composer/installed.json'), true);
foreach ($installed as $install)
	{
	$use = true;
	foreach ($ignored as $ignore)
		{
		if (stripos($install['name'], $ignore) !== false)
			{
			$use = false;
			break;
			}
		}

	if (! $use)
		{
		continue;
		}

	if (isset($install['autoload']))
		{
		$autoload = $install['autoload'];
		$destDir = $sourceDir = '';
		if (! empty($autoload['psr-4']))
			{
			foreach ($autoload['psr-4'] as $destDir => $sourceDir)
				{
				}
			if (! $sourceDir)
				{
				$sourceDir = '.';
				}
			$deleteDestDir = $destDir;
			}
		else if (! empty($autoload['psr-0']))
			{
			foreach ($autoload['psr-0'] as $destDir => $sourceDir)
				{
				}
			$deleteDestDir = $destDir . '\\';
			$destDir = '.\\';
			}
		else
			{
			echo "Did not load {$install['name']}\n";
			}

		if (is_array($sourceDir))
			{
			$sourceDir = $sourceDir[0];
			}

		echo "destDir ->{$destDir}<- sourceDir ->{$sourceDir}<-\n";

		if ($destDir && $sourceDir)
			{
			$destDir = str_replace('\\', '/', $baseDir.$destDir);
			$destDir = substr($destDir, 0, strlen($destDir) - 1);
			$sourceDir = $vendorDir.$install['name'].'/'.$sourceDir;
			echo "source $sourceDir to $destDir\n";
			copyFiles($sourceDir, $destDir);
			}
		}
	else
		{
//		echo "No autoloader for {$install['name']}\n";
		}
	}

