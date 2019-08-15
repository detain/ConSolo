<?php
/**
* @link https://github.com/Oefenweb/damerau-levenshtein
*/
namespace Detain\ConSolo\Matching;

require_once __DIR__.'/../bootstrap.php';

use Oefenweb\DamerauLevenshtein\DamerauLevenshtein;

$DamerauLevenshtein = new DamerauLevenshtein($input[0], $input[1]);
$result = $DamerauLevenshtein->getSimilarity();
print_r($result);
