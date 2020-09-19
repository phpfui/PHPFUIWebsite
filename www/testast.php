<?php
include '../commonbase.php';

$factory = new \PhpParser\ParserFactory();
$parser = $factory->create(\PhpParser\ParserFactory::PREFER_PHP7);
$code = file_get_contents('test.php');
$ast = $parser->parse($code);
$prettyPrinter = new \PhpParser\PrettyPrinter\Standard(['shortArraySyntax' => true]);
$code = $prettyPrinter->prettyPrint($ast);
echo "<pre>Code\n";
echo htmlentities($code);
print_r($ast);

