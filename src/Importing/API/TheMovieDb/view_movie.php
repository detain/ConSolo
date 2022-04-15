<?php
require_once __DIR__.'/../../../bootstrap.php';
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
/**
* @var \Twig\Environment
*/
global $twig;
global $config, $curl_config;
if (!file_exists(__DIR__.'/static'))
	mkdir(__DIR__.'/static', 0777, true);
$movieFiles = [];
echo "Loading Files with TMDB IDs...";
$rows = $db->query("select id, tmdb_id from files where tmdb_id is not null");
foreach ($rows as $row) {
	if (!array_key_exists($row['tmdb_id'], $movieFiles))
		$movieFiles[$row['tmdb_id']] = [];
	$movieFiles[$row['tmdb_id']][] = $row['id'];
}
echo "Mapped ".count($rows)." to ".count($movieFiles)." movies\n";
$movieCount = $db->single("select count(id) from tmdb_movie");
$pctCount = floor($movieCount / 100);
$pctDone = 0;
echo "Found {$movieCount} TMDB Movies\n";
$limit = 1000;
$offset = 0;
$end = false;
$out = [];
while ($end == false) {
	$rows = $db->query("select * from tmdb_movie order by id asc limit {$offset}, {$limit}");
	$rowCount = count($rows);
	echo ' ['.$offset.'-'.($offset + $rowCount - 1).']';
	$curPct = floor($offset / $pctCount);
	if ($curPct > $pctDone) {
		$pctDone = $curPct;
		echo ' '.$pctDone.'% '.floor(memory_get_usage() / (1024*1024)).'MB'; 
	}
	$offset += $rowCount;
	if ($rowCount < $limit)
		$end = true;
	foreach ($rows as $row) {
		$fileId = null;
		if (array_key_exists($row['id'], $movieFiles)) {
			$row['files'] = $movieFiles[$row['id']];
			$fileId = $row['files'][0]; 
		}
		$row['doc'] = json_decode($row['doc'], true);
		$row['year'] = (!isset($row['year']) || is_null($row['year']) || trim($row['year']) == '') ? '0' : $row['year'];
		$row['title'] = (!isset($row['title']) || is_null($row['title']) || trim($row['title']) == '') ? $row['original_title'] : $row['title'];
		$row['original_language'] = (!isset($row['original_language']) || is_null($row['original_language']) || trim($row['original_language']) == '') ? 'unknown' : $row['original_language'];
		if (!file_exists(__DIR__.'/static/'.$row['year']))
			mkdir(__DIR__.'/static/'.$row['year'], 0777, true);
		$slugTitle = str_replace('/', '-', $row['title']);
		$html = $twig->render('movie.twig', [
			'movie' => $row,
			'fileId' => $fileId,
		]); 
		file_put_contents(__DIR__.'/static/'.$row['year'].'/'.$slugTitle.'.html', $html);
		/*if (!array_key_exists($row['year'], $out))
			$out[$row['year']] = [];
		if (!array_key_exists($row['title'], $out[$row['year']]))
			$out[$row['year']][$row['title']] = [];
		$out[$row['year']][$row['title']][] = gzcompress(json_encode($row));*/
		//echo $row['title'].' '.$row['year'].PHP_EOL; 
	}
}
/*
exit;
echo " finished loading movies from db\n";
echo "writing static pages ";
foreach ($out as $year => $yearTitles) {
	if (!file_exists(__DIR__.'/static/'.$year))
		mkdir(__DIR__.'/static/'.$year, 0777, true);
	echo ' '.$year; 
	foreach ($yearTitles as $title => $rows) {
		if (count($rows) > 1) {
			echo 'Multiple rows for '.$year.' '.$title.PHP_EOL;
		}
		$rows[0]['doc'] = json_decode($rows[0]['doc'], true);
		$slugTitle = str_replace('/', '-', $title);
		$html = $twig->render('movie.twig', [
			'movie' => $rows[0],
			'fileId' => array_key_exists('files', $rows) ? $rows['files'][0] : null,
		]); 
		file_put_contents(__DIR__.'/static/'.$year.'/'.$slugTitle.'.html', $html);
	}
}
*/
echo ' done.'.PHP_EOL;