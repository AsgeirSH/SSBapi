<?php

require_once(__DIR__.'/../vendor/autoload.php');
require_once(__DIR__."/Levendefodte.php");

$levendefodte = new Levendefodte();
$levendefodte->year = 2015;
$levendefodte->buildQuery();
echo 'Query:'."\n";
var_dump($levendefodte->query());
$result = $levendefodte->run();
echo 'Result:'."\n";
var_dump($result);
