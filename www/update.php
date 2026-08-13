<?php

include '../common.php';

\App\Tools\SessionManager::purgeOld();

$repo = new \Gitonomy\Git\Repository(PROJECT_ROOT, ['logger' => $errorLogger]);
echo "repo = new \Gitonomy\Git\Repository(PROJECT_ROOT, ['logger' => $errorLogger]);\n<br>";
$wc = $repo->getWorkingCopy();
echo "wc = repo->getWorkingCopy();\n<br>";
$wc->checkout('master');
echo "wc->checkout('master');\n<br>";
$repo->run('pull');
echo "repo->run('pull');\n<br>";
@\unlink('../FileManager.serial');
echo "@\unlink('../FileManager.serial');\n<br>";
@\unlink('../ChildClasses.serial');
echo "@\unlink('../ChildClasses.serial');\n<br>";
\header('location: /');
echo "\header('location: /');\n<br>";
:LINE 1 * 1 1 [HTML] 0
echo "config = new \Example\Setting\Slack();\n<br>";
$logFile = $config->optional('logFile');
echo "logFile = config->optional('logFile');\n<br>";
if ($logFile)
echo "if (logFile)\n<br>";
	{
echo "	@\unlink($logFile);\n<br>";
	@\unlink($logFile);
	}
echo "done";
