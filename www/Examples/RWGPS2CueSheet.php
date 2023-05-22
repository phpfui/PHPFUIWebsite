<?php

include '../../common.php';

\PHPFUI\Session::setFlash('post', '');

echo new \Example\RWGPS2CueSheet($_GET);

