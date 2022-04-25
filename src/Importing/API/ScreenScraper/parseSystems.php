<?php

use Detain\ConSolo\Importing\API\ScreenScraper;

require_once __DIR__.'/../../../bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $config;
global $queriesRemaining;
global $dataDir;
global $curl_config;
$curl_config = [];
global $userInfo;
$json = json_decode(file_get_contents('systems.json'), true);
$systems = [];
foreach ($json as $data) {
	unset($data['medias']);
	$system = array_merge($data['noms'], $data);
	unset($system['noms']);
	$systems[] = $system;
}
print_r($systems);