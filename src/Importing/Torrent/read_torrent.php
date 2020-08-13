<?php
require_once 'Torrent.php';

$file = 'C6C1417AD4C60B6532ECA4ED1377C51C78E4B90B';
$torrent = new Torrent('/storage/local/ConSolo/data/torrent/'.$file);
//echo 'private: ', $torrent->is_private() ? 'yes' : 'no'.PHP_EOL;
//echo 'annonce: '.print_r($torrent->announce(),true).PHP_EOL;
echo 'name: ', $torrent->name().PHP_EOL; 
//echo 'comment: ', $torrent->comment().PHP_EOL; 
//echo 'piece_length: ', $torrent->piece_length().PHP_EOL; 
//echo 'size: ', $torrent->size( 2 ).PHP_EOL;
//echo 'hash info: ', $torrent->hash_info().PHP_EOL;
echo 'content: ';
var_dump( $torrent->content() );
//echo 'source: '.$torrent.PHP_EOL;
//echo 'stats: ';
//var_dump( $torrent->scrape() );
//echo PHP_EOL;
//	$torrents[$id] = $torrent->content();
//	echo $count.PHP_EOL;
