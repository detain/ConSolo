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
	'null' => true,
];
$storedFields = ['id', 'season_number', 'imdb_id', 'title'];
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
	$tableSchema = $db->row('show create table '.$table);
	$schemaFields = [];
	preg_match_all('/^  `([^`]*)` (.*),$/msuU', $tableSchema['Create Table'], $matches);	
	//print_r($matches);
	foreach ($matches[1] as $idx => $field) {
		$schemaFields[$field] = [
			'line' => $matches[0][$idx],
			'setting' => $matches[2][$idx],
			'null' => strpos($matches[0][$idx], ' NOT NULL') === false ? true : false,
		];
	}
	$alters = [];
	$comments = [];
	foreach ($fields[$suffix] as $key => $data) {
		if (!in_array('array', $data['types']) && !in_array('object', $data['types'])) {
			$storage = in_array($key, $storedFields) ? 'STORED' : 'VIRTUAL';
			if (in_array('string', $data['types']) && $data['maxLength'] > 3000) {
				$field = 'text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci';
			} elseif (in_array('string', $data['types'])) {
				if ($data['maxLength'] > 1000) {
					$data['maxLength'] = ceil($data['maxLength'] / 1000) * 1000;
				} elseif ($data['maxLength'] > 100) {
					$data['maxLength'] += $data['maxLength'];
					$data['maxLength'] = ceil($data['maxLength'] / 100) * 100;
				} elseif ($data['maxLength'] > 50) {
					$data['maxLength'] += $data['maxLength'];
					$data['maxLength'] = ceil($data['maxLength'] / 10) * 10;
				}
				$field = 'varchar('.$data['maxLength'].') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci';
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
			$fieldSetting = $field.' GENERATED ALWAYS AS (json_unquote(json_extract(`doc`,_utf8mb4\'$.'.$key.'\'))) '.$storage.($schemaFields[$key]['null'] === false ? ' NOT NULL' : '');
			if (!in_array($key, $columns)) {
				$alters[] = 'ADD COLUMN '.$key.' '.$fieldSetting.' AFTER '.$lastBeforeUpdated;
				$lastBeforeUpdated = $key;
			} else {
				if (str_replace(' CHARACTER SET utf8mb4', '', $schemaFields[$key]['setting']) != str_replace(' CHARACTER SET utf8mb4', '', $fieldSetting)) {
					$comments[] = '--  '.$schemaFields[$key]['line'];
					$alters[] = 'CHANGE COLUMN '.$key.' '.$key.' '.$fieldSetting;
				}
			}
		}
	}
	if (count($alters) > 0) {
		echo implode(','.PHP_EOL, $comments).PHP_EOL.'ALTER TABLE '.$table.PHP_EOL.implode(','.PHP_EOL, $alters).';'.PHP_EOL;
	}
}
