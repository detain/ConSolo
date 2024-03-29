<?php
require_once __DIR__.'/../bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db, $mysqlLinkId;
$sourceDir = __DIR__.'/../../../emurelation/sources';
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
file_put_contents($sourceDir.'/launchbox.json', json_encode($allPlatforms['launchbox'], getJsonOpts()));

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
file_put_contents($sourceDir.'/thegamesdb.json', json_encode($allPlatforms['thegamesdb'], getJsonOpts()));

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
file_put_contents($sourceDir.'/tosec.json', json_encode($allPlatforms['tosec'], getJsonOpts()));

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
file_put_contents($sourceDir.'/nointro.json', json_encode($allPlatforms['nointro'], getJsonOpts()));

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
file_put_contents($sourceDir.'/redump.json', json_encode($allPlatforms['redump'], getJsonOpts()));

// MAME
echo "Building MAME Platforms\n";
$mediaTypes = json_decode(file_get_contents('mame_media_types.json'), true);
function mameMediaSort($a, $b) {
	return mb_strlen($b) <=> mb_strlen($a);
}
usort($mediaTypes, 'mameMediaSort');
file_put_contents('mame_media_types.json', json_encode($mediaTypes, getJsonOpts()));

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
file_put_contents($sourceDir.'/mame.json', json_encode($allPlatforms['mame'], getJsonOpts()));

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
file_put_contents($sourceDir.'/oldcomputers.json', json_encode($allPlatforms['oldcomputers'], getJsonOpts()));

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
	foreach (['recalbox', 'retropie', 'hyperspin', 'launchbox'] as $nameSuffix) {
		if (isset($json['name_'.$nameSuffix])) {
			$names = explode(',', $json['name_'.$nameSuffix]);
			foreach ($names as $name) {
				$alternates[$name] = $platform;
			}
		}
	}
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
file_put_contents($sourceDir.'/screenscraper.json', json_encode($allPlatforms['screenscraper'], getJsonOpts()));

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
file_put_contents($sourceDir.'/local.json', json_encode(array_keys($allPlatforms['local'], getJsonOpts()), getJsonOpts()));

//file_put_contents($sourceDir.'/alternatives.json', json_encode($allAlternates, getJsonOpts()));
//file_put_contents($sourceDir.'/platforms.json', json_encode($allPlatforms, getJsonOpts()));

echo "Building Platform Matches\n";
$found = [];
$links = [];
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
				if (!array_key_exists($type, $links))
					$links[$type] = [];
				if (!in_array($otherPlatform, $found[$platform][$type])) {
					$found[$platform][$type][] = $otherPlatform;
					$links[$type][] = ['from' => $platform, 'to' => $otherPlatform];
				}
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
			if (!array_key_exists($type, $links))
				$links[$type] = [];
			if (!in_array($otherPlatform, $found[$platform][$type])) {
				$found[$platform][$type][] = $otherPlatform;
				$links[$type][] = ['from' => $platform, 'to' => $otherPlatform];
			}
		}
	}
}
echo "Writng Platforms and Updated Source Exports\n";
file_put_contents($sourceDir.'/../platforms.json', json_encode($found, getJsonOpts()));
$sources = [
	'local' => 'Master List',
	'tosec' => 'TOSEC',
	'nointro' => 'No-Intro',
	'redump' => 'Redump',
	'mame' => 'MAME',
	'launchbox' => 'LaunchBox',
	'thegamesdb' => 'TheGamesDB',
	'screenscraper' => 'ScreenScraper.fr',
	'oldcomputers' => 'Old-Computers.com',
];
$platformCounts = [];
$matchedCounts = [];
$unmatched = [];
$mdTable = [];
$mdTable[] = '| Source | Platforms | Matched | Missing | % Completed |';
$mdTable[] = '|--|--|--|--|--|';
$linker = ['lists' => [], 'links' => $links];
foreach ($sources as $sourceType => $sourceName) {
	$platformCounts[$sourceType] = 0;
	$matchedCounts[$sourceType] = 0;
	$unmatched[$sourceType] = [];
	foreach ($allPlatforms[$sourceType] as $platform => $data) {
		$platformCounts[$sourceType]++;
		if (isset($data['local']) && count($data['local']) > 0)
			$matchedCounts[$sourceType]++;
		else
			$unmatched[$sourceType][] = $platform;
	}
	$missing = $platformCounts[$sourceType] - $matchedCounts[$sourceType];
	$percent = round(($matchedCounts[$sourceType] / $platformCounts[$sourceType]) * 100, 1);
	$mdTable[] = '| '.$sources[$sourceType].' | '.$platformCounts[$sourceType].' | '.$matchedCounts[$sourceType].' | '.$missing.' | '.$percent.'% |';
	$list = ['name' => $sourceName, 'list' => array_keys($allPlatforms[$sourceType])];
	$linker['lists'][$sourceType] = $list;
	file_put_contents($sourceDir.'/'.$sourceType.'.json', json_encode($allPlatforms[$sourceType], getJsonOpts()));
}
$readme = file_get_contents($sourceDir.'/../README.md');
preg_match_all('/\| Source.*$\n(\|.*$\n)+^$/muU', $readme, $matches);
$readme = str_replace($matches[0], implode("\n", $mdTable), $readme);
file_put_contents($sourceDir.'/../README.md', $readme);
file_put_contents($sourceDir.'/../unmatched.json', json_encode($unmatched, getJsonOpts()));
file_put_contents($sourceDir.'/../linker.json', json_encode($linker, getJsonOpts()));
echo "done\n";
