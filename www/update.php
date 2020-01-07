<?php

include '../commonbase.php';

$repo = new \Gitonomy\Git\Repository($_SERVER['DOCUMENT_ROOT'] . '/..');
$wc = $repo->getWorkingCopy();
$wc->checkout('master');
$repo->run('pull');
@unlink('../FileManager.json');
file_get_contents('http://www.phpfui.com');
