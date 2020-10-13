<?php
/**
* grabs latest TheGamesDB data and updates db
*/
namespace Detain\ConSolo\Matching;

require_once __DIR__.'/../bootstrap.php';

use FuzzyWuzzy\Fuzz;
use FuzzyWuzzy\Process;

/**
* @var \Workerman\MySQL\Connection
*/
global $db;

$platforms = json_decode(file_get_contents(__DIR__.'/../../json/platforms.json'), true);
$platformMatches = [];
foreach (glob(__DIR__.'/*/match.php') as $file) {
	$matchType = basename(dirname($file));
	$return = include $file;
	$platformMatches[$matchType] = $return;
}
$newPlatforms = [];
foreach ($platforms as $platformIdx => $platformData) {
	$newPlatforms[$platformIdx] = [];
	foreach ($platformData as $realName => $matchTypes) {
		if (in_array('MAME', $matchTypes)) {
			$new = [];
			foreach ($matchTypes as $matchType) {
				if ($matchType != 'MAME')
					$new[] = $matchType; 
			}
			if (count($new) > 0) {
				$newPlatforms[$platformIdx][$realName] = $new;
			}
			foreach ($platformMatches['MAME'][$realName] as $new) {
				if (!isset($newPlatforms[$platformIdx][$new]))
					$newPlatforms[$platformIdx][$new] = [];
				$newPlatforms[$platformIdx][$new][] = 'MAME';
			}
		} else {
			$newPlatforms[$platformIdx][$realName] = $matchTypes;
		}
		foreach ($matchTypes as $matchType) {
			if ($matchType == 'MAME')
				continue;
			if (isset($platformMatches[$matchType]) && isset($platformMatches[$matchType][$realName])) {
				foreach ($platformMatches[$matchType][$realName] as $newName) {
					if (!isset($newPlatforms[$platformIdx][$newName]))
						$newPlatforms[$platformIdx][$newName] = [];
					$newPlatforms[$platformIdx][$newName][] = $matchType;
				}
			} else {
				if (!isset($newPlatforms[$platformIdx][$realName]))
					$newPlatforms[$platformIdx][$realName] = [];
				$newPlatforms[$platformIdx][$realName][] = $matchType;                
			}
		}
	}
}
$names = $newPlatforms;
$lines = [];
$keys = array_keys($names);
sort($keys);
reset($keys);
foreach ($keys as $idx) {
	$data = $names[$idx];
	$parts = [];
	foreach ($data as $file => $matchTypes) {
		$parts[] = '"'.$file.'": ["'.implode('", "', $matchTypes).'"]';         
	}
	$lines[] = '"'.$idx.'": { '.implode(', ', $parts).' }'; 
}
echo '{'.PHP_EOL.'    '.implode(','.PHP_EOL.'    ', $lines).PHP_EOL.'}'.PHP_EOL;
