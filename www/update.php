<?php

include '../common.php';

echo "\App\Tools\SessionManager::purgeOld();<br>\n";
\App\Tools\SessionManager::purgeOld();

echo "repo = new \Gitonomy\Git\Repository(PROJECT_ROOT, ['logger' => errorLogger]);<br>\n";
$repo = new \Gitonomy\Git\Repository(PROJECT_ROOT, ['logger' => $errorLogger]);
echo "wc = repo->getWorkingCopy();<br>\n";
$wc = $repo->getWorkingCopy();
echo "wc->checkout('master');<br>\n";
$wc->checkout('master');
echo "repo->run('pull');<br>\n";
$repo->run('pull');
echo "@\unlink('../FileManager.serial');<br>\n";
@\unlink('../FileManager.serial');
echo "@\unlink('../ChildClasses.serial');<br>\n";
@\unlink('../ChildClasses.serial');
echo "\header('location: /');<br>\n";
\header('location: /');
echo "config = new \Example\Setting\Slack();<br>\n";
$config = new \Example\Setting\Slack();
echo "logFile = config->optional('logFile');<br>\n";
$logFile = $config->optional('logFile');
echo "if (logFile)<br>\n";
if ($logFile)
	{
echo "	@\unlink(logFile);<br>\n";
	@\unlink($logFile);
	}
echo "done<br>\n";

