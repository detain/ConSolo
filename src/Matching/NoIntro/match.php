<?php
/**
* grabs latest TheGamesDB data and updates db
*/

require_once __DIR__.'/../../src/bootstrap.php';


/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$mediaTypes = [
'(Title Updates)',
'(Download Play)',
'(Humble Bundle)',
'(Discontinued)',
'(Torrentzip)',
'(Split DLC)',
'(Encrypted)',
'(BigEndian)',
'(UMD Music)',
'(UMD Video)',
'(Decrypted)',
'(Combined)',
'(PSX2PSP)',
'(Digital)',
'(itch.io)',
'(Stream)',
'(Tapes)',
'(Desura)',
'(Steam)',
'(Misc)',
'(GOG)',
'(J64)',
'(WAD)',
'(FDS)',
'(PSN)',
'(VPK)',
'(CDN)',
'(PP)',
];
$rows = $db->query("select name from dat_files where type='No-Intro'");
foreach ($rows as $idx => $row) {
    $description = $row['name'];
    foreach ($mediaTypes as $type) {
        $description = preg_replace('/ *'.preg_quote($type, '/').'$/i', '', $description);
    }
    preg_match('/^(.*) - (.*)$/', $description, $matches);
    $manufacturer = $matches[1];
    $platform = $matches[2];
    echo $manufacturer.' '.$platform.PHP_EOL;
    $rows[$idx]['name'] = $description;
}