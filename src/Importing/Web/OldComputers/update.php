<?php
/**
* parses data from old-computers.com
*/

require_once __DIR__.'/../../../bootstrap.php';


use Goutte\Client;

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$client = new Client();
/*
$letters = ['0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
global $computerUrls;
$computerUrls = [];
foreach ($letters as $letter) {
    $crawler = $client->request('GET', 'http://www.old-computers.com/museum/name.asp?st=1&l='.$letter);
    $crawler->filter('.petitnoir2 tr td center table tr td b a')->each(function ($node) {
        global $computerUrls;
        echo $node->html().': '.$node->attr('href').PHP_EOL;
        $href = $node->attr('href');
        if (!in_array($href, $computerUrls)) {
            $computerUrls[] = $href;
        }         
    });                                                    
}
file_put_contents('/storage/data/json/oldcomputers/urls.json', json_encode($computerUrls, JSON_PRETTY_PRINT));
*/
$computerUrls = json_decode(file_get_contents('/storage/data/json/oldcomputers/urls.json'), true);
global $tableKeys, $tableValues;
$types = ['st' => 'type_id', 'c' => 'computer_id'];
foreach ($computerUrls as $url) {
    $crawler = $client->request('GET', 'http://www.old-computers.com/museum/'.$url);
    $cols = [];
    $tableKeys = [];
    $tableValues = [];
    $urlParts = parse_url($url);
    $query = explode('&', $urlParts['query']);
    foreach ($query as $queryPart) {
        list($key, $value) = explode('=', $queryPart);
        echo "Key: $key\n";
        $cols[$types[$key]] = $value;
    }
    $cols['notes'] = $crawler->filter('.petitnoir2 tr td table tr td p.petitnoir')->html();
    $crawler->filter('.petitnoir2 tr td table tr td table tr td.petitnoir2:even b')->each(function ($node) {
        global $tableKeys;
        $tableKeys[] = strtolower(str_replace(['/',' '],['','_'],trim(html_entity_decode($node->html()))));
    });
    $key = false;
    $value = false;
    $crawler->filter('.petitnoir2 tr td table tr td table tr td.petitnoir2')->each(function ($node) use (&$cols, &$key, &$value) {
        if ($key === false) {
            $key = strtolower(str_replace(['/',' '],['','_'],trim(html_entity_decode($node->filter('b')->html()))));
        } elseif ($value === false) {
            $value = $node->html();
            $cols[$key] = $value;
        }
        global $tableValues;
        $tableValues[] = $node->html();
    });
    foreach ($tableKeys as $idx => $key) {
        $value = $tableValues[$idx];
        $cols[$key] = $value;
    }
    print_r($cols);
    exit;
}