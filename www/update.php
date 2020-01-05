<?php

include '../commonbase.php';

$repo = new \Gitonomy\Git\Repository($_SERVER['DOCUMENT_ROOT'] . '/..');
$wc = $repo->getWorkingCopy();
$wc->checkout('origin/master');
$wc->run('pull');

