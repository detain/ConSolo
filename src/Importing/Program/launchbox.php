<?php

require_once __DIR__.'/../../../bootstrap.php';

if (in_array('-h', $_SERVER['argv']) || in_array('--help', $_SERVER['argv'])) {
    die("Syntax:
    php ".$_SERVER['argv'][0]." <options>

Options:
    -h, --help  this screen
    -f          force update even if already latest version
    -k          keep xml files, dont delete them
    --no-db     skip the db updates/inserts

");
}
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$dataDir = __DIR__.'/../../../data';
$jsonDir = $dataDir.'/json/launchbox';
$xmlDir = $dataDir.'/xml/launchbox';
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
$force = in_array('-f', $_SERVER['argv']);
$skipDb = in_array('--no-db', $_SERVER['argv']);
$keepXml = in_array('-k', $_SERVER['argv']);
$zipFile = basename($url);
$modified = (new DateTime(`curl -s -I {$url} |grep "^Last-Modified:"|cut -d" " -f2-`))->format('U');
echo "Last:    {$last}\nCurrent: {$modified}\n";
if (intval($modified) <= intval($last) && !$force) {
	die('Already Up-To-Date'.PHP_EOL);
}
@mkdir($jsonDir, 0777, true);
@mkdir($xmlDir, 0777, true);
echo `wget -q {$url} -O {$zipFile};`;
echo `unzip -d "{$xmlDir}" -o {$zipFile};`;
unlink($zipFile);
$tables = [];
$source = [
    'platforms' => [],
    'companies' => [],
    'emulators' => [],
    'games' => [],
];
foreach (['Platforms', 'Files', 'Mame', 'Metadata'] as $name) {
	echo $name.PHP_EOL.'	reading..';
	$xml = file_get_contents($xmlDir.'/'.$name.'.xml');
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
					} else {
						echo "Type {$type} Key {$key} Value:".var_export($value,true).PHP_EOL;
                    }
				} else {
                    $value = trim($value);
                    //$value = utf8_encode($value);
                }
                $row[$key] = $value;
				$data[$idx][$key] = $value;
				if (strlen($value) > $tables[$type][$key]['length'])
					$tables[$type][$key]['length'] = strlen($value);
				if ($tables[$type][$key]['bool'] == true && !in_array($value, ['false', 'true']))
					$tables[$type][$key]['bool'] = false;
				if ($tables[$type][$key]['int'] == true && (string)intval($value) != (string)$value)
					$tables[$type][$key]['int'] = false;
				if ($tables[$type][$key]['float'] == true && (string)floatval($value) != (string)$value)
					$tables[$type][$key]['float'] = false;
			}
            if ($type == 'platform') {
                $source['platforms'][$row['Name']] = [
                    'id' => $row['Name'],
                    'name' => $row['Name'],
                    'altNames' => []
                ];
                foreach (['Developer', 'Manufacturer'] as $field) {
                    if (isset($row[$field]) && ((is_array($row[$field]) && count($row[$field]) > 0) || (!is_array($row[$field]) && trim($row[$field]) != ''))) {
                        if (!array_key_exists(trim($row[$field]), $source['companies'])) {
                            $source['companies'][trim($row[$field])] = [
                                'id' => trim($row[$field]),
                                'name' => trim($row[$field])
                            ];
                        }
                        $source['platforms'][$row['Name']][strtolower($field)] = trim($row[$field]);
                    }
                }
            } elseif ($type == 'emulator') {
                $source['emulators'][$row['Name']] = [
                    'id' => $row['Name'],
                    'name' => $row['Name'],
                    'platforms' => [],
                ];
            } elseif ($type == 'emulatorplatform') {
                $source['emulators'][$row['Emulator']]['platforms'][]  = $row['Platform'];
            } elseif ($type == 'platformalternatename') {
                $source['platforms'][$row['Name']]['altNames'][] = $row['Alternate'];
            }
		}
		echo 'indexed!'.PHP_EOL;
        if (!$skipDb) {
            echo '        creating table..';
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
            echo 'inserted!'.PHP_EOL;
        }
        echo '        writing json..';
		file_put_contents($jsonDir.'/'.$type.'.json', json_encode($data, getJsonOpts()));
		echo 'done'.PHP_EOL;
	}
	unset($array);
    if (!$keepXml) {
	    unlink($xmlDir.'/'.$name.'.xml');
    }
}
if (!$keepXml) {
    @rmdir($xmlDir);
}
if (!$skipDb) {
    $db->query("update config set config.value='{$modified}' where field='{$configKey}'");
}
$sources = json_decode(file_get_contents(__DIR__.'/../../../../emurelation/sources.json'), true);
$sources['launchbox']['updatedLast'] = time();
file_put_contents(__DIR__.'/../../../../emurelation/sources.json', json_encode($sources, getJsonOpts()));
file_put_contents(__DIR__.'/../../../../emurelation/sources/launchbox.json', json_encode($source, getJsonOpts()));
