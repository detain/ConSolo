<?php
/**
* @link https://github.com/Loilo/Fuse
*/
namespace Detain\ConSolo\Matching;

require_once __DIR__.'/../bootstrap.php';

use \Fuse\Fuse;

$fuse = new Fuse([
  [
    "title" => "Old Man's War",
    "author" => "John Scalzi"
  ],
  [
    "title" => "The Lock Artist",
    "author" => "Steve Hamilton"
  ],
  [
    "title" => "HTML5",
    "author" => "Remy Sharp"
  ],
  [
    "title" => "Right Ho Jeeves",
    "author" => "P.D Woodhouse"
  ],
], [
  "keys" => [ "title", "author" ],
]);

$result = $fuse->search('hamil');
print_r($result);