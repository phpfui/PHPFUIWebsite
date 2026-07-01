<?php
include 'commonbase.php';

function trans(string $text, array $parameters = []) : string
	{
	return \PHPFUI\Translation\Translator::trans($text, $parameters);
	}

\App\Tools\SessionManager::start();

