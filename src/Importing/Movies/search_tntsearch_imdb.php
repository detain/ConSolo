<?php
/**
* @link https://github.com/loilo/Fuse 
*/

use TeamTNT\TNTSearch\TNTSearch;

require_once __DIR__.'/../../../bootstrap.php';

global $config;
$tnt = new TNTSearch;
$tnt->loadConfig([
	'driver'    => 'mysql',
	'host'      => $config['db']['host'],
	'database'  => $config['db']['name'],
	'username'  => $config['db']['user'],
	'password'  => $config['db']['pass'],
	'storage'   => __DIR__.'/../../../../data/tntsearch/',
	'stemmer'   => \TeamTNT\TNTSearch\Stemmer\PorterStemmer::class//optional
]);
echo 'Loading IMDB Index';
$tnt->selectIndex("imdb.index");

$res = $tnt->search("9 2009");

print_r($res); //returns an array of 12 document ids that best match your query
// to display the results you need an additional query against your application database 
// SELECT * FROM articles WHERE id IN $res ORDER BY FIELD(id, $res);
$query = 'select id, title, year from imdb where id in ("'.implode('","', $res['ids']).'") order by field(id, "'.implode('","', $res['ids']).'")';
echo $query.PHP_EOL;
global $db;
$results = $db->query($query);
print_r($results);