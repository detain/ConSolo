<?php
require_once __DIR__.'/../bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db, $mysqlLinkId;
$sourceDir = '/storage/local/emurelation/sources';
$allPlatforms = [];
$allAlternates = [];

// LaunchBox
echo "Building LaunchBox Platforms\n";
echo "Building LaunchBox Platforms\n";
$results = $db->query("SELECT * FROM consolo.launchbox_platforms");
$alternates = [];
$alternates = [];
$platforms = [];
foreach ($results as $data) {
	$platform = [];
	foreach ($data as $field => $value)
		if (!is_null($value))
			$platform[strtolower($field)] = $value;
	$alts = [];
	$results2 = $db->query("SELECT Alternate FROM consolo.launchbox_platformalternatenames where Name='".$mysqlLinkId->real_escape_string($data['Name'])."'");
	foreach ($results2 as $data2) {
		$alts[] = $data2['Alternate'];
		$alternates[$data2['Alternate']] = $platform['name'];
	}
	if (count($alts) > 0)
		$platform['alternate'] = $alts;
	$alternates[$platform['name']] = $platform['name'];
	$platforms[$platform['name']] = $platform;
}
$allPlatforms['launchbox'] = $platforms;
$allAlternates['launchbox'] = $alternates;
file_put_contents($sourceDir.'/launchbox.json', json_encode($allPlatforms['launchbox'], JSON_PRETTY_PRINT));

// TheGamesDB
echo "Building TheGamesDB Platforms\n";
$results = $db->query("SELECT * FROM consolo.tgdb_platforms");
$alternates = [];
$platforms = [];
foreach ($results as $data) {
	$platform = [];
	foreach ($data as $field => $value)
		if (!is_null($value))
			$platform[$field] = $value;
	$data = $platform;
	$platform = $data['name'];
	if (isset($data['manufacturer']) || isset($data['developer'])) {
		$manuf = $data['developer'] ?? $data['manufacturer'];
		if (strtolower(substr($platform, 0, strlen($manuf)+1)) != strtolower($manuf.' '))
			$platform = $manuf.' '.$platform;
	}
	$alternates[$platform] = $platform;
	$platforms[$platform] = $data;
}
$allPlatforms['thegamesdb'] = $platforms;
$allAlternates['thegamesdb'] = $alternates;
file_put_contents($sourceDir.'/thegamesdb.json', json_encode($allPlatforms['thegamesdb'], JSON_PRETTY_PRINT));

// TOSEC
echo "Building TOSEC Platforms\n";
$results = $db->query("SELECT name FROM consolo.dat_files where type in ('TOSEC','TOSEC-ISO')");
$alternates = [];
$platforms = [];
foreach ($results as $data) {
	$platform = preg_replace('/^(.*) - .*$/uU', '$1', $data['name']);
	if (!array_key_exists($platform, $platforms))
		$platforms[$platform] = ['files' => []];
	$platforms[$platform]['files'][] = $data['name'];
	$alternates[$platform] = $platform;
	$alternates[$data['name']] = $platform;
}
$allPlatforms['tosec'] = $platforms;
$allAlternates['tosec'] = $alternates;
file_put_contents($sourceDir.'/tosec.json', json_encode($allPlatforms['tosec'], JSON_PRETTY_PRINT));

// No-Intro
echo "Building No-Intro Platforms\n";
$results = $db->query("SELECT name FROM consolo.dat_files where type='No-Intro'");
$alternates = [];
$platforms = [];
foreach ($results as $data) {
	$platform = preg_replace('/^((Unofficial|Non-Redump|Source Code) - )?(.*)$/u', '$3', $data['name']);
	$platform = preg_replace('/^([^\(]*)( \(.*)?$/uU', '$1', $platform);
	if (preg_match('/^(?P<manufacturer>.*) - (?P<platform>.*)$/uU', $platform, $matches)) {
		$manufacturer = $matches['manufacturer'];
		$platform = $matches['platform'];
		if (substr($platform, 0, strlen($manufacturer)+3) == $manufacturer.' - ')
			$platform = substr($platform, strlen($manufacturer)+3);
		$platform = $manufacturer.' '.$platform;
		if (!array_key_exists($platform, $platforms))
			$platforms[$platform] = ['files' => []];
		$alternates[$platform] = $platform;
		$alternates[$data['name']] = $platform;
		$platforms[$platform]['files'][] = $data['name'];
	}
}
$allPlatforms['nointro'] = $platforms;
$allAlternates['nointro'] = $alternates;
file_put_contents($sourceDir.'/nointro.json', json_encode($allPlatforms['nointro'], JSON_PRETTY_PRINT));

// Redump
echo "Building Redump Platforms\n";
$results = $db->query("SELECT name FROM consolo.dat_files where type='Redump'");
$alternates = [];
$platforms = [];
foreach ($results as $data) {
	$platform = preg_replace('/^(Arcade - )?(.*)$/mu', '$2', $data['name']);
	$platform = str_replace(' - ', ' ', $platform);
	if (!array_key_exists($platform, $platforms))
		$platforms[$platform] = ['files' => []];
	$alternates[$platform] = $platform;
	$alternates[$data['name']] = $platform;
	$platforms[$platform]['files'][] = $data['name'];
}
$allPlatforms['redump'] = $platforms;
$allAlternates['redump'] = $alternates;
file_put_contents($sourceDir.'/redump.json', json_encode($allPlatforms['redump'], JSON_PRETTY_PRINT));

// MAME
echo "Building MAME Platforms\n";
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
$results = $db->query("SELECT name, description FROM consolo.mame_software_platforms");
$alternates = [];
$platforms = [];
foreach ($results as $data) {
	$platform = $data['description'];
	foreach ($mediaTypes as $type)
		if (preg_match('/\s+'.preg_quote($type, '/').'$/i', $platform) !== false)
			$platform = preg_replace('/\s+'.preg_quote($type, '/').'$/i', '', $platform);
	if (!array_key_exists($platform, $platforms))
		$platforms[$platform] = ['types' => [], 'short' => []];
	$alternates[$platform] = $platform;
	$alternates[$data['description']] = $platform;
	$alternates[$data['name']] = $platform;
	$platforms[$platform]['types'][] = $data['description'];
	$platforms[$platform]['short'][] = $data['name'];
}
$allPlatforms['mame'] = $platforms;
$allAlternates['mame'] = $alternates;
file_put_contents($sourceDir.'/mame.json', json_encode($allPlatforms['mame'], JSON_PRETTY_PRINT));

// Old-Computers.com
echo "Building Old-Computers.com Platforms\n";
$results = $db->query("SELECT * FROM consolo.oc_platforms");
$alternates = [];
$platforms = [];
foreach ($results as $data) {
	unset($data['doc']);
	$platform = [];
	foreach ($data as $field => $value)
		if (!is_null($value))
			$platform[$field] = $value;
	$alternates[$platform['company_name'].' '.$platform['name']] = $platform['company_name'].' '.$platform['name'];
	$platforms[$platform['company_name'].' '.$platform['name']] = $platform;
}
$allPlatforms['oldcomputers'] = $platforms;
$allAlternates['oldcomputers'] = $alternates;
file_put_contents($sourceDir.'/oldcomputers.json', json_encode($allPlatforms['oldcomputers'], JSON_PRETTY_PRINT));

// ScreenScraper.fr
echo "Building ScreenScraper.fr Platforms\n";
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
	'Console & Arcade' => 'Console & Arcade',
	'Console &amp; Arcade' => 'Console & Arcade',
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
$alternates = [];
$platforms = [];
foreach ($results as $data) {
	$json = json_decode(str_replace('&apos;', "'", html_entity_decode($data['doc'])), true);
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
	$platform = isset($json['company']) ? $json['company'].' '.$json['name'] : $json['name'];
	if (isset($json['type']))
		$json['type'] = $types[$json['type']];
	if (isset($json['romtype']))
		$json['romtype'] = $romtypes[$json['romtype']];
	if (isset($json['supporttype']))
		$json['supporttype'] = $supporttypes[$json['supporttype']];
	if (isset($json['alternate'])) {
		$json['alternate'] = explode(',', $json['alternate']);
		foreach ($json['alternate'] as $alternate)
			$alternates[$alternate] = $platform;
	}
	$alternates[$platform] = $platform;
	$platforms[$platform] = $json;
}
$allPlatforms['screenscraper'] = $platforms;
$allAlternates['screenscraper'] = $alternates;
file_put_contents($sourceDir.'/screenscraper.json', json_encode($allPlatforms['screenscraper'], JSON_PRETTY_PRINT));

// Ours
echo "Building Local Platforms\n";
$results = $db->query("SELECT * FROM consolo.platforms");
$platforms = [];
foreach ($results as $data) {
	unset($data['id']);
	$platform = [];
	foreach ($data as $field => $value)
		if (!is_null($value))
			$platform[$field] = $value;
	$matches = [];
	$results2 = $db->query("SELECT name, type FROM consolo.platform_matches where parent='".$mysqlLinkId->real_escape_string($platform['name'])."'");
	foreach ($results2 as $data2) {
		$data2['type'] = strtolower(str_replace(['TOSEC-PIX', 'TOSEC-ISO'], ['TOSEC', 'TOSEC'], $data2['type']));
		if (!array_key_exists($data2['type'], $matches))
			$matches[$data2['type']] = [];
		if (!in_array($data2['name'], $matches[$data2['type']]))
			$matches[$data2['type']][] = $data2['name'];
	}
	//if (count($matches) > 0)
		//$platform['matches'] = $matches;
	$platforms[$platform['name']] = $matches;
}
$allPlatforms['local'] = $platforms;
file_put_contents($sourceDir.'/local.json', json_encode(array_keys($allPlatforms['local']), JSON_PRETTY_PRINT));

//file_put_contents($sourceDir.'/alternatives.json', json_encode($allAlternates, JSON_PRETTY_PRINT));
//file_put_contents($sourceDir.'/platforms.json', json_encode($allPlatforms, JSON_PRETTY_PRINT));

echo "Building Platform Matches\n";
$found = [];
foreach ($allPlatforms['local'] as $platform => $typeData) {
	$found[$platform] = [];
	//foreach (array_keys($allAlternates) as $type)
		//$found[$platform][$type] = [];
	foreach ($typeData as $type => $alts) {
		foreach ($alts as $altKey) {
			if (!array_key_exists($type, $allAlternates))
				echo "No {$type} in all alternates for platform {$platform}\n";
			if (array_key_exists($altKey, $allAlternates[$type])) {
				$otherPlatform = $allAlternates[$type][$altKey];
				if (!array_key_exists('local', $allPlatforms[$type][$otherPlatform]))
					$allPlatforms[$type][$otherPlatform]['local'] = [];
				if (!in_array($platform, $allPlatforms[$type][$otherPlatform]['local']))
					$allPlatforms[$type][$otherPlatform]['local'][] = $platform;
				if (!array_key_exists($platform, $found))
					$found[$platform] = [];
				if (!array_key_exists($type, $found[$platform]))
					$found[$platform][$type] = [];
				if (!in_array($otherPlatform, $found[$platform][$type]))
					$found[$platform][$type][] = $otherPlatform;
			}
		}
	}
	foreach ($allAlternates as $type => $altData) {
		if (array_key_exists($platform, $altData)) {
			$otherPlatform = $allAlternates[$type][$platform];
			if (!array_key_exists('local', $allPlatforms[$type][$otherPlatform]))
				$allPlatforms[$type][$otherPlatform]['local'] = [];
			if (!in_array($platform, $allPlatforms[$type][$otherPlatform]['local']))
				$allPlatforms[$type][$otherPlatform]['local'][] = $platform;
			if (!array_key_exists($platform, $found))
				$found[$platform] = [];
			if (!array_key_exists($type, $found[$platform]))
				$found[$platform][$type] = [];
			if (!in_array($otherPlatform, $found[$platform][$type]))
				$found[$platform][$type][] = $otherPlatform;
		}
	}
}
echo "Writng Platforms and Updated Source Exports\n";
file_put_contents($sourceDir.'/../platforms.json', json_encode($found, JSON_PRETTY_PRINT));

file_put_contents($sourceDir.'/launchbox.json', json_encode($allPlatforms['launchbox'], JSON_PRETTY_PRINT));
file_put_contents($sourceDir.'/thegamesdb.json', json_encode($allPlatforms['thegamesdb'], JSON_PRETTY_PRINT));
file_put_contents($sourceDir.'/tosec.json', json_encode($allPlatforms['tosec'], JSON_PRETTY_PRINT));
file_put_contents($sourceDir.'/nointro.json', json_encode($allPlatforms['nointro'], JSON_PRETTY_PRINT));
file_put_contents($sourceDir.'/redump.json', json_encode($allPlatforms['redump'], JSON_PRETTY_PRINT));
file_put_contents($sourceDir.'/mame.json', json_encode($allPlatforms['mame'], JSON_PRETTY_PRINT));
file_put_contents($sourceDir.'/oldcomputers.json', json_encode($allPlatforms['oldcomputers'], JSON_PRETTY_PRINT));
file_put_contents($sourceDir.'/screenscraper.json', json_encode($allPlatforms['screenscraper'], JSON_PRETTY_PRINT));
echo "done\n";