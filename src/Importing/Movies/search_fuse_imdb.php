<?php
/**
* @link https://github.com/loilo/Fuse 
*/

require_once __DIR__.'/../../../bootstrap.php';

$fuseWeights = [
	"keys" => [
		["name" => "year", "weight" => 0.3],
		["name" => "title", "weight" => 0.7]
]];
$fuseData = json_decode(file_get_contents(__DIR__.'/../../../../data/json/imdb_fuse.json'), true);
$fuse = new \Fuse\Fuse($fuseData, $fuseWeights);
$results = $fuse->search('10 Things I Hate About You (1999) 720p');
print_r($results);
