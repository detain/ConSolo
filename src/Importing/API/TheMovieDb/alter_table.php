<?php
/**
* Calculates the fields used and various usage information about them for each of the main fields in the JSON
* documents of the doc field in some of the tables.  calculates how much each field is used, what variable
* types are used by the field, and the max length of each field.   It will then offer alter table suggestions
* based on the data it fineds
*/
require_once __DIR__.'/../../../bootstrap.php';
$imdbFields = ['alsoknow','cast','colors','comment','composer','country','crazy_credits','director','episodes','genre','genres','get_episode_details','goofs','imdbsite','is_serial','keywords','languages','locations','main_url','movietype','mpaa','mpaa_reason','orig_title','photo_localurl','plot','plotoutline','producer','quotes','rating','runtime','seasons','sound','soundtrack','tagline','taglines','title','trailers','trivia','votes','writing','year'];
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $config, $curl_config;
$suffixes = ['collection','keyword','production_company','tv_episodes','tv_network','tv_seasons','tv_series','movie','person'];
$fields = [];
$limit = 100000;
$emptyKey = [
	'maxLength' => 0,
	'count' => 0,
	'types' => [],
];
echo sprintf("%20s  %15s  %7s %7s  %s\n", 'Table', 'Key', 'Max Len', 'Count', 'Types');
echo '---------------------------------------------------------------------'.PHP_EOL;
foreach($suffixes as $suffix) {
	$fields[$suffix] = [];
	$offset = 0;
	$table = 'tmdb_'.$suffix;
	while ($docs = $db->column('select doc from '.$table.' limit '.$offset.', '.$limit)) {
		//echo 'Loaded '.$table.' Offset '.$offset.PHP_EOL;
		foreach ($docs as $doc) {
			$doc = json_decode($doc, true);
			$keys = array_keys($doc);
			foreach ($keys as $docKey) {
				$key = array_key_exists($docKey, $fields[$suffix]) ? $fields[$suffix][$docKey] : $emptyKey;
				$key['count']++;
				if (is_array($doc[$docKey]))
					$type = 'array';
				elseif (is_object($doc[$docKey]))
					$type = 'object';
				elseif (is_null($doc[$docKey]))
					$type = 'null';
				elseif (is_bool($doc[$docKey]))
					$type = 'bool';
				elseif (is_float($doc[$docKey]))
					$type = 'float';
				elseif (is_numeric($doc[$docKey]) && $doc[$docKey] == (int)$doc[$docKey])
					$type = 'int';
				else
					$type = 'string';
				if (!in_array($type, $key['types']))
					$key['types'][] = $type;
				if ($type != 'null' && $type != 'array' && mb_strlen($doc[$docKey]) > $key['maxLength'])
					$key['maxLength'] = mb_strlen($doc[$docKey]);
				$fields[$suffix][$docKey] = $key;
			}
		}
		$offset += $limit;
	}
	foreach ($fields[$suffix] as $key => $data) {
		echo sprintf("%20s  %15s  %7d %7d  %s\n", $suffix, $key, $data['maxLength'], $data['count'], implode(',', $data['types']));
	}
}
