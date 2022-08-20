<?php
/**
* grabs latest TheGamesDB data and updates db
*/

require_once __DIR__.'/../bootstrap.php';

use FuzzyWuzzy\Fuzz;
use FuzzyWuzzy\Process;

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$mediaTypes = json_decode(file_get_contents(__DIR__.'/mame_media_types.json'), true);
$useAlternates = false;
$alternates = [];
$names = [];
$namesAssoc = [];
$rows = $db->query("select name from launchbox_platforms");
foreach ($rows as $idx => $row) {
	$description = $row['name'];
	$names[] = $description;
	$namesAssoc[] = [
		'name' => $description
	];
	$rows[$idx]['name'] = $description;
}
if ($useAlternates == true) {
	$rows = $db->query("select Name as name, Alternate as alternate from launchbox_platformalternatenames");
	foreach ($rows as $idx => $row) {
		$names[] = $row['alternate'];
		$namesAssoc[] = [
			'name' => $row['alternate']
		];
		$alternates[$row['alternate']] = $row['name'];
	}
}
$fuse = new \Fuse\Fuse($namesAssoc, ['keys' => ['name']]);
$fuzz = new Fuzz();
$process = new Process($fuzz);
$rows = $db->query("select platform, platform_description from mame_software group by platform");
$maxResults = 10;
$done = [];
foreach ($rows as $idx => $row) {
	$scores = [];
	$description = $row['platform_description'];
	foreach ($mediaTypes as $type) {
		$description = preg_replace('/ *'.preg_quote($type, '/').'$/i', '', $description);
	}
	if (in_array($description, $done)) {
		continue;
	}
	echo $description."\n";
	$done[] = $description;
	$out = [];
	$results = $fuse->search($description);
	foreach ($results as $idx => $data) {
		if ($useAlternates == true && isset($alternates[$data['name']])) {
			$out[] = $data['name'] .' ('.$alternates[$data['name']].')';
		} else {
			$out[] = $data['name'];
		}
		$scores[$data['name']] = (isset($scores[$data['name']]) ? $scores[$data['name']] : 0) + ceil(100 - ($idx * (100 / count($results))));
	}
	if (count($out) > 0) {
		echo '      Fuse:'.implode(', ', $out).PHP_EOL;
	}
	$c = $process->extract($description, $names);
	$results = $c->toArray();
	$out = [];
	foreach ($results as $idx => $data) {
		if ($useAlternates == true && isset($alternates[$data[0]])) {
			$out[] = $data[0].' ('.$alternates[$data[0]].')'.' ('.$data[1].'%)';
		} else {
			$out[] = $data[0].' ('.$data[1].'%)';
		}
		$scores[$data[0]] = (isset($scores[$data[0]]) ? $scores[$data[0]] : 0) + $data[1];
		if ($idx >= $maxResults) {
			break;
		}
	}
	if (count($out) > 0) {
		echo '      Fuzzy:'.implode(', ', $out).PHP_EOL;
	}
	$levs = [];
	foreach ($names as $name) {
		$levs[$name] = levenshtein($description, $name);
		//$scores[$name] = (isset($scores[$name]) ? $scores[$name] : 0) + (100 - ($levs[$name] * 15));
	}
	$levValues = array_values($levs);
	$levValues = array_unique($levValues);
	sort($levValues);
	reset($levValues);
	$found = 0;
	$foundResults = 0;
	$out = [];
	foreach ($levValues as $levValue) {
		$found++;
		foreach ($levs as $name => $value) {
			if ($value == $levValue) {
				$foundResults++;
				if ($useAlternates == true && isset($alternates[$name])) {
					$out[] = $name.' ('.$alternates[$name].')'.' ('.$value.')';
				} else {
					$out[] = $name.' ('.$value.')';
				}
				$scores[$name] = (isset($scores[$name]) ? $scores[$name] : 0) + (100 - ($found * 10 + $value));
				if ($foundResults >= $maxResults) {
					break;
				}
			}
		}
		if ($found >= 5 || $foundResults >= $maxResults) {
			break;
		}
	}
	echo '      Levenshtein:'.implode(', ', $out).PHP_EOL;
	$rows[$idx]['platform_description'] = $description;
	/*
	$scoreValues = array_values($scores);
	$scoreValues = array_unique($scoreValues);
	rsort($scoreValues);
	reset($scoreValues);
	$found = 0;
	$foundResults = 0;
	$out = [];
	foreach ($scoreValues as $scoreValue) {
		$found++;
		foreach ($scores as $name => $value) {
			if ($value == $scoreValue) {
				$foundResults++;
				$out[] = $name.' ('.$value.')';
				if ($foundResults >= $maxResults) {
					break;
				}
			}
		}
		if ($found >= 5 || $foundResults >= $maxResults) {
			break;
		}
	}
	echo '      Overall:'.implode(', ', $out).PHP_EOL;
	*/
}