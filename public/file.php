<?php
require_once __DIR__.'/../src/bootstrap.php';

function smartReadFile($location, $filename, $mimeType='application/octet-stream') { 
	if (!file_exists($location)) { 
		header ("HTTP/1.0 404 Not Found");
		return;
	}
	$size = filesize($location);
	$time = date('r', filemtime($location));
	$fm = @fopen($location,'rb');
	if (!$fm) {
		header ("HTTP/1.0 505 Internal server error");
		return;
	}
	$begin = 0;
	$end = $size;
	if (isset($_SERVER['HTTP_RANGE'])) {
		if (preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $_SERVER['HTTP_RANGE'], $matches)) {
			$begin = intval($matches[1]);
			if (!empty($matches[2]))
				$end = intval($matches[2]);
		}
	}
	if ($begin > 0 || $end < $size)
		header('HTTP/1.0 206 Partial Content');
	else
		header('HTTP/1.0 200 OK');
	header("Content-Type: $mimeType");
	header('Cache-Control: public, must-revalidate, max-age=0');
	header('Pragma: no-cache'); 
	header('Accept-Ranges: bytes');
	header('Content-Length:'.($end-$begin));
	header("Content-Range: bytes $begin-$end/$size");
	header("Content-Disposition: inline; filename=$filename");
	header("Content-Transfer-Encoding: binary\n");
	header("Last-Modified: $time");
	header('Connection: close');
	$cur = $begin;
	fseek($fm, $begin, 0);
	while (!feof($fm) && $cur < $end && (connection_status() == 0)) {
		print fread($fm, min(1024 * 16, $end - $cur));
		$cur += 1024 * 16;
	}
}


/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $config, $curl_config;
if (!isset($_GET['id'])) {
	header ("HTTP/1.0 404 Not Found");
	exit;
}
$id = (int)$_REQUEST['id'];
$data = $db->row("select * from files left join files_extra using (id) where id={$id}");
if ($data === false) {
	header ("HTTP/1.0 404 Not Found");
	exit;
}
smartReadFile($data['path'], basename($data['path']), mime_content_type($data['path']));
