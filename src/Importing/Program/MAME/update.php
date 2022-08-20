<?php
/**
* MAME XML Data Scanner
*/

require_once __DIR__.'/../../../bootstrap.php';

if (in_array('-h', $_SERVER['argv'])) {
	die("Syntax:
	php ".$_SERVER['argv'][0]." <options>

Options:
	-h          this screen
	-f          force update even if already latest version
	--no-db     skip the db updates/inserts
	--keep      keep the XML/JSON files when done

");
}
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
$force = in_array('-f', $_SERVER['argv']);
if (intval($version) <= intval($last) && !$force) {
	die('Already Up-To-Date'.PHP_EOL);
}
@mkdir($dataDir.'/xml/mame', 0777, true);
$fileXml = $dataDir.'/xml/mame/xml-'.$version.'.xml';
$fileSoftware = $dataDir.'/xml/mame/software-'.$version.'.xml';
echo `rm -rf /tmp/update;`;
if (!file_exists($fileXml) || !file_exists($fileSoftware)) {
	echo 'Downloading MAME '.$version.PHP_EOL;
	//echo `wget -q https://github.com/mamedev/mame/releases/download/mame{$version}/mame{$version}b_64bit.exe -O /tmp/mame.exe;`;
	echo 'Uncompressing MAME '.$version.PHP_EOL;
	//echo `7z x -o/tmp/update /tmp/mame.exe;`;
	//unlink('/tmp/mame.exe');
	if (!file_exists($fileXml)) {
		echo 'Generating XML '.$fileXml.PHP_EOL;
		echo `cd ~/mame;./mame -listxml > {$fileXml};`;
		//echo `cd /tmp/update/; wine64 mame64.exe -listxml 2>/dev/null | pv > {$fileXml};`;
	}
	if (!file_exists($fileSoftware)) {
		echo 'Generating Software '.$fileSoftware.PHP_EOL;
		echo `cd ~/mame;./mame -listsoftware > {$fileSoftware};`;
		//echo `cd /tmp/update/; wine64 mame64.exe -listsoftware 2>/dev/null | pv > {$fileSoftware};`;
	}
	/*$txt = ['brothers', 'clones', 'crc', 'devices', 'full', 'media', 'roms', 'samples', 'slots', 'source'];
	foreach ($txt as $list) {
		echo "Getting and Writing {$list} List   ";
		file_put_contents($list.'.txt', `mame -list{$list}`);
		echo "done\n";

	}*/
	echo `rm -rf /tmp/update;`;
}
if (!in_array('--no-db', $_SERVER['argv'])) {
    echo 'Clearing out old DB data';
    $db->query("truncate mame_machine_roms");
    $db->query("truncate mame_software_roms");
    $db->query("truncate mame_software_platforms");
    $db->query("delete from mame_machines");
    $db->query("delete from mame_software");
    $db->query("alter table mame_machines auto_increment = 1");
    $db->query("alter table mame_software auto_increment = 1");
}
echo ' done!'.PHP_EOL;
$xml = ['software', 'xml'];
$removeXml = ['port','chip','display','sound','dipswitch','driver','feature','sample','device_ref','input','biosset','configuration','device','softwarelist','disk','slot','ramoption','adjuster', 'sharedfeat'];
$mame = [
    'platforms' => [],
];
$mame['platforms']['mame'] = [
    'id' => 'mame',
    'shortName' => 'mame',
    'name' => 'MAME',
    'altNames' => ['Arcade']
];
foreach ($xml as $list) {
	echo "Getting {$list} List   ";
	@mkdir($dataDir.'/json/mame/'.$list);
	$jsonFile = $dataDir.'/json/mame/'.$list.'-'.$version.'.json';
	$fileName = $dataDir.'/xml/mame/'.$list.'-'.$version.'.xml';
	if (!file_exists($jsonFile)) {
		$string = file_get_contents($fileName);
		echo "Parsing XML To Array   ";
		$array = xml2array($string, 1, 'attribute');
		unset($string);
		echo "Simplifying Array   ";
		RunArray($array);
		if ($list == 'software') {
			$array = $array['softwarelists']['softwarelist'];
		} elseif ($list =='xml') {
			$array = $array['mame']['machine'];
		}
		echo "Writing to JSON {$jsonFile}";
		file_put_contents($jsonFile, json_encode($array, getJsonOpts()));
	} else {
		$array = json_decode(file_get_contents($jsonFile), TRUE);
	}
    echo '  Mapping '.$list.' Data to files...';
	foreach ($array as $idx => $data) {
        if ($list == 'software') {
            $mame['platforms'][$data['name']] = [
                'id' => $data['name'],
                'shortName' => $data['name'],
                'name' => $data['description'],
                'altNames' => [stripMameName($data['description'])]
            ];
        }
        $fileName =  $dataDir.'/json/mame/'.$list.'/'.$data['name'].'.json';
		echo ' '.$data['name'];
		$jsonData = json_encode($data, getJsonOpts());
		file_put_contents($fileName, $jsonData);
        if (!in_array('--no-db', $_SERVER['argv'])) {
		    $db->insert($list == 'software' ? 'mame_software_platforms' : 'mame')
			    ->cols(['doc' => $jsonData])
			    ->lowPriority($config['db']['low_priority'])
			    ->query();
        }
	}
	if (!in_array('--no-db', $_SERVER['argv'])) {
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
					/*if (isset($gameData['sharedfeat'])) {
						if (isset($gameData['sharedfeat']['compatibility']))
							$gameData['compatibility'] =  $gameData['sharedfeat']['compatibility'];
						unset($gameData['sharedfeat']);
					}*/
					$gameData['platform'] = $software['name'];
					$gameData['platform_description'] = $software['description'];
					foreach ($removeXml as $remove)
						if (array_key_exists($remove, $gameData))
							unset($gameData[$remove]);
					$gameId = $db->insert('mame_software')
						->cols($gameData)
						->lowPriority($config['db']['low_priority'])
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
											//echo json_encode($rom, getJsonOpts()).PHP_EOL;
											$db->insert('mame_software_roms')
												->cols($rom)
												->lowPriority($config['db']['low_priority'])
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
			//foreach ($array['mame']['machine'] as $idx => $machine) {
			foreach ($array as $idx => $machine) {
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
				$gameId = $db->insert('mame_machines')
					->cols($machine)
					->lowPriority($config['db']['low_priority'])
					->query();
				if ($roms !== false) {
					foreach ($roms as $rom) {
						$rom['machine_id'] = $gameId;
						$db->insert('mame_machine_roms')
							->cols($rom)
							->lowPriority($config['db']['low_priority'])
							->query();
					}
				}
			}
		}
	}
	if (!in_array('--keep', $_SERVER['argv'])) {
		@unlink($jsonFile);
		@unlink($fileName);
	}
	echo "done\n";
}
echo `rm -rf /tmp/update;`;
file_put_contents($dataDir.'/json/mame/platforms.json', json_encode($mame['platforms'], getJsonOpts()));
file_put_contents(__DIR__.'/../../../../../emurelation/sources/mame.json', json_encode($mame, getJsonOpts()));
if (!in_array('--no-db', $_SERVER['argv'])) {
    $db->query("update config set config.value='{$version}' where field='{$configKey}'");
}
