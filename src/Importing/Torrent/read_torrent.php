<?php
require_once 'Torrent.php';

//$torrents = [];
//$count = 0;
//foreach (glob('t/*') as $file) {
//	$count++;
//	$id = basename($file);
$file = 'C6C1417AD4C60B6532ECA4ED1377C51C78E4B90B';
	$torrent = new Torrent($file);
print_r($torrent->content());
//	$torrents[$id] = $torrent->content();
//	echo $count.PHP_EOL;
//}
//file_put_contents('torrentfiles.json', json_encode($torrents, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

