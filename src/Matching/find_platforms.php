<?php
require_once __DIR__.'/../bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$mediaTypes = [
	'- Datach Joint ROM System mini-cartridges',
	'- Nantettatte!! Baseball mini-cartridges',
	'- Karaoke Studio 4ion cartridges',
	'- Aladdin Deck Enhancer cartridges',
	"'Game' cartridges",
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
	if (!array_key_exists($platformCut, $platformSrc))
		$platformSrc[$platformCut] = [];	
	if (!array_key_exists($platform, $platformAlt)) {
		if (!array_key_exists($platformCut, $platformAlt)) {
			$platforms[] = $platformCut;
			$platformAlt[$platform] = $platformCut;
			$platformSrc[$platform][] = 'MAME';
			$platformSrc[$platformCut][] = 'MAME';
		} else {
			$platformAlt[$platform] = $platformAlt[$platformCut];
			if (!in_array('MAME', $platformSrc[$platform]))
				$platformSrc[$platform][] = 'MAME';
		}
	} else {
		if (!array_key_exists($platformCut, $platformAlt)) {
			$platformAlt[$platformCut] = $platformAlt[$platform];
			$platformSrc[$platformCut] = ['MAME'];
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
		elseif (!in_array('MAME', $platformSrc[$name]))
			$platformSrc[$name][] = 'OldComputers';		
	}
}
$db->query("truncate platform_matches");
$db->query("truncate platforms");
//$db->query("delete from platforms");
//$db->query("alter table platforms auto_increment=1");
foreach ($platforms as $platform) {
	$id = $db->insert('platforms')
		->cols(['name' => $platform])
		->query();
	echo 'Added Platform '.$id.' '.$platform.PHP_EOL;
	if (isset($platformMain[$platform]))
		foreach ($platformMain[$platform] as $alt) {
			foreach ($platformSrc[$alt] as $source) {
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
