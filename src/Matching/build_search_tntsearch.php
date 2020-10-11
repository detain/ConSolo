<?php
/**
* @link https://github.com/loilo/Fuse 
*/

use TeamTNT\TNTSearch\TNTSearch;

require_once __DIR__.'/../bootstrap.php';

global $config;
$tnt = new TNTSearch;
$tnt->loadConfig([
	'driver'    => 'mysql',
	'host'      => $config['db']['host'],
	'database'  => $config['db']['name'],
	'username'  => $config['db']['user'],
	'password'  => $config['db']['pass'],
	'storage'   => __DIR__.'/../../data/tntsearch/',
	'stemmer'   => \TeamTNT\TNTSearch\Stemmer\PorterStemmer::class//optional
]);
echo 'Creating and Running Indexing';
$indexer = $tnt->createIndex('ocplatforms.index');
$indexer->query('select id, name, manufacturer from oc_platforms;');
$indexer->run();
echo '  done'.PHP_EOL;
