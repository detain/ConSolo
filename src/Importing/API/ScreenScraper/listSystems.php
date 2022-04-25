<?php
$systems = json_decode(file_get_contents('systems.json'), true);
$out = [];
foreach ($systems as $system) {
	$system['compagnie'] = $system['compagnie'] ?? 'Unknown';
	if (!array_key_exists($system['compagnie'], $out))
		$out[$system['compagnie']] = [];
	$out[$system['compagnie']][] = $system['noms']['nom_us'] ?? $system['noms']['nom_eu'];
//	echo $system['compagnie'].'	'.json_encode($system['noms']).PHP_EOL;
}
ksort($out);
print_r($out);
