<?php
/**
* MAME XML Data Scanner
*/

require_once __DIR__.'/../../../bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;

$dataDir = '/storage/local/ConSolo/data';
$configKey = 'mame';
$row = $db->query("select * from config where field='{$configKey}'");
if (count($row) == 0) {
	$last = 0;
	$db->query("insert into config values ('{$configKey}','0')");
} else {
	$last = $row[0]['value'];
}
$version = trim(`curl -s -L https://github.com/mamedev/mame/releases/latest|grep /mamedev/mame/releases/download/|grep lx.zip|cut -d/ -f6|cut -c5-`);
echo "Last:    {$last}\nCurrent: {$version}\n";
if (intval($version) <= intval($last)) {
	die('Already Up-To-Date'.PHP_EOL);
}

echo 'Downloading MAME '.$version.PHP_EOL;
echo `wget -q https://github.com/mamedev/mame/releases/download/mame{$version}/mame{$version}b_64bit.exe -O /tmp/mame.exe;`;
echo `rm -rf /tmp/update;`;
echo 'Uncompressing MAME '.$version.PHP_EOL;
echo `7z x -o/tmp/update /tmp/mame.exe;`;
unlink('/tmp/mame.exe');
echo `mkdir -p {$dataDir}/xml/mame;`;
$fileName = $dataDir.'/xml/mame/xml-'.$version.'.xml';
if (!file_exists($fileName)) {    
	echo 'Generating XML '.$fileName.PHP_EOL;
	//echo `mame -listxml > {$fileName};`;
	echo `cd /tmp/update/; wine64 mame64.exe -listxml | pv > {$fileName};`;
}
$fileName = $dataDir.'/xml/mame/software-'.$version.'.xml';
if (!file_exists($fileName)) {
	echo 'Generating Software '.$fileName.PHP_EOL;
	//echo `mame -listsoftware > {$fileName};`;
	echo `cd /tmp/update/; wine64 mame64.exe -listsoftware | pv > {$fileName};`;
}
/*$txt = ['brothers', 'clones', 'crc', 'devices', 'full', 'media', 'roms', 'samples', 'slots', 'source'];
foreach ($txt as $list) {
	echo "Getting and Writing {$list} List   ";
	file_put_contents($list.'.txt', `mame -list{$list}`);
	echo "done\n";

}*/
echo 'Clearing out old DB data';
echo `rm -rf /tmp/update;`;
$db->query("truncate mame_machine_roms");
$db->query("truncate mame_software_roms");
$db->query("delete from mame_machines");
$db->query("delete from mame_software");
$db->query("alter table mame_machines auto_increment = 1");
$db->query("alter table mame_software auto_increment = 1");
echo ' done!'.PHP_EOL;
$xml = ['software', 'xml'];
$removeXml = ['port','chip','display','sound','dipswitch','driver','feature','sample','device_ref','input','biosset','configuration','device','softwarelist','disk','slot','ramoption','adjuster'];
foreach ($xml as $list) {
	echo "Getting {$list} List   ";
	$jsonFile = $dataDir.'/json/mame/'.$list.'-'.$version.'.json';
	$fileName = $dataDir.'/xml/mame/'.$list.'-'.$version.'.xml';
	if (!file_exists($jsonFile)) {    
		$string = file_get_contents($fileName);
		echo "Parsing XML To Array   ";
		$array = xml2array($string, 1, 'attribute');
		unset($string);
		echo "Simplifying Array   ";
		RunArray($array);
		if ($list == 'software')
			$array = $array['softwarelists']['softwarelist'];
		elseif ($list =='xml')
			$array = $array['mame']['machine'];
		echo "Writing to JSON {$jsonFile}";
		file_put_contents($jsonFile, json_encode($array, JSON_PRETTY_PRINT));
	} else {
		$array = json_decode(file_get_contents($jsonFile), TRUE);
	}
	echo 'Parsing Into DB ';
	if ($list == 'software') {
		$games = [];
		foreach ($array as $idx => $software) {
			if (isset($software['software']['name']))
				$software['software'] = [$software['software']];
			foreach ($software['software'] as $gameIdx => $gameData) {
				if (isset($gameData['info'])) {
					if (isset($gameData['info']['serial'])) {
						$gameData['serial'] = $gameData['info']['serial'];
					}
					unset($gameData['info']);
				}
				$dataArea = false;
				$partArea = false;
				if (isset($gameData['part'])) {
					$partArea = (isset($gameData['part']['name']) ? [$gameData['part']] : $gameData['part']);
					unset($gameData['part']);
				}
				$gameData['platform'] = $software['name'];
				$gameData['platform_description'] = $software['description'];
				$gameId = $db
					->insert('mame_software')
					->cols($gameData)
					->lowPriority($config['db_low_priority'])
					->query();
				if ($partArea !== false) {
					foreach ($partArea as $partData) {
						$dataArea = false;
						if (isset($partData['dataarea'])) {
							$dataArea = $partData['dataarea'];
							if (isset($dataArea['name']))
								$dataArea = [$dataArea];
							foreach ($dataArea as $dataPart) {
								if (isset($dataPart['rom'])) {
									if (isset($dataPart['rom']['name']))
										$dataPart['rom'] = [$dataPart['rom']];
									foreach ($dataPart['rom'] as $rom) {
										$rom['software_id'] = $gameId;
										//echo json_encode($rom).PHP_EOL;
										$db
											->insert('mame_software_roms')
											->cols($rom)
											->lowPriority($config['db_low_priority'])
											->query();
									}
								}
							}
						}
					}
				}
			}            
		}
	} elseif ($list == 'xml') {
		$machines = [];
		foreach ($array['mame']['machine'] as $idx => $machine) {
			$roms = false;
			foreach ($removeXml as $remove)
				if (array_key_exists($remove, $machine))
					unset($machine[$remove]);
			if (isset($machine['rom'])) {
				$roms = $machine['rom'];
				unset($machine['rom']);
				if (isset($roms['name']))
					$roms = [$roms];
			}
			$gameId = $db
				->insert('mame_machines')
				->cols($machine)
				->lowPriority($config['db_low_priority'])
				->query();
			if ($roms !== false) {
				foreach ($roms as $rom) {
					$rom['machine_id'] = $gameId;
					$db
						->insert('mame_machine_roms')
						->cols($rom)
						->lowPriority($config['db_low_priority'])
						->query();
				}
			}
		}
	}
	echo "done\n";
}
//echo `rm -rf /tmp/update;`;
$db->query("update config set config.value='{$version}' where field='{$configKey}'"); 
