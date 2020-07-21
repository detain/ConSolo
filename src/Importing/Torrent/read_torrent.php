<?php
require_once 'Torrent.php';

$torrents = [];
$count = 0;
foreach (glob('t/*') as $file) {
	$count++;
	$id = basename($file);
	$torrent = new Torrent($file);
	$torrents[$id] = $torrent->content();
	echo $count.PHP_EOL;
}
file_put_contents('torrentfiles.json', json_encode($torrents, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

