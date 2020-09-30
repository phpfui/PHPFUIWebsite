<?php

include '../common.php';

$daysBack = 5;

\SessionManager::purgeOld(24 * 60 * 60 * $daysBack);


