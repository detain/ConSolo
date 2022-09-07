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

function getJsonOpts() {
    return JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE |  JSON_UNESCAPED_SLASHES;
}

function stripMameName($name) {
    if (!isset($GLOBALS['mameMediaTypes'])) {
        $GLOBALS['mameMediaTypes'] = json_decode(file_get_contents(__DIR__.'/Matching/mame_media_types.json'), true);
    }
    foreach ($GLOBALS['mameMediaTypes'] as $type) {
        $name = preg_replace('/\s*'.preg_quote($type, '/').'$/i', '', $name);
    }
    return $name;
}


/**
 * @param $string
 * @return mixed|string
 */
function slugify($string)
{
		$string = utf8_encode($string);
		$string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
		$string = preg_replace('/[^a-z0-9- ]/i', '', $string);
		$string = str_replace(' ', '-', $string);
		$string = trim($string, '-');
		$string = strtolower($string);
		if (empty($string)) {
				return 'n-a';
		}
		return $string;
}


function FlattenAttr(&$parent) {
	if (isset($parent['attr'])) {
		if (count($parent['attr']) == 2 && isset($parent['attr']['name']) && isset($parent['attr']['value'])) {
			$parent[$parent['attr']['name']] = $parent['attr']['value'];
			unset($parent['attr']);
		} else {
			foreach ($parent['attr'] as $attrKey => $attrValue) {
				$parent[$attrKey] = $attrValue;
			}
			unset($parent['attr']);
		}
	}
}

function FlattenValues(&$parent) {
	foreach ($parent as $key => $value) {
		if (is_array($value) && count($value) == 1 && isset($value['value'])) {
			$parent[$key] = $value['value'];
		}
	}
}

function RunArray(&$data) {
	if (is_array($data)) {
		if (count($data) > 0) {
			if (isset($data[0])) {
				foreach ($data as $dataIdx => $dataValue) {
					RunArray($dataValue);
					$data[$dataIdx] = $dataValue;
				}
			} else {
				FlattenAttr($data);
				FlattenValues($data);
				foreach ($data as $dataIdx => $dataValue) {
					RunArray($dataValue);
					$data[$dataIdx] = $dataValue;
				}
			}
		}
	}
}

function cleanUtf8($text) {
	$text = preg_replace('/[\x00-\x08\x10\x0B\x0C\x0E-\x19\x7F]'.
	'|(?<=^|[\x00-\x7F])[\x80-\xBF]+'.
	'|([\xC0\xC1]|[\xF0-\xFF])[\x80-\xBF]*'.
	'|[\xC2-\xDF]((?![\x80-\xBF])|[\x80-\xBF]{2,})'.
	'|[\xE0-\xEF](([\x80-\xBF](?![\x80-\xBF]))|(?![\x80-\xBF]{2})|[\x80-\xBF]{3,})/',
	'ï¿½', $text);
	$text = preg_replace('/\xE0[\x80-\x9F][\x80-\xBF]'.
	'|\xED[\xA0-\xBF][\x80-\xBF]/S','?', $text);
	return $text;
}

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
* returns whether or not the given extension is one of the ones mediainfo supports
*
* @param string $ext the file extension
* @return bool
*/
function isMediainfo($ext) {
	$validExt = ['aac','ac3','aifc','aiff','ape','asf','asp','ass','au','avi','avr','divx','dts','flac','idx','iff','ifo','irca',
		'm1v','m2v','m4a','m4v','mac','mat','mka','mks','mkv','mov','mp2','mp3','mp4','mpeg','mpg','mpgv','mpv','ogg','ogm',
		'paf','pvf','qt','rm','rmvb','rv','sami','sd2','smi','srm','srt','srt2utf-8','ssa','sub','sup','vob',
		'w64','wav','wma','wmv','xds','xi','xvid'];
	return in_array(strtolower($ext), $validExt);
}

/**
* returns whether or not the given extension is one of the ones exifinfo supports
*
* @param string $ext the file extension
* @return bool
*/
function isExifinfo($ext) {
	//$validExt = explode(' ', trim(`exiftool -listf|grep -v :|cut -c3-|tr "\n" " "|tr "\[A-Z\]" "\[a-z\]"`));
	$validExt = ['3fr','3g2','3gp','3gp2','3gpp','a','aa','aae','aax','acfm','acr','afm','ai','aif','aifc','aiff','ait','amfm',
		'ape','arq','arw','asf','avi','avif','azw','azw3','bmp','bpg','btf','chm','ciff','cos','cr2','cr3','crw','cs1','csv',
		'dc3','dcm','dcp','dcr','dfont','dib','dic','dicm','divx','djv','djvu','dll','dng','doc','docm','docx','dot','dotm',
		'dotx','dpx','dr4','dv','dvb','dvr-ms','dylib','eip','eps','epsf','epub','erf','exe','exif','exr','exv','f4a','f4b',
		'f4p','f4v','fff','fla','flac','flif','flv','fpf','fpx','gif','gpr','gz','gzip','hdp','hdr','heic','heif','hif',
		'htm','html','ical','icc','icm','ics','idml','iiq','ind','indd','indt','insv','inx','iso','itc','j2c','j2k','jng',
		'jp2','jpc','jpe','jpeg','jpf','jpg','jpm','jpx','json','jxr','k25','kdc','key','kth','la','lfp','lfr','lnk','lrv',
		'm2t','m2ts','m2v','m4a','m4b','m4p','m4v','max','mef','mie','mif','miff','mka','mks','mkv','mng','mobi','modd','moi',
		'mos','mov','mp3','mp4','mpc','mpeg','mpg','mpo','mqv','mrw','mts','mxf','nef','nmbtemplate','nrw','numbers','o',
		'odb','odc','odf','odg','ofr','ogg','ogv','opus','orf','otf','pac','pages','pbm','pcd','pct','pcx','pdb','pdf','pef',
		'pfa','pfb','pfm','pgf','pgm','pict','plist','pmp','png','pot','potm','potx','ppam','ppax','ppm','pps','ppsm','ppsx',
		'ppt','pptm','pptx','prc','ps','psb','psd','psdt','psp','pspimage','qif','qt','qti','qtif','r3d','ra','raf','ram',
		'raw','rif','riff','rm','rmvb','rpm','rsrc','rtf','rv','rw2','rwl','rwz','seq','sketch','so','sr2','srf','srw',
		'svg','swf','thm','thmx','tif','tiff','torrent','ts','ttc','ttf','txt','vcard','vcf','vob','vrd','vsd','wav','wdp',
		'webm','webp','wma','wmv','wtv','wv','x3f','xcf','xhtml','xls','xlsb','xlsm','xlsx','xlt','xltm','xltx','xmp','yes'];
	return in_array(strtolower($ext), $validExt);
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
 * getcurlpage()
 * gets a webpage via curl and returns the response.
 * also it sets a mozilla type agent.
 * @param string $url        the url of the page you want
 * @param string $postfields postfields in the format of "v1=10&v2=20&v3=30"
 * @param string $options
 * @return string the webpage
 */
function getcurlpage($url, $postfields = '', $options = '')
{
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2790.0 Safari/537.36');
	if (is_array($postfields) || $postfields != '') {
		if (is_array($postfields)) {
			$postdata = [];
			foreach ($postfields as $field => $value) {
				$postdata[] = $field.'='.urlencode($value);
			}
			curl_setopt($ch, CURLOPT_POSTFIELDS, implode('&', $postdata));
		} else {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		}
	}
	if (is_array($options) && count($options) > 0) {
		foreach ($options as $key => $value) {
			curl_setopt($ch, $key, $value);
		}
	}
	$tmp = curl_exec($ch);
	$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$GLOBALS['curl_http_code'] = (int)$status;
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
	file_put_contents(filenameJson($tag), json_encode($data, getJsonOpts()));
	echo '['.$tag.'] wrote '.count($data).' records to data file'.PHP_EOL;
}

function loadTmdbMovieGenres() {
	global $config, $curl_config;
	$apiKey = $config['tmdb']['api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/genre/movie/list?api_key='.$apiKey.'&language=en-US', '', $curl_config), true);
}

function loadTmdbTVGenres() {
	global $config, $curl_config;
	$apiKey = $config['tmdb']['api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/genre/tv/list?api_key='.$apiKey.'&language=en-US', '', $curl_config), true);
}

function loadTmdbCollection($id) {
	global $config, $curl_config;
	$apiKey = $config['tmdb']['api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/collection/'.$id.'?api_key='.$apiKey.'&language=en-US', '', $curl_config), true);
}

function loadTmdbTvNetwork($id) {
	global $config, $curl_config;
	$apiKey = $config['tmdb']['api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/network/'.$id.'?api_key='.$apiKey.'&language=en-US', '', $curl_config), true);
}

function loadTmdbKeyword($id) {
	global $config, $curl_config;
	$apiKey = $config['tmdb']['api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/keyword/'.$id.'?api_key='.$apiKey, '', $curl_config), true);
}

function loadTmdbProductionCompany($id) {
	global $config, $curl_config;
	$apiKey = $config['tmdb']['api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/company/'.$id.'?api_key='.$apiKey, '', $curl_config), true);
}

function loadTmdbConfiguration() {
	global $config, $curl_config;
	$apiKey = $config['tmdb']['api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/configuration?api_key='.$apiKey, '', $curl_config), true);
}

function loadTmdbMovie($id) {
	global $config, $curl_config;
	$apiKey = $config['tmdb']['api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/movie/'.$id.'?api_key='.$apiKey.'&language=en-US&append_to_response=account_states,alternative_titles,credits,external_ids,images,keywords,release_dates,videos,translations,recommendations,similar,reviews,lists', '', $curl_config), true);
}

function loadTmdbTvSeries($id) {
	global $config, $curl_config;
	$apiKey = $config['tmdb']['api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/tv/'.$id.'?api_key='.$apiKey.'&language=en-US&append_to_response=account_states,alternative_titles,content_ratings,credits,episode_groups,external_ids,images,keywords,recommendations,reviews,screened_theatrically,similar,translations,videos', '', $curl_config), true);
}

function loadTmdbTvSeason($id, $season) {
	global $config, $curl_config;
	$apiKey = $config['tmdb']['api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/tv/'.$id.'/season/'.$season.'?api_key='.$apiKey.'&language=en-US&append_to_response=account_states,credits,external_ids,images,videos', '', $curl_config), true);
}

function loadTmdbTvEpisode($id, $season, $episode) {
	global $config, $curl_config;
	$apiKey = $config['tmdb']['api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/tv/'.$id.'/season/'.$season.'/episode/'.$episode.'?api_key='.$apiKey.'&language=en-US&append_to_response=account_states,credits,external_ids,images,translations', '', $curl_config), true);
}

function loadTmdbPerson($id) {
	global $config, $curl_config;
	$apiKey = $config['tmdb']['api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/person/'.$id.'?api_key='.$apiKey.'&language=en-US&append_to_response=movie_credits,tv_credits,combined_credits,external_ids,images,tagged_images,translations', '', $curl_config), true);
}

/**
* @param string $type can be movie, tv, or person
* @param string $start_date
* @param string $end_date
* @param array $results
* @return array
*/
function changedTmdb($type, $start_date, $end_date, $results) {
	global $config, $curl_config;
	$apiKey = $config['tmdb']['api_key'];
	$finished = false;
	$page = 1;
	while ($finished == false) {
		echo 'Getting '.$type.' Changes from '.$start_date.' to '.$end_date.' page '.$page.PHP_EOL;
		$response = json_decode(getcurlpage('https://api.themoviedb.org/3/'.$type.'/changes?api_key='.$apiKey.'&start_date='.$start_date.'&end_date='.$end_date.'&page='.$page, '', $curl_config), true);
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
	global $config, $curl_config;
	$apiKey = $config['tmdb']['api_key'];
	return json_decode(getcurlpage('https://api.themoviedb.org/3/search/movie?api_key='.$apiKey.'&query='.urlencode($search), '', $curl_config), true);
}

function cleanPath($path) {
	global $driveReplacements, $Windows;
	foreach ($driveReplacements['search'] as $idx => $search) {
		$replace = $driveReplacements['replace'][$idx];
		$path = preg_replace($search, $replace, $path);
	}
	return $path;
}

function loadRegularIni($fileName) {
    sanitizeEncoding($fileName);
    $ini = parse_ini_string($fileName, true, INI_SCANNER_RAW);
    return $ini;
}

function loadQuotedIni($fileName) {
    sanitizeEncoding($fileName);
    $ini = [];
    $fileStr = file_get_contents($fileName);
    preg_match_all('/^\[(?P<section>[^\]]+)\]$\n(?P<settings>(^[^\[].*$\n)*)/mu', $fileStr, $matches);
    foreach ($matches['section'] as $idx => $section) {
        $settings = $matches['settings'][$idx];
        $ini[$section]  = [];
        if (trim($settings) != '') {
            preg_match_all('/^(?P<field>\w+)\s*=\s*"(?P<value>.*)"$/msuU', $settings, $fieldMatches);
            foreach ($fieldMatches['field'] as $fieldIdx => $field) {
                $value = $fieldMatches['value'][$fieldIdx];
                $ini[$section][$field] = trim($value);
            }
        }
    }
    return $ini;
}

function loadIni($fileName) {
    sanitizeEncoding($fileName);
    $iniStr = file_get_contents($fileName);
    $iniArr = explode("\n", $iniStr);
    $ini = []; // to hold the categories, and within them the entries
    $last = '';
    foreach ($iniArr as $i) {
        if (@preg_match('/\[(.+)\]/', $i, $matches)) {
            $last = stripQuotes(trim($matches[1]));
        } elseif (@preg_match('/^([^;=][^=]+)=(.*)$/', $i, $matches)) {
            $key = stripQuotes(trim($matches[1]));
            if (strlen($key)>0) {
                $val=stripQuotes(trim($matches[2]));
                if (strlen($last) > 0) {
                    $ini[$last][$key] = trim($val);
                } else {
                    $ini[$key] = trim($val);
                }
            }
        }
    }
    return $ini;
}

function sanitizeEncoding($iniFile) {
    // check for  ISO or Non-ISO text and convert to utf8
    if (strpos(`file {$iniFile}`, 'ISO') !== false) {
        echo "Fixing {$iniFile} encoding\n";
        `iconv -f ISO-8859-14 -t UTF-8 {$iniFile} -o {$iniFile}_new || rm -fv {$iniFile}_new && mv -fv {$iniFile}_new {$iniFile}`;
    }
}

function stripQuotes($text) {
    return preg_replace('/^(\'(.*)\'|"(.*)")$/', '$2$3', $text);
}

function camelSnake($input) {
    preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
    $ret = $matches[0];
    foreach ($ret as &$match)
        $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
    return implode('_', $ret);
}

function gitClone($repo, $recursive = true) {
    $base = basename($repo, '.git');

    $return = passthru("git clone ".($recursive === true ? "--recursive " : "")."{$repo} {$base}");
    return $return == 0;
}

function gitUpdate($repo, $recursive = true) {
    $base = basename($repo, '.git');
    $return = passthru("cd {$base} && git pull --all");
    return $return == 0;
}

function gitSetup($repo, $recursive = true) {
    $base = basename($repo, '.git');
    return file_exists($base) ? gitUpdate($repo, $recursive) : gitClone($repo, $recursive);
}

global $db, $mysqlLinkId;
$characterSet = 'utf8mb4';
$collation = 'utf8mb4_unicode_ci';
try {
	$db = new \Workerman\MySQL\Connection($config['db']['host'], $config['db']['port'], $config['db']['name'], $config['db']['user'], $config['db']['pass']);
	$mysqlLinkId = mysqli_init();
	$mysqlLinkId->options(MYSQLI_INIT_COMMAND, "SET NAMES {$characterSet} COLLATE {$collation}, COLLATION_CONNECTION = {$collation}, COLLATION_DATABASE = {$collation}");
	if (isset($config['db']['port']) && $config['db']['port'] != '')
		$mysqlLinkId->real_connect($config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['name'], $config['db']['port']);
	else
		$mysqlLinkId->real_connect($config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['name']);
	$mysqlLinkId->set_charset($characterSet);
} catch (\PDOException $e) {
	echo 'Caught PDO Exception #'.$e->getCode().' '.$e->getMessage().PHP_EOL;
}


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
$hostData = [];
try {
	if (!is_null($db))
		$hostData = $db->query("select * from hosts where name='{$hostname}'");
} catch (\PDOException $e) {
	echo 'Caught PDO Exception #'.$e->getCode().' '.$e->getMessage().PHP_EOL;
}
$hostData = count($hostData) == 0 ? ['id' => null, 'name' => $hostname] : $hostData[0];
$hostId = $hostData['id'];
