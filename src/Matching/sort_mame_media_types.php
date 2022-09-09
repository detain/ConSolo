<?php
require_once __DIR__.'/../bootstrap.php';

// MAME
echo "Building MAME Platforms\n";
$mediaTypes = json_decode(file_get_contents('mame_media_types.json'), true);
function mameMediaSort($a, $b) {
	return mb_strlen($b) <=> mb_strlen($a);
}
usort($mediaTypes, 'mameMediaSort');
file_put_contents('mame_media_types.json', json_encode($mediaTypes, getJsonOpts()));

