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
echo 'Discovering Computer URLs starting with ';

$letters = ['0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
global $computerUrls;
$computerUrls = [];
foreach ($letters as $letter) {
    echo $letter;
    $crawler = $client->request('GET', 'http://www.old-computers.com/museum/name.asp?st=1&l='.$letter);
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
$db->query("truncate oldcomputers_platforms");
$platforms = [];
$countComputers = count($computerUrls);
foreach ($computerUrls as $idx => $url) {
    $crawler = $client->request('GET', 'http://www.old-computers.com/museum/'.$url);
    $cols = [];
    $urlParts = parse_url($url);
    $query = explode('&', $urlParts['query']);
    foreach ($query as $queryPart) {
        list($key, $value) = explode('=', $queryPart);
        $cols[$types[$key]] = $value;
    }
    $key = false;
    $value = false;
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
}
echo PHP_EOL.'done!'.PHP_EOL;
file_put_contents('/storage/data/json/oldcomputers/platforms.json', json_encode($platforms, JSON_PRETTY_PRINT));
//echo PHP_EOL;
