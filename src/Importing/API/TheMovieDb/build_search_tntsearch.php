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
	'host'      => $config['db_host'],
	'database'  => $config['db_name'],
	'username'  => $config['db_user'],
	'password'  => $config['db_pass'],
	'storage'   => __DIR__.'/../../../../data/tntsearch/',
	'stemmer'   => \TeamTNT\TNTSearch\Stemmer\PorterStemmer::class//optional
]);
echo 'Creating and Running Indexing';
$indexer = $tnt->createIndex('movie.index');
$indexer->steps = 1000;
$indexer->query('select id, title, year from movie_titles;');
$indexer->run();
echo '  done'.PHP_EOL;
