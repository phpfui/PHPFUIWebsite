<?php

include '../../common.php';

\PHPFUI\Session::setFlash('post', '');

echo new \Example\GPX2CueSheet($_GET);
