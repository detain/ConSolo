<?php

ini_set('display_errors', 'on');
if (ini_get('date.timezone') == '') {
	ini_set('date.timezone', 'America/New_York');
}
if (ini_get('default_socket_timeout') < 1200 && ini_get('default_socket_timeout') > 1) {
	ini_set('default_socket_timeout', 1200);
}
include __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/xml2array.php';
global $config;
$config = require __DIR__.'/config.php';
include_once __DIR__.'/stdObject.php';

/**
 * determines if the OS is windows
 *
 * @return bool true if windows
 */
function isWindows() {
	return (DIRECTORY_SEPARATOR == '\\');
}

/**
 * converts both windows and unix paths to the / format which works universally
 *
 * @param string $path the path to convert
 * @return string the path converted
 */
function normalizePath($path) {
	if (DIRECTORY_SEPARATOR == '/') {
		return $path;
	}
	$path = str_replace( '\\', '/', $path );
	$path = preg_replace( '|(?<=.)/+|', '/', $path );
	if ( ':' === substr( $path, 1, 1 ) ) {
		$path = ucfirst( $path );
	}
	return $path;
}

/**
 * gets a webpage via curl and returns the response.
 * @param string $url        the url of the page you want
 * @param string $postfields postfields in the format of "v1=10&v2=20&v3=30"
 * @param string $options
 * @return string the webpage
 */
function getcurlpage($url, $postfields = '', $options = '')
{
	$agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2790.0 Safari/537.36';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	if (is_array($postfields) || $postfields != '') {
		if (is_array($postfields)) {
			$postdata = [];
			foreach ($postfields as $field => $value)
				$postdata[] = $field.'='.urlencode($value);
			curl_setopt($ch, CURLOPT_POSTFIELDS, implode('&', $postdata));
		} else {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		}
	}
	if (is_array($options) && count($options) > 0)
		foreach ($options as $key => $value)
			curl_setopt($ch, $key, $value);
	$tmp = curl_exec($ch);
	curl_close($ch);
	$ret = $tmp;
	return $ret;
}

function filenameJson($tag) {
	return 'data/'.$tag.'.json';
}

function loadJson($tag) {
	$result = file_exists(filenameJson($tag)) ? json_decode(file_get_contents(filenameJson($tag)), true) : [];
	echo '['.$tag.'] loaded data file and parsed '.count($result).' details'.PHP_EOL;
	return $result;
}

function putJson($tag, $data) {
	file_put_contents(filenameJson($tag), json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
	echo '['.$tag.'] wrote '.count($data).' records to data file'.PHP_EOL;
}

function loadTmdbMovie($id) {
	global $config;
	$apiKey = $config['thetvdb_api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/movie/'.$id.'?api_key='.$apiKey.'&language=en-US'), true);
}

function changedTmdbMovies($start_date, $end_date, $results) {
	global $config;
	$apiKey = $config['thetvdb_api_key'];
	$finished = false;
	$page = 1;
	while ($finished == false) {
		echo 'Getting Movie Changes from '.$start_date.' to '.$end_date.' page '.$page.PHP_EOL;
		$response = json_decode(getcurlpage('https://api.themoviedb.org/3/movie/changes?api_key='.$apiKey.'&start_date='.$start_date.'&end_date='.$end_date.'&page='.$page), true);
		foreach ($response['results'] as $data) {
			$results[] = $data['id'];
		}
		if ($response['total_pages'] <= $page) {
			$finished = true;
		} else {
			$page++;
		}
	}
	return $results;
}

function lookupTmdbMovie($search) {
	global $config;
	$apiKey = $config['thetvdb_api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/search/movie?api_key='.$apiKey.'&query='.urlencode($search)), true);
}

function cleanPath($path) {
	global $driveReplacements, $Windows;
	foreach ($driveReplacements['search'] as $idx => $search) {
		$replace = $driveReplacements['replace'][$idx];
		$path = preg_replace($search, $replace, $path); 
	}
	return $path;
}

global $db;
$db = new \Workerman\MySQL\Connection($config['db_host'], $config['db_port'], $config['db_name'], $config['db_user'], $config['db_pass']);

global $twig;
$twigloader = new \Twig\Loader\FilesystemLoader(__DIR__.'/Views');
$twig = new \Twig\Environment($twigloader, array('/tmp/twig_cache'));
global $driveReplacements, $Windows;
$driveReplacements = ['search' => [], 'replace' => []];
if (DIRECTORY_SEPARATOR == '\\') {
	$Windows = true;
	$driveReplacements['search'][] = '|\\\\|';
	$driveReplacements['replace'][] = '/';
	$driveReplacements['search'][] = '|(?<=.)/+|';
	$driveReplacements['replace'][] = '/';
} else {
	$os = trim(`uname -o`);
	if ($os == 'Msys') {
		// MingW Linux in Windows
		$Windows = true;
		$DrivePattern = '/#';
	} elseif ($os == 'Cygwin') {
		// Cygwin Linux in Windows
		$Windows = true;
		$DrivePattern = '/cygwin/#';
	} elseif (file_exists('/usr/bin/wslvar') && trim(`wslvar -s OS`) == 'Windows_NT') {
		// WSL Linux in Windows
		$Windows = true;
		$DrivePattern = '/mnt/#';
	} else {
		// Linux
		$Windows = false;
	}
	if ($Windows == true) {
		$drives = explode(PHP_EOL, trim(`mount|grep '^[A-Z]:\\\\* on'|cut -d: -f1`));
		foreach ($drives as $drive) {
			$driveReplacements['search'][] = '|^'.str_replace('#', $drive, $DrivePattern).'/|i';
			$driveReplacements['replace'][] = strtoupper($drive).':/';
		}
	}
}

global $hostId, $hostData;
$hostname = gethostname();
$hostData = $db->query("select * from hosts where name='{$hostname}'");
$hostData = count($hostData) == 0 ? ['id' => null, 'name' => $hostname] : $hostData[0];
$hostId = $hostData['id'];
