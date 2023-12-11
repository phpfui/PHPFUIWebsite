<?php

include '../../common.php';

\PHPFUI\Session::setFlash('post', '');

echo new \Example\EMailButtonGenerator($_GET);
