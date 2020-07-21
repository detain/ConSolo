<?php
require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/inc.php';
$torrents = loadJson('torrentfiles');
$torrentPathInfos = [];
echo 'Mapping Torrent PathInfo Responses to Torrents';
foreach ($torrents as $torrentId => $torrentFiles) {
    foreach ($torrentFiles as $torrentFileFull => $torrentFileSize) {
        $torrentPathInfos[$torrentFileFull] = pathinfo($torrentFileFull);
    }
}
echo ' done'.PHP_EOL;
$yts = loadJson('yts');
$hashs = [];
echo 'Mapping Torrent hashes to YTS IDs';
foreach ($yts as $ytsId => $ytsData) {
    if (isset($ytsData['torrents']['items'])) {
        foreach ($ytsData['torrents']['items'] as $itemIdx => $itemData) {
            $hashs[$itemData['hash']] = $ytsId;
        }
    }
}
echo ' done'.PHP_EOL;
$files = loadJson('files');
$updates = 0;
foreach ($files as $fileFullName => $fileData) {
    if (!isset($fileData['torrent_id'])) {
        $pathInfo = pathinfo($fileFullName);
        echo $pathInfo['basename'].' ';
        $found = false;
        foreach ($torrents as $torrentId => $torrentFiles) {
            foreach ($torrentFiles as $torrentFileFull => $torrentFileSize) {
                $torrentPathInfo = $torrentPathInfos[$torrentFileFull];
                if ($torrentPathInfo['dirname'] == $pathInfo['filename']) {
                    $files[$fileFullName]['torrent_id'] = $torrentId;
                    $updates++;
                    $found = true;
                    echo '+D';
                } elseif ($torrentPathInfo['filename'] == $pathInfo['filename']) {
                    $files[$fileFullName]['torrent_id'] = $torrentId;
                    $updates++;
                    $found = true;
                    echo '+F';
                } elseif ($pathInfo['extension'] == 'srt') {
                    $fileName = preg_replace('/\]\.[a-zA-Z\.]+$/', ']', $pathInfo['basename']);
                    if ($torrentPathInfo['dirname'] == $fileName || $torrentPathInfo['filename'] == $fileName) {
                        $files[$fileFullName]['torrent_id'] = $torrentId;
                        $updates++;
                        $found = true;
                        echo '+S';
                    }
                } 
            }
        }
        if ($found == false) {
            echo '-';
        }
        echo PHP_EOL;
    }    
    if (isset($fileData['torrent_id']) && isset($hashs[$fileData['torrent_id']])) {
        $files[$fileFullName]['yts_id'] = $hashs[$fileData['torrent_id']];
        if (isset($yts[$files[$fileFullName]['yts_id']]['imdb_code'])) {
            $files[$fileFullName]['imdb_id'] = preg_replace('/^tt/', '', $yts[$files[$fileFullName]['yts_id']]['imdb_code']); 
        }
    }
}
echo 'done'.PHP_EOL;
echo 'Generated '.$updates.' Updates'.PHP_EOL;
putJson('files', $files);