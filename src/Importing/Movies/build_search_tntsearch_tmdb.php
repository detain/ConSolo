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
echo 'Creating and Running TMDB Indexing';
$indexer = $tnt->createIndex('tmdb.index');
$indexer->query('select id, title, release_date from tmdb_movie;');
//$indexer->setLanguage('german');
//$indexer->setPrimaryKey('article_id'); // if your primary key is different than id
//$indexer->includePrimaryKey(); // make the primary key searchable
$indexer->run();
echo '  done'.PHP_EOL;
