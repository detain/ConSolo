<?php
/**
* Calculates the fields used and various usage information about them for each of the main fields in the JSON
* documents of the doc field in some of the tables.  calculates how much each field is used, what variable
* types are used by the field, and the max length of each field.   It will then offer alter table suggestions
* based on the data it fineds
*/
require_once __DIR__.'/../../../bootstrap.php';
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $config, $curl_config;
$suffixes = ['collection', 'keyword', 'production_company', 'tv_episodes', 'tv_network', 'tv_seasons', 'tv_series', 'movie', 'person'];
$fields = [];
$limit = 100000;
$emptyKey = [
	'maxLength' => 0,
	'count' => 0,
	'types' => [],
	'negative' => false,
	'null' => false,
];
foreach($suffixes as $suffix) {
	$fields[$suffix] = [];
	$offset = 0;
	$table = 'tmdb_'.$suffix;
	echo 'Working on '.$table.PHP_EOL;
	$keys = $db->query('show columns from '.$table);
	$columns = [];
	$lastBeforeUpdated = '';
	$foundUpdated = false;
	foreach ($keys as $column) {
		if ($foundUpdated === false && $column['Field'] != 'updated')
			$lastBeforeUpdated = $column['Field'];
		elseif ($column['Field'] == 'updated')
			$foundUpdated = true;
		$columns[] = $column['Field'];
	}
	while ($docs = $db->column('select doc from '.$table.' limit '.$offset.', '.$limit)) {
		//echo 'Loaded '.$table.' Offset '.$offset.PHP_EOL;
		foreach ($docs as $doc) {
			$doc = json_decode($doc, true);
			$keys = array_keys($doc);
			foreach ($keys as $docKey) {
				$key = array_key_exists($docKey, $fields[$suffix]) ? $fields[$suffix][$docKey] : $emptyKey;
				$key['count']++;
				$type = false;
				if (is_array($doc[$docKey])) {
					$type = 'array';
				} elseif (is_object($doc[$docKey])) {
					$type = 'object';
				} elseif (is_null($doc[$docKey])) {
					$key['null'] = true;
				} elseif (is_bool($doc[$docKey])) {
					$type = 'bool';
				} elseif (is_float($doc[$docKey])) {
					if ((float)$doc[$docKey] < 0)
						$key['negative'] = true;
					$type = 'float';
				} elseif (is_numeric($doc[$docKey]) && $doc[$docKey] == (int)$doc[$docKey]) {
					if ((int)$doc[$docKey] < 0)
						$key['negative'] = true;
					$type = 'int';
				} else
					$type = 'string';
				if ($type !== false && !in_array($type, $key['types']))
					$key['types'][] = $type;
				if ($type != 'null' && $type != 'array' && strlen($doc[$docKey]) > $key['maxLength'])
					$key['maxLength'] = strlen($doc[$docKey]);
				$fields[$suffix][$docKey] = $key;
			}
		}
		$offset += $limit;
	}
	$alters = [];
	foreach ($fields[$suffix] as $key => $data) {
		if (!in_array('array', $data['types']) && !in_array('object', $data['types'])) {
			if (in_array('string', $data['types']) && $data['maxLength'] > 3000) {
				$field = 'text CHARACTER SET \'utf8mb4\' COLLATE \'utf8mb4_unicode_ci\'';
			} elseif (in_array('string', $data['types'])) {
				$field = 'varchar('.$data['maxLength'].') CHARACTER SET \'utf8mb4\' COLLATE \'utf8mb4_unicode_ci\'';
			} elseif (in_array('float', $data['types'])) {
				$field = 'float'.($data['negative'] == false ? ' unsigned' : '');
			} elseif (in_array('int', $data['types'])) {
				$field = 'int'.($data['negative'] == false ? ' unsigned' : '');
			} elseif (in_array('bool', $data['types'])) {
				$field = 'tinyint unsigned';
			} else {
				$field = 'changeme';
				echo 'Add handling for '.$table.' '.$key.' '.json_encode($data).PHP_EOL;
			}
			if (!in_array($key, $columns)) {
				$alters[] = 'ADD COLUMN '.$key.' '.$field.' generated always as (json_unquote(json_extract(`doc`,_utf8mb4\'$.'.$key.'\'))) VIRTUAL AFTER '.$lastBeforeUpdated;
				$lastBeforeUpdated = $key;
			} else {
				$alters[] = 'CHANGE COLUMN '.$key.' '.$key.' '.$field.' GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4\'$.'.$key.'\'))) VIRTUAL ';
			}
		}
	}
	if (count($alters) > 0) {
		echo 'ALTER TABLE '.$table.PHP_EOL.' '.implode(','.PHP_EOL.' ', $alters).';'.PHP_EOL;
	}
}
