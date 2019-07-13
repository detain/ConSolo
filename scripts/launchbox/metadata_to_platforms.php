<?php
$metadata = json_decode(file_get_contents('/storage/json/metadata/metadata.json'), true);
$platforms = json_decode(file_get_contents('/storage/json/data/Platforms.json'), true);
/*
$platformEntries = [];
foreach ($platforms['LaunchBox']['Platform'] as $idx => $data) {
	$platformEntries[$data['Name']] = $idx;
}
$folderPaths = [];
foreach ($platforms['LaunchBox']['PlatformFolder'] as $idx => $data) {
	$folderPaths[] = $data['Platform'];
}
foreach ($metadata['LaunchBox']['Platform'] as $idx => $data) {
	$data['Category'] = [];
	$data['Folder'] = [];
	$data['VideoPath'] = [];
	$data['LocalDbParsed'] = 'true';
	unset($data['Emulated']);
	unset($data['UseMameFiles']);
	if (array_key_exists($data['Name'], $platformEntries)) {
		$platforms['LaunchBox']['Platform'][$platformEntries[$data['Name']]] = $data;
	} else {
		$platforms['LaunchBox']['Platform'][] = $data;
		$platformEntries[$data['Name']] = count($platforms['LaunchBox']['Platform']) - 1;
	}
	if (!file_exists('/storage/frontends/LaunchBox/Images/'.$data['Name'])) {
		mkdir('/storage/frontends/LaunchBox/Images/'.$data['Name']);
	}
	if (!in_array($data['Name'], $folderPaths)) {
		foreach (['Advertisement Flyer - Back','Advertisement Flyer - Front','Arcade - Cabinet','Arcade - Circuit Board','Arcade - Control Panel','Arcade - Controls Information','Arcade - Marquee','Banner','Box - 3D','Box - Back','Box - Back - Reconstructed','Box - Front','Box - Front - Reconstructed','Cart - 3D','Cart - Back','Cart - Front','Clear Logo','Disc','Fanart - Background','Fanart - Box - Back','Fanart - Box - Front','Fanart - Cart - Back','Fanart - Cart - Front','Fanart - Disc','Screenshot - Game Over','Screenshot - Gameplay','Screenshot - Game Select','Screenshot - Game Title','Screenshot - High Scores','Steam Banner'] as $image) {
			$platforms['LaunchBox']['PlatformFolder'][] = ['MediaType' => $image, 'FolderPath' => 'Images\\'.$data['Name'].'\\'.$image, 'Platform' => $data['Name']];
		}
		$platforms['LaunchBox']['PlatformFolder'][] = ['MediaType' => 'Manual', 'FolderPath' => 'Manuals\\'.$data['Name'], 'Platform' => $data['Name']];
		$platforms['LaunchBox']['PlatformFolder'][] = ['MediaType' => 'Music', 'FolderPath' => 'Music\\'.$data['Name'], 'Platform' => $data['Name']];
		$platforms['LaunchBox']['PlatformFolder'][] = ['MediaType' => 'Video', 'FolderPath' => 'Videos\\'.$data['Name'], 'Platform' => $data['Name']];
		$platforms['LaunchBox']['PlatformFolder'][] = ['MediaType' => 'Theme Video', 'FolderPath' => 'Videos\\'.$data['Name'].'\\Theme', 'Platform' => $data['Name']];
	}
}
foreach ($platforms['LaunchBox']['PlatformFolder'] as $idx => $data) {
	$path = '/storage/frontends/LaunchBox/'.str_replace('\\', '/', $data['FolderPath']);
	if (!file_exists($path)) {
		echo "Making Path: '{$path}'\n";
		mkdir($path);
	}
}
file_put_contents('/storage/json/data/Platforms.json', json_encode($platforms, JSON_PRETTY_PRINT));
*/
$xml = '<?xml version="1.0" standalone="yes"?>
<LaunchBox>'.PHP_EOL;
foreach ($platforms['LaunchBox'] as $cat => $bigData) {
	foreach ($bigData as $idx => $catData) {
		$xml .= '  <'.$cat.'>'.PHP_EOL;
		foreach ($catData as $field => $fieldData) {
			if (!is_array($fieldData)) {
				$xml .= '    <'.$field.'>'.$fieldData.'</'.$field.'>'.PHP_EOL;
			} else {
				$xml .= '    <'.$field.' />'.PHP_EOL;
			}
		}
		$xml .= '  </'.$cat.'>'.PHP_EOL;
	}
}
$xml .= '</LaunchBox>'.PHP_EOL;
file_put_contents('/storage/frontends/LaunchBox/Data/Platforms.xml', $xml);
