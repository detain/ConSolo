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
 * converts the arguments to a list of fields and values , for use with the make_insert_query() function
 *
 * @param mixed $args associated array of arguments in the format of  field => value
 * @return false|array false if no arguments, or an array with the first element being an array of fields, the next being an array of values.
 */
function get_insert_query_fields_values($args)
{
	global $mysqlLinkId;
	if (count($args) > 0) {
		$query_values = [];
		$query_fields = [];
		foreach ($args as $key => $value) {
			$query_fields[] = '`'.$key.'`';
			if (null === $value) {
				$query_values[] = 'NULL';
			} elseif (is_bool($value)) {
				if ($value == true) {
					$query_values[] = 'true';
				} else {
					$query_values[] = 'false';
				}
			} elseif (is_int($value)) {
				$query_values[] = $value;
			} elseif (is_array($value)) {
				$query_values[] = $value[0];
			} else {
				$query_values[] = "'" . $mysqlLinkId->real_escape_string($value) . "'";
			}
		}
		return [$query_fields, $query_values];
	}
	return false;
}

/**
 * builds an SQL Insert Query with the given parameters.
 * it should properly handle different variable types.
 *
 * to pass a string as a direct mysql call and avoid it being escaped or put in quotes,
 * pass the element in an array
 *
 * <code>
 *
 *    echo make_insert_query('invoices', array(
 *        'invoices_id' => NULL,
 *        'invoices_description' => $service_types[$ssl]['services_name'],
 *        'invoices_amount' => $ssl_cost,
 *        'invoices_custid' => $custid,
 *        'invoices_type' => 1,
 *        'invoices_date' => mysql_now(),
 *        'invoices_group' => 0,
 *        'invoices_extra' => 0,
 *        'invoices_paid' => 0,
 *        'invoices_module' => 'ssl',
 *        'invoices_due_date' => mysql_date_add(null, $settings['SUSPEND_DAYS'].' day')
 *  ));
 *
 * </code>
 *
 * Example Output:
 *    insert into invoices (`invoices_id`, `invoices_description`, `invoices_amount`, `invoices_custid`, `invoices_type`, `invoices_date`, `invoices_group`, `invoices_extra`, `invoices_paid`, `invoices_module`, `invoices_due_date`) values (NULL, '(Repeat Invoice: 2500101) .ws Domain Name Registration', '23.00', '4579', 1, '12:01:01 01:12:33', 0, 2500101, 0, 'domains', '12:12:01 01:12:33')
 *
 * @param string           $table          the table name to insert the values into
 * @param array            $args           associated array of arguments in the format of  field => value
 * @param array|bool|false $duplicate_args if specified, the query will add an ON DUPLICATE KEY text, these are the fields to update on duplicate, if not specified it does not add this part to the query.
 * @return string the SQL insert string
 */
function make_insert_query($table, $args, $duplicate_args = false)
{
	if (count($args) > 0) {
		list($query_fields, $query_values) = get_insert_query_fields_values($args);
		$query = "insert into {$table} (" . implode(', ', $query_fields).') values ('.implode(', ', $query_values).')';
		if (is_array($duplicate_args)) {
			list($duplicate_query_fields, $duplicate_query_values) = get_insert_query_fields_values($duplicate_args);
			$duplicate_fields = [];
			foreach ($duplicate_query_fields as $idx => $field) {
				$duplicate_fields[] = $field.'='.$duplicate_query_values[$idx];
			}
			if (count($duplicate_fields) > 0) {
				$query .= ' on duplicate key update '.implode(', ', $duplicate_fields);
			}
		}
		//myadmin_log('myadmin', 'debug', $query, __LINE__, __FILE__);
		return $query;
	} else {
		return '';
	}
}

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

function loadTmdbMovieGenres() {
	global $config;
	$apiKey = $config['thetvdb_api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/genre/movie/list?api_key='.$apiKey.'&language=en-US'), true);
}

function loadTmdbTVGenres() {
	global $config;
	$apiKey = $config['thetvdb_api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/genre/tv/list?api_key='.$apiKey.'&language=en-US'), true);
}

function loadTmdbCollection($id) {
	global $config;
	$apiKey = $config['thetvdb_api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/collection/'.$id.'?api_key='.$apiKey.'&language=en-US'), true);
}

function loadTmdbConfiguration($id) {
	global $config;
	$apiKey = $config['thetvdb_api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/configuration?api_key='.$apiKey), true);
}

function loadTmdbMovie($id) {
	global $config;
	$apiKey = $config['thetvdb_api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/movie/'.$id.'?api_key='.$apiKey.'&language=en-US&append_to_response=account_states,alternative_titles,credits,external_ids,images,keywords,release_dates,videos,translations,recommendations,similar,reviews,lists'), true);
}

function loadTmdbTV($id) {
	global $config;
	$apiKey = $config['thetvdb_api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/tv/'.$id.'?api_key='.$apiKey.'&language=en-US&append_to_response=account_states,alternative_titles,content_ratings,credits,episode_groups,external_ids,images,keywords,recommendations,reviews,screened_theatrically,similar,translations,videos'), true);
}

function loadTmdbTVSeason($id, $season) {
	global $config;
	$apiKey = $config['thetvdb_api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/tv/'.$id.'/season/'.$season.'?api_key='.$apiKey.'&language=en-US&append_to_response=account_states,credits,external_ids,images,videos'), true);
}

function loadTmdbTVEpisode($id, $season, $episode) {
	global $config;
	$apiKey = $config['thetvdb_api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/tv/'.$id.'/season/'.$season.'/episode/'.$episode.'?api_key='.$apiKey.'&language=en-US&append_to_response=account_states,credits,external_ids,images,translations'), true);
}

function loadTmdbPerson($id) {
	global $config;
	$apiKey = $config['thetvdb_api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/person/'.$id.'?api_key='.$apiKey.'&language=en-US&append_to_response=movie_credits,tv_credits,combined_credits,external_ids,images,tagged_images,translations'), true);
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

global $db, $mysqlLinkId;
$characterSet = 'utf8mb4';
$collation = 'utf8mb4_unicode_ci';
$db = new \Workerman\MySQL\Connection($config['db_host'], $config['db_port'], $config['db_name'], $config['db_user'], $config['db_pass']);
$mysqlLinkId = mysqli_init();
$mysqlLinkId->options(MYSQLI_INIT_COMMAND, "SET NAMES {$characterSet} COLLATE {$collation}, COLLATION_CONNECTION = {$collation}, COLLATION_DATABASE = {$collation}");
if (isset($config['db_port']) && $config['db_port'] != '')
	$mysqlLinkId->real_connect($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name'], $config['db_port']);
else
	$mysqlLinkId->real_connect($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
$mysqlLinkId->set_charset($characterSet);


global $twig;
$twigloader = new \Twig\Loader\FilesystemLoader(__DIR__.'/Views');
$twig = new \Twig\Environment($twigloader, array('/tmp/twig_cache'));
global $driveReplacements, $Windows, $Linux;
$driveReplacements = ['search' => [], 'replace' => []];
if (DIRECTORY_SEPARATOR == '\\') {
	$Windows = true;
	$Linux = false;
	$driveReplacements['search'][] = '|\\\\|';
	$driveReplacements['replace'][] = '/';
	$driveReplacements['search'][] = '|(?<=.)/+|';
	$driveReplacements['replace'][] = '/';
}
if (file_exists('/usr/bin/uname') || file_exists('/usr/bin/uname.exe') || file_exists('/bin/uname') || file_exists('/bin/uname.exe')) {
	$Linux = true;
	$os = trim(`uname -o`);
	if ($os == 'Msys') {
		// MingW Linux in Windows
		//echo 'MinGW Linux Detected'.PHP_EOL;
		$Windows = true;
		$DrivePattern = '/#';
	} elseif ($os == 'Cygwin') {
		// Cygwin Linux in Windows
		//echo 'Cygwin Linux Detected'.PHP_EOL;
		$Windows = true;
		$DrivePattern = '/cygwin/#';
	} elseif (file_exists('/usr/bin/wslvar') && trim(`wslvar -s OS`) == 'Windows_NT') {
		// WSL Linux in Windows
		//echo 'WSL Linux Detected'.PHP_EOL;
		$Windows = true;
		$DrivePattern = '/mnt/#';
	} else {
		//echo 'Linux OS Detected'.PHP_EOL;
		// Linux
		$Windows = false;
	}
	if ($Windows == true) {
		//echo 'Windows OS Detected'.PHP_EOL;
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
