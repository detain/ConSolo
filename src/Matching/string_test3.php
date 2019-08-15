<?php
/**
* @link https://github.com/wyndow/fuzzywuzzy
*/
namespace Detain\ConSolo\Matching;

require_once __DIR__.'/../bootstrap.php';

use FuzzyWuzzy\Fuzz;
use FuzzyWuzzy\Process;

$fuzz = new Fuzz();
$process = new Process($fuzz); // $fuzz is optional here, and can be omitted.

$choices = ['Atlanta Falcons', 'New York Jets', 'New York Giants', 'Dallas Cowboys'];
$result = $process->extract('new york jets', $choices, null, null, 2);
print_r($result);
/* [
     [
       "New York Jets",
       100,
     ],
     [
       "New York Giants",
       78,
     ],
   ] */