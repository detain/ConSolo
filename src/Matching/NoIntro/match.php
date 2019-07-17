<?php
/**
* grabs latest TheGamesDB data and updates db
*/

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
$return = [];
foreach ($rows as $idx => $row) {
    $description = $row['name'];
    foreach ($mediaTypes as $type) {
        $description = preg_replace('/ *'.preg_quote($type, '/').'$/i', '', $description);
    }
    preg_match('/^(.*) - (.*)$/', $description, $matches);
    $manufacturer = $matches[1];
    $platform = $matches[2];
    $description = $manufacturer.' '.$platform;
    if (!isset($return[$description]))
        $return[$description] = [];
    if (!in_array($description, $return[$description]))
        $return[$description][] = $row['name'];
    $rows[$idx]['name'] = $description;
}
unset($rows);
return $return;
