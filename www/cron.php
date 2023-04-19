<?php

include '../common.php';

$daysBack = 1;

\Example\Tool\SessionManager::purgeOld(24 * 60 * 60 * $daysBack);
