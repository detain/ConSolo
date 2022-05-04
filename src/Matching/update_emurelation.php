<?php
require_once __DIR__.'/../bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$sourceDir = '/storage/local/emurelation/sources';
// TOSEC
$results = $db->query("SELECT name FROM consolo.dat_files where type in ('TOSEC','TOSEC-ISO')");
$platforms = [];
foreach ($results as $data) {
	$platform = preg_replace('/^(.*) - .*$/uU', '$1', $data['name']);
	if (!array_key_exists($platform, $platforms))
		$platforms[$platform] = ['files' => []];
	$platforms[$platform]['files'][] = $data['name'];
}
file_put_contents($sourceDir.'/tosec.json', json_encode($platforms, JSON_PRETTY_PRINT));
// No-Intro
$results = $db->query("SELECT name FROM consolo.dat_files where type='No-Intro'");
$platforms = [];
foreach ($results as $data) {
	$platform = preg_replace('/^((Unofficial|Non-Redump|Source Code) - )?(.*)$/u', '$3', $data['name']);
	$platform = preg_replace('/^([^\(]*)( \(.*)?$/uU', '$1', $platform);
	if (preg_match('/^(?P<manufacturer>.*) - (?P<platform>.*)$/uU', $platform, $matches)) {
		$manufacturer = $matches['manufacturer'];
		$platform = $matches['platform'];
		if (substr($platform, 0, strlen($manufacturer)+3) == $manufacturer.' - ')
			$platform = substr($platform, strlen($manufacturer)+3);
		if (!array_key_exists($manufacturer, $platforms))
			$platforms[$manufacturer] = [];
		if (!array_key_exists($platform, $platforms[$manufacturer]))
			$platforms[$manufacturer][$platform] = ['files' => []];
		$platforms[$manufacturer][$platform]['files'][] = $data['name'];
	}
}
file_put_contents($sourceDir.'/nointro.json', json_encode($platforms, JSON_PRETTY_PRINT));
// Redump
$results = $db->query("SELECT name FROM consolo.dat_files where type='Redump'");
$platforms = [];
foreach ($results as $data) {
	$platform = preg_replace('/^(Arcade - )?(.*)$/mu', '$2', $data['name']);
	if (!array_key_exists($platform, $platforms))
		$platforms[$platform] = ['files' => []];
	$platforms[$platform]['files'][] = $data['name'];
}
file_put_contents($sourceDir.'/redump.json', json_encode($platforms, JSON_PRETTY_PRINT));
// ScreenScraper.fr
$results = $db->query("SELECT doc FROM consolo.ss_platforms");
$fields = [
	'compagnie' => 'company',
	'datedebut' => 'date_start',
	'datefin' => 'date_end',
];
$types = [
	'Accessoire' => 'Accessory',
	'Arcade' => 'Arcade',
	'Autres' => 'Others',
	'Console' => 'Console',
	'Console &amp; Arcade' => 'Console &amp; Arcade',
	'Console Portable' => 'Portable Console',
	'Emulation Arcade' => 'Arcade Emulator',
	'Flipper' => 'Pinball',
	'Machine Virtuelle' => 'Virtual Machine',
	'Ordinateur' => 'Computer',
	'Smartphone' => 'Smartphone',
];
$romtypes = [
	'dossier' => 'folder',
	'fichier' => 'file',
	'iso' => 'iso',
	'rom' => 'rom',
];
$supporttypes = [
	'carte' => 'menu',
	'cartouche' => 'cartridge',
	'cartouche-download' => 'cartridge-download',
	'cartouche-k7' => 'cartridge-k7',
	'cartouche-k7-disquette' => 'cartridge-k7-floppy disk',
	'cd' => 'cd',
	'cd-disquette' => 'cd-floppy disk',
	'disquette' => 'floppy disk',
	'download' => 'download',
	'hardware' => 'hardware',
	'k7' => 'k7',
	'k7-disquette' => 'k7-floppy disk',
	'non-applicable' => 'non-applicable',
	'pcb' => 'pcb',
	'smc' => 'smc',
	'videotape' => 'video tape',
];
$platforms = [];
foreach ($results as $data) {
	$json = json_decode($data['doc'], true);
	unset($json['medias']);
	foreach ($json['noms'] as $field => $value) {
		$field = str_replace(['noms_commun', 'nom_'], ['alternate', 'name_'], $field);
		$json[$field] = $value;
	}
	unset($json['noms']);
	if (isset($json['name_us']))
		$json['name'] = $json['name_us'];
	elseif (isset($json['name_eu']))
		$json['name'] = $json['name_eu'];
	elseif (isset($json['name_jp']))
		$json['name'] = $json['name_jp'];
	foreach ($fields as $field => $value) {
		if (isset($json[$field])) {
			$json[$value] = $json[$field];
			unset($json[$field]);
		}
	}
	if (isset($json['type']))
		$json['type'] = $types[$json['type']];
	if (isset($json['romtype']))
		$json['romtype'] = $romtypes[$json['romtype']];
	if (isset($json['supporttype']))
		$json['supporttype'] = $supporttypes[$json['supporttype']];
	$platform = isset($json['company']) ? $json['company'].' '.$json['name'] : $json['name'];
	$platforms[$platform] = $json;
}
file_put_contents($sourceDir.'/screenscraper.json', json_encode($platforms, JSON_PRETTY_PRINT));

exit;
$mediaTypes = [
	'- Datach Joint ROM System mini-cartridges',
	'- Nantettatte!! Baseball mini-cartridges',
	'- Karaoke Studio 4ion cartridges',
	'- Aladdin Deck Enhancer cartridges',
	"'Game' cartridges",
	'Beta Disc / TR-DOS disk images',
	"'Design / Media' cartridges",
	'cleanly cracked 5.25" disks',
	'cleanly cracked 5.25 disks',
	'5.25 miscellaneous disks',
	'5.25" miscellaneous disks',
	'disk images (misc list)',
	'Hardware driver disks',
	'Master Compact disks',
	'SmartMedia Flash ROM',
	'5.25" original disks',
	'5.25 original disks',
	'2nd Processor discs',
	'Digital Data Packs',
	'ROMPACK cartridges',
	'5.25" inch floppies',
	'5.25 inch floppies',
	'(German) cassettes',
	'Application disks',
	'Master cartridges',
	'ROMPAK cartridges',
	'tapes/cartridges',
	'Master cassettes',
	'Media cartridges',
	'SmartMedia cards',
	'internal sockets',
	'Workbench disks',
	'mini-cartridges',
	'cartridge tapes',
	'snapshot images',
	'ROM extensions',
	'expansion ROMs',
	'Original disks',
	'ROM expansions',
	'(Euro) CD-ROMs',
	'(Jpn) CD-ROMs',
	'Function ROMs',
	'expansion ROM',
	'floppy images',
	'miscellaneous disks',
	'CD-ROM images',
	'floppy disks',
	'memory cards',
	'ROM capsules',
	'Memory Packs',
	'System disks',
	'Option ROMs',
	'RFID cards',
	'hard disk images',
	'Floppy Discs',
	'disk images',
	'disc images',
	'Master disks',
	'ROM images',
	'cartridges',
	'5.25" disks',
	'5.25 disks',
	'(US) disks',
	'quickloads',
	'hard disks',
	'diskettes',
	'cassettes',
	'3.5" disks',
	'quickload',
	'3.5 disks',
	'ROM Packs',
	'snapshots',
	'cassette',
	'floppies',
	'Datapack',
	'QD disks',
	'software',
	'modules',
	'CD-ROMs',
	'Discs',
	'disks',
	'ROMs',
	'ROM',
];
$json = json_decode(file_get_contents(__DIR__.'/../../json/platforms.json'), true);
$platform_manufacturers = json_decode(file_get_contents(__DIR__.'/../../json/platform_manufacturers.json'), true);
$platformSrc = [];
$platformAlt = [];
$platforms = [];
foreach ($json as $platform => $alternatives) {
	$platforms[] = $platform;
	foreach ($alternatives as $alternative => $sources) {
		if (!array_key_exists($alternative, $platformAlt))
			$platformAlt[$alternative] = $platform;
		if (!array_key_exists($alternative, $platformSrc))
			$platformSrc[$alternative] = [];
		foreach ($sources as $source) {
			$platformSrc[$alternative][] = $source;
		}
	}
}
$rows = $db->select('name')
	->from('tgdb_platforms')
	->column();
foreach ($rows as $platform) {
	if (!array_key_exists($platform, $platformAlt)) {
		echo "Missing TGDB Platform {$platform}\n";
	}
}
$rows = $db->select('Name')
	->from('launchbox_platforms')
	->column();
foreach ($rows as $platform) {
	if (!array_key_exists($platform, $platformAlt)) {
		echo "Missing LaunchBox Platform {$platform}\n";
	} else {

		$rows2 = $db->query("SELECT Name, Alternate FROM launchbox_platformalternatenames where Name='{$platform}'");
		$mainPlatform = $platformAlt[$platform];
		foreach ($rows2 as $row) {
			if (!array_key_exists($row['Alternate'], $platformAlt))
				$platformAlt[$row['Alternate']] = $mainPlatform;
			if (!array_key_exists($row['Alternate'], $platformSrc)) {
				$platformSrc[$row['Alternate']] = ['LaunchBox'];
			} elseif (!in_array('LaunchBox', $platformSrc[$row['Alternate']])) {
				$platformSrc[$row['Alternate']][] = 'LaunchBox';
			}
		}
	}
}
$dataDir = '/storage/local/ConSolo/json';
$silentSources = ['OldComputers'];
foreach ($platform_manufacturers as $source => $manufacturers) {
	foreach ($manufacturers as $manufacturer => $sourcePlatforms) {
		foreach ($sourcePlatforms as $idx => $platform) {
			if (is_array($platform)) {
				$platformArray = $platform;
				$platform = key($platformArray);
				$mainPlatform = $platformArray[$platform];
			}
			if (in_array($source, ['TheGamesDB', 'LaunchBox'])) {
				// the platforms for these often include the manufacturer name already
				if (!array_key_exists($manufacturer.' '.$platform, $platformAlt)) {
					if (!array_key_exists($platform, $platformAlt)) {
						if (!in_array($source, $silentSources))
							echo 'Missing '.$source.' Manufacturer '.$manufacturer.' with combined Platform '.$platform.PHP_EOL;
					} else {
						$sourcePlatforms[$idx] = [$platform => $platformAlt[$platform]];
						//echo 'Found '.$source.' Manufacturer '.$manufacturer.' with combined Platform '.$platform.PHP_EOL;
					}
				} else {
					$sourcePlatforms[$idx] = [$platform => $platformAlt[$manufacturer.' '.$platform]];
					//echo 'Found '.$source.' Manufacturer '.$manufacturer.' Platform '.$platform.PHP_EOL;
				}
			} else {
				// the platform and manufacturer are seprate/nested
				if (!array_key_exists($manufacturer.' '.$platform, $platformAlt)) {
					if (!in_array($source, $silentSources))
						echo "\"{$manufacturer} {$platform}\":{\"{$manufacturer} {$platform}\":[\"{$source}\"]},".PHP_EOL;
				} else {
					//echo 'Found '.$source.' Manufacturer '.$manufacturer.' Platform '.$platform.PHP_EOL;
					$sourcePlatforms[$idx] = [$platform => $platformAlt[$manufacturer.' '.$platform]];
				}
			}

		}
		$manufacturers[$manufacturer] = $sourcePlatforms;
	}
	$platform_manufacturers[$source] = $manufacturers;
}
file_put_contents($dataDir.'/platform_manufacturers.json', json_encode($platform_manufacturers, JSON_PRETTY_PRINT));
$rows = $db->query('SELECT platform,platform_description FROM mame_software group by platform');
foreach ($rows as $row) {
	$platform = $row['platform_description'];
	$platformCut = $platform;
	foreach ($mediaTypes as $type) {
		if (preg_match('/\s+'.preg_quote($type, '/').'$/i', $platformCut) !== false) {
			$platformCut = preg_replace('/\s+'.preg_quote($type, '/').'$/i', '', $platformCut);
		}
	}
	if (!array_key_exists($platform, $platformSrc))
		$platformSrc[$platform] = [];
	//if (!array_key_exists($platformCut, $platformSrc))
		//$platformSrc[$platformCut] = [];
	if (!array_key_exists($platform, $platformAlt)) {
		if (!array_key_exists($platformCut, $platformAlt)) {
			$platforms[] = $platformCut;
			$platformAlt[$platform] = $platformCut;
			$platformSrc[$platform][] = 'MAME';
			//$platformSrc[$platformCut][] = 'MAME';
		} else {
			$platformAlt[$platform] = $platformAlt[$platformCut];
			if (!in_array('MAME', $platformSrc[$platform]))
				$platformSrc[$platform][] = 'MAME';
			if (!array_key_exists($row['platform'], $platformAlt))
				$platformAlt[$row['platform']] = $platformAlt[$platformCut];
			if (!array_key_exists($row['platform'], $platformSrc)) {
				$platformSrc[$row['platform']] = ['MAME'];
			} elseif (!in_array('MAME', $platformSrc[$row['platform']])) {
				$platformSrc[$row['platform']][] = 'MAME';
			}
		}
	} else {
		if (!array_key_exists($platformCut, $platformAlt)) {
			//$platformAlt[$platformCut] = $platformAlt[$platform];
			//$platformSrc[$platformCut] = ['MAME'];
		}
		if (!array_key_exists($row['platform'], $platformAlt))
			$platformAlt[$row['platform']] = $platform;
		if (!array_key_exists($row['platform'], $platformSrc)) {
			//echo 'Added MAME Platform '.$row['platform'].PHP_EOL;
			$platformSrc[$row['platform']] = ['MAME'];
		} elseif (!in_array('MAME', $platformSrc[$row['platform']])) {
			//echo 'Added MAME Platform '.$row['platform'].PHP_EOL;
			$platformSrc[$row['platform']][] = 'MAME';
		}
	}
}
$platformMain = [];
foreach ($platformAlt as $alt => $platform) {
	if (!array_key_exists($platform, $platformMain))
		$platformMain[$platform] = [];
	$platformMain[$platform][] = $alt;
}
foreach ($platforms as $platform) {
	$all = $alt = array_key_exists($platform, $platformMain) ? $platformMain[$platform] : [];
	$all[] = $platform;
	foreach ($all as $idx => $row) {
		$all[$idx] = str_replace("'", "\\'", $row);
	}
	$rows = $db->query("select name, manufacturer from oldcomputers_platforms where name in ('".implode("','", $all)."') or concat(manufacturer, ' ', name) in ('".implode("','", $all)."')");
	if (count($rows)) {
		//echo "Found for ".count($rows)." Platform {$platform} Alts ".implode(', ', $alt).PHP_EOL;
		//print_r($rows);
		$name = str_replace($rows[0]['manufacturer'].' '.$rows[0]['manufacturer'].' ', $rows[0]['manufacturer'].' ', $rows[0]['manufacturer'].' '.$rows[0]['name']);
		if (!array_key_exists($name, $platformAlt))
			$platformAlt[$name] = $platform;
		if (!array_key_exists($platform, $platformMain))
			$platformMain[$platform] = [$name];
		elseif (!in_array($name, $platformMain[$platform]))
			$platformMain[$platform][] = $name;
		if (!array_key_exists($name, $platformSrc))
			$platformSrc[$name] = ['OldComputers'];
		elseif (!in_array('OldComputers', $platformSrc[$name]))
			$platformSrc[$name][] = 'OldComputers';
	}
}
$db->query("truncate platform_matches");
$db->query("truncate platforms");
//$db->query("delete from platforms");
//$db->query("alter table platforms auto_increment=1");
sort($platforms);
$json = [];
foreach ($platforms as $platform) {
	$json[$platform] = [];
	$id = $db->insert('platforms')
		->cols(['name' => $platform])
		->query();
	echo 'Added Platform '.$id.' '.$platform.PHP_EOL;
	if (isset($platformMain[$platform]))
		foreach ($platformMain[$platform] as $alt) {
			$json[$platform][$alt] = [];
			foreach ($platformSrc[$alt] as $source) {
				$json[$platform][$alt][] = $source;
				$db->insert('platform_matches')
					->cols([
						'parent' => $platform,
						'name' => $alt,
						'type' => $source,
					])
					->query();
				echo '	Added '.$source.' Platform Alt '.$alt.PHP_EOL;
			}
		}
}
foreach ($json as $platform => $data) {
	foreach ($data as $name => $subplatforms)
		$data[$name] = array_unique($subplatforms);
	$json[$platform] = $data;
}
$lines = [];
foreach ($json as $platform => $rows) {
	$lines[] = '	"'.$platform.'": '.json_encode($rows);
}
file_put_contents(__DIR__.'/../../json/platforms.json', '{'.PHP_EOL.implode(','.PHP_EOL, $lines).PHP_EOL.'}');