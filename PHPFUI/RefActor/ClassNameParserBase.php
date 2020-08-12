<?php

namespace PHPFUI\RefActor;

abstract class ClassNameParserBase
	{

	abstract public function getNamespace(string $file) : string;

	abstract public function getClassName(string $file) : string;

	}


