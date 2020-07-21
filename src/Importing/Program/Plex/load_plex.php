<?php
require_once __DIR__.'/inc.php';
	
$db = new SQLite3('/var/lib/plexmediaserver/Library/Application Support/Plex Media Server/Plug-in Support/Databases/com.plexapp.plugins.library.db');
$results = $db->query('select file, guid, title, original_title, metadata_items.year from media_items, media_parts, metadata_items where media_items.id=media_parts.media_item_id and media_items.metadata_item_id=metadata_items.id and guid not like "collection:%"');
$files = [];
while ($row = $results->fetchArray()) {
	unset($row[4]);
	unset($row[3]);
	unset($row[2]);
	unset($row[1]);
	unset($row[0]);
	foreach ($row as &$arr)
		$arr = utf8_encode($arr);
	if (preg_match('/com\.plexapp\.agents\.themoviedb:\/\/(\d+)\?lang=en$/', $row['guid'], $matches)) {
		$row['tmdb_id'] = (int)$matches[1];
		unset($row['guid']);
	}
	$row['year'] = (int)$row['year'];
	$file = $row['file'];
	unset($row['file']);
	if (trim($row['original_title']) == '') {
		unset($row['original_title']);
	} 
	$files[$file] = $row;
	echo '.';
}
echo PHP_EOL;
ksort($files);
putJson('plex', $files);
