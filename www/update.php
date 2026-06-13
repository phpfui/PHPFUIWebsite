<?php

include '../common.php';

$repo = new \Gitonomy\Git\Repository(PROJECT_ROOT);
$wc = $repo->getWorkingCopy();
$wc->checkout('master');
$repo->run('pull');
@\unlink('../FileManager.serial');
@\unlink('../ChildClasses.serial');
\header('location: /');
$config = new \Example\Setting\Slack();
$logFile = $config->optional('logFile');
if ($logFile)
	{
	@\unlink($logFile)
	}
