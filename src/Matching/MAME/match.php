<?php
/**
* grabs latest TheGamesDB data and updates db
*/

require_once __DIR__.'/../../bootstrap.php';


/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$mediaTypes = [
    '- Datach Joint ROM System mini-cartridges',
    '- Nantettatte!! Baseball mini-cartridges',
    '- Karaoke Studio expansion cartridges',
    '- Aladdin Deck Enhancer cartridges',
    'cleanly cracked 5.25 disks',
    '5.25 miscellaneous disks',
    'disk images (misc list)',
    'Hardware driver disks',
    'Master Compact disks',
    'SmartMedia Flash ROM',
    '5.25 original disks',
    '2nd Processor discs',
    'Digital Data Packs',
    'ROMPACK cartridges',
    '5.25 inch floppies',
    '(German) cassettes',
    'Co-Processor discs',
    'Application disks',
    'Master cartridges',
    'ROMPAK cartridges',
    'Master cassettes',
    'SmartMedia cards',
    'internal sockets',
    'Workbench disks',
    'mini-cartridges',
    'cartridge tapes',
    'snapshot images',
    'ROM extensions',
    'Original disks',
    'ROM expansions',
    'Function ROMs',
    'floppy images',
    'floppy disks',
    'memory cards',
    'ROM capsules',
    'Memory Packs',
    'System disks',
    'Option ROMs',
    'disk images',
    'disc images',
    'Master disks',
    'ROM images',
    'cartridges',
    '5.25 disks',
    '(US) disks',
    'quickloads',
    'hard disks',
    'diskettes',
    'cassettes',
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
    'disks',
    'ROMs',
    'ROM',
];
$rows = $db->query("select platform,platform_description from mame_software group by platform,platform_description");
foreach ($rows as $idx => $row) {
    $description = $row['platform_description'];
    foreach ($mediaTypes as $type) {
        $description = preg_replace('/ *'.preg_quote($type, '/').'$/i', '', $description);
    }
    echo $description."\n";
    $rows[$idx]['platform_description'] = $description;
}