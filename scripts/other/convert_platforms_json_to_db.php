<?php
include '/storage/ConSolo/src/bootstrap.php';
$platforms = json_decode(file_get_contents('/storage/ConSolo/json/platforms.json'), true);
$db->query("delete from platforms");
$db->query("truncate platform_matches");
$db->query("alter table platforms auto_increment = 1;");
foreach ($platforms as $platform => $data) {
	$id = $db->insert('platforms')->cols(['name' => $platform])->query();
	foreach ($data as $name => $types) {
		foreach ($types as $type) {
			$db->insert('platform_matches')->cols(['platform_id' => $id, 'name' => $name, 'type' => $type])->query();
		}
	}
}

