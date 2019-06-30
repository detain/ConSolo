<?php
echo `rm /storage/vault0/roms/MAME/*;`;
$data = json_decode(file_get_contents('/storage/json/mame/software.json'),true);

foreach ($data['softwarelists']['softwarelist'] as $idx => $value) {
	$value['description'] = str_replace(['/'], ['-'], $value['description']);
	if (file_exists("/storage/vault8/roms/MAME/MAME 0.209 Software List ROMs (split)/{$value['name']}")) {
		echo `ln -s "../../../vault8/roms/MAME/MAME 0.209 Software List ROMs (split)/{$value['name']}" "/storage/vault0/roms/MAME/{$value['description']}";`;
	} else {
		echo "Missing {$value['name']} - {$value['description']}\n"; 
	}
}
