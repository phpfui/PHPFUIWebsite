<?php

include '../common.php';

$daysBack = 1;

\SessionManager::purgeOld(24 * 60 * 60 * $daysBack);
