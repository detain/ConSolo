<?php

require_once __DIR__.'/../../../bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$dataDir = '/storage/local/ConSolo/data/json/launchbox';
$url = 'https://gamesdb.launchbox-app.com/Metadata.zip'; 
$tablePrefix = 'launchbox_';
$tableSuffix = 's';
$configKey = 'launchbox';
$row = $db->query("select * from config where field='{$configKey}'");
if (count($row) == 0) {
	$last = 0;
	$db->query("insert into config values ('{$configKey}','0')");
} else {
	$last = $row[0]['value'];
}
$zipFile = basename($url);
$modified = (new DateTime(`curl -s -I {$url} |grep "^Last-Modified:"|cut -d" " -f2-`))->format('U');
echo "Last:    {$last}\nCurrent: {$modified}\n";
if (intval($modified) <= intval($last)) {
	die('Already Up-To-Date'.PHP_EOL);
}
echo `wget -q {$url} -O {$zipFile};`;
echo `unzip -o {$zipFile};`;
unlink($zipFile);
$tables = [];
foreach (['Platforms', 'Files', 'Mame', 'Metadata'] as $name) {
	echo $name.PHP_EOL.'	reading..';
	$xml = file_get_contents($name.'.xml');
	echo 'read!'.PHP_EOL.'	parsing..';
	$array = xml2array($xml);
	echo 'parsed!'.PHP_EOL;
	foreach ($array['LaunchBox'] as $type => $data) {
		$type = strtolower($type);
		echo '	working on type '.$type.'..'.PHP_EOL.'		indexing...';
		$tables[$type] = [];
		foreach ($data as $idx => $row) {
			foreach ($row as $key => $value) {
				//$key = strtolower($key);
				if (!isset($tables[$type][$key]))
					$tables[$type][$key] = [
						'bool' => true,
						'int' => true,
						'float' => true,
						'length' => 0,
					];
				if (is_array($value)) {
					if (count($value) == 0) {
						$value = '';
						$data[$idx][$key] = $value;
					} else
						echo "Type {$type} Key {$key} Value:".var_export($value,true).PHP_EOL;
				}
				$data[$idx][$key] = utf8_encode($value);
				if (strlen($value) > $tables[$type][$key]['length'])
					$tables[$type][$key]['length'] = strlen($value);
				if ($tables[$type][$key]['bool'] == true && !in_array($value, ['false', 'true']))
					$tables[$type][$key]['bool'] = false;
				if ($tables[$type][$key]['int'] == true && (string)intval($value) != (string)$value)
					$tables[$type][$key]['int'] = false;
				if ($tables[$type][$key]['float'] == true && (string)floatval($value) != (string)$value)
					$tables[$type][$key]['float'] = false;
			}
		}
		echo 'indexed!'.PHP_EOL.'		creating table..';
		 $create = [];
		$create[] = '`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT';
		foreach ($tables[$type] as $key => $row) {
			if ($row['bool'] === true)
				$create[] = '`'.$key.'` VARCHAR(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL';
				//$create[] = '`'.$key.'` BOOLEAN DEFAULT NULL';
			elseif ($row['int'] == true)
				$create[] = '`'.$key.'` BIGINT DEFAULT NULL';
			elseif ($row['float'] == true)
				$create[] = '`'.$key.'` FLOAT DEFAULT NULL';
			elseif ($row['length'] > 190)
				$create[] = '`'.$key.'` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL';
			else
				$create[] = '`'.$key.'` VARCHAR('.($row['length'] + 1).') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL';
		}
		$create[] = 'PRIMARY KEY (`id`)';
		$create = 'CREATE TABLE `'.$tablePrefix.$type.$tableSuffix.'` ('.PHP_EOL.'  '.implode(','.PHP_EOL.'  ', $create).PHP_EOL.') ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';
		//echo PHP_EOL.$create.PHP_EOL;
		$db->query("drop table if exists {$tablePrefix}{$type}{$tableSuffix}");
		$db->query($create);
		echo 'created '.$type.'!'.PHP_EOL.'		inserting '.count($data).' rows..';
		foreach ($data as $idx => $row) {
			try {
				$db->insert($tablePrefix.$type.$tableSuffix)
					->cols($row)
					->lowPriority($config['db']['low_priority'])
					->query();
			} catch (\PDOException $e) {
				echo "Caught PDO Exception!".PHP_EOL;
				echo "Values: ".var_export($row, true).PHP_EOL;
				echo "Message: ".$e->getMessage().PHP_EOL;
				echo "Code: ".$e->getCode().PHP_EOL;
				echo "File: ".$e->getFile().PHP_EOL;
				echo "Line: ".$e->getLine().PHP_EOL;
				echo "Trace: ".$e->getTraceAsString().PHP_EOL;
			}
		}
		echo 'inserted!'.PHP_EOL.'		writing json..';
		file_put_contents($dataDir.'/'.$type.'.json', json_encode($data, getJsonOpts()));
		echo 'done'.PHP_EOL;
	}
	unset($array);
	unlink($name.'.xml');
}
$db->query("update config set config.value='{$modified}' where field='{$configKey}'"); 
