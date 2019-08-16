<?php
/**
* parses data from old-computers.com
* 
* http://www.old-computers.com/museum/computer.asp?st=1&c=91
* 
* @todo detect emulators page and load+parse it
*/

require_once __DIR__.'/../../../bootstrap.php';


use Goutte\Client;

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$client = new Client();
$sitePrefix = 'http://www.old-computers.com/museum/';
echo 'Discovering Computer URLs starting with ';

$letters = ['0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
global $computerUrls;
$computerUrls = [];
foreach ($letters as $letter) {
    echo $letter;
    $crawler = $client->request('GET', $sitePrefix.'name.asp?st=1&l='.$letter);
    $crawler->filter('.petitnoir2 tr td center table tr td b a')->each(function ($node) {
        global $computerUrls;
        //echo $node->html().': '.$node->attr('href').PHP_EOL;
        $href = $node->attr('href');
        if (!in_array($href, $computerUrls)) {
            $computerUrls[] = $href;
        }         
    });                                                    
}
echo ' done'.PHP_EOL;
file_put_contents('/storage/data/json/oldcomputers/urls.json', json_encode($computerUrls, JSON_PRETTY_PRINT));
$computerUrls = json_decode(file_get_contents('/storage/data/json/oldcomputers/urls.json'), true);
echo 'Loading Computer URLs'.PHP_EOL;
$types = ['st' => 'type_id', 'c' => 'computer_id'];
$db->query("truncate oldcomputers_emulator_platforms");
$db->query("delete from oldcomputers_platforms");
$db->query("delete from oldcomputers_emulators");
$db->query("alter table oldcomputers_emulators auto_increment=1");
$db->query("alter table oldcomputers_platforms auto_increment=1");
$platforms = [];
$countComputers = count($computerUrls);
$allEmulators = [];
foreach ($computerUrls as $idx => $url) {
    $crawler = $client->request('GET', $sitePrefix.$url);
    $cols = [];
    $urlParts = parse_url($url);
    $query = explode('&', $urlParts['query']);
    foreach ($query as $queryPart) {
        list($key, $value) = explode('=', $queryPart);
        $cols[$types[$key]] = $value;
    }
    $key = false;
    $value = false;
    $emulators = false;
    $emuCrawler = $crawler->filter('a.button_emulators');
    if ($emuCrawler->count() != 0) {
        $emulators = $emuCrawler->first()->attr('href');
    }
    $crawler->filter('.petitnoir2 tr td table tr td table tr td.petitnoir2')->each(function ($node) use (&$cols, &$key, &$value) {
        $data = trim($node->html());
        if (substr($data, 0, 3) == '<b>') {
            $key = str_replace([' ','/','-','__'], ['_','','_','_'], strtolower(html_entity_decode(trim(preg_replace('/\s+/msuU', ' ', $node->text())))));
        } else {
            $value = trim($node->html());
            $cols[$key] = $value;
        }
    });
    $cols['notes'] = $crawler->filter('.petitnoir2 tr td table tr td p.petitnoir')->html();
    $cols['notes'] = trim(str_replace(['<br>',PHP_EOL.PHP_EOL.PHP_EOL,PHP_EOL.PHP_EOL],[PHP_EOL,PHP_EOL,PHP_EOL], $cols['notes']));
    //print_r($cols);
    echo '['.$idx.'/'.$countComputers.'] '.$cols['manufacturer'].' '.$cols['name'].' ';
    $platformId = $db->insert('oldcomputers_platforms')->cols($cols)->query();
    $platforms[$platformId] = $cols;
    if ($emulators !== false) {
        //$crawler = $client->request('GET', $sitePrefix.$emulators);
        //$html = $crawler->html();
        $html = trim(`curl -s "{$sitePrefix}{$emulators}"`);
        $html = str_replace("\r\n", "\n", $html);
        $html = utf8_encode($html);
        if (preg_match_all('/<table><tr><td width=40><img[^>]*alt="([^"]*) emulator"><\/td><td nowrap><a href="([^"]*)"[^>]*><b>([^<]*)<.*<p[^>]*>([^<]*)<\/td/muU', $html, $matches)) {
            foreach ($matches[1] as $idx => $hostPlatform) {
                if (!array_key_exists($matches[3][$idx], $allEmulators)) {
                    $emulator = [
                        'name' => $matches[3][$idx],
                        'url' => $matches[2][$idx],
                        'notes' => $matches[4][$idx],
                        'platforms' => [],
                        'hosts' => [],
                    ];
                    $allEmulators[$matches[3][$idx]] = $emulator; 
                }
                if (!in_array($hostPlatform, $allEmulators[$matches[3][$idx]]['hosts'])) {
                    $allEmulators[$matches[3][$idx]]['hosts'][] = $hostPlatform;
                }
                if (!in_array($platformId, $allEmulators[$matches[3][$idx]]['platforms']))
                    $allEmulators[$matches[3][$idx]]['platforms'][] = $platformId;
            }
            //echo 'Emulators '.count($emulators).PHP_EOL;
            echo PHP_EOL;
        } else {
            echo 'No Regex match on Emulators page for Emulators'.PHP_EOL;
        }
    }
}
echo PHP_EOL.'done!'.PHP_EOL;
echo 'Inserting Emulators into DB   ';
foreach ($allEmulators as $name => $emulator) {
    $emulator['host'] = implode(', ', $emulator['hosts']);
    $platforms = $emulator['platforms'];
    unset($emulator['platforms']);
    unset($emulator['hosts']);
    $emulatorId = $db->insert('oldcomputers_emulators')->cols($emulator)->query();
    foreach ($platforms as $platformId) {
        $db->insert('oldcomputers_emulator_platforms')->cols(['emulator' => $emulatorId, 'platform' => $platformId])->query();
    }
}
echo 'done!'.PHP_EOL;
file_put_contents('/storage/data/json/oldcomputers/platforms.json', json_encode($platforms, JSON_PRETTY_PRINT));
file_put_contents('/storage/data/json/oldcomputers/emulators.json', json_encode($allEmulators, JSON_PRETTY_PRINT));
//echo PHP_EOL;
