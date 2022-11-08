<?php
/**
* grabs latest ScreenScraper.fr data and updates db
*/

use Detain\ConSolo\Importing\ScreenScraper;

require_once __DIR__.'/../../../bootstrap.php';

function translate($text) {
    $repl = [
        'BoitierConsole' => 'box',
        'vierge' => 'blank',
        'tranche' => 'slice',
        'gabarit' => 'template',
        'Accessoire' => 'Accessory',
        'Autres' => 'Others',
        'Console &amp; Arcade' => 'Console & Arcade',
        'Console Portable' => 'Portable Console',
        'Emulation Arcade' => 'Arcade Emulation',
        'Flipper' => 'Pinball',
        'Machine Virtuelle' => 'Virtual Machine',
        'Ordinateur' => 'Computer',
        'fichier' => 'file',
        'dossier' => 'folder',
        'disquette' => 'floppy',
        'cartouche' => 'cartridge',
        'carte' => 'card'
    ];
    foreach ($repl as $orig => $new) {
        if (strpos($text, $orig) !== false)
            $text = str_replace($orig, $new, $text);
    }
    return $text;
}

if (in_array('-h', $_SERVER['argv']) || in_array('--help', $_SERVER['argv'])) {
    die("Syntax:
    php ".$_SERVER['argv'][0]." <options>

Options:
    -h, --help  this screen
    -f          force update even if already latest version
    --no-db     skip the db updates/inserts
    --no-cache  disables use of the file cache

");
}
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $config;
global $queriesRemaining;
global $dataDir;
global $curl_config;
$curl_config = [];
$force = in_array('-f', $_SERVER['argv']);
$skipDb = in_array('--no-db', $_SERVER['argv']);
$usePrivate = false;
$useCache = !in_array('--no-cache', $_SERVER['argv']);;
$dataDir = __DIR__.'/../../../../data';
@mkdir($dataDir.'/json/screenscraper', 0775, true);
if (file_exists($dataDir.'/json/screenscraper/queries.json')) {
	$queriesRemaining = json_decode(file_Get_contents($dataDir.'/json/screenscraper/queries.json'), true);
} else {
	$queriesRemaining = ['yearmonth' => 0];
}
if (date('Ymd') > $queriesRemaining['yearmonth']) {
	$queriesRemaining['yearmonthday'] = date('Ymd');
	foreach ($config['ips'] as $ip) {
		$queriesRemaining[$ip] = 20000;
	}
}
if ($useCache == true && file_exists($dataDir.'/json/screenscraper/platforms.json')) {
	$platforms = json_decode(file_get_contents($dataDir.'/json/screenscraper/platforms.json'), true);
} else {
	$return = ScreenScraper::api('systemesListe');
	if ($return['code'] == 200) {
		//echo "Response:".print_r($return,true)."\n";
		$platforms = $return['response']['response']['systemes'];
		file_put_contents($dataDir.'/json/screenscraper/platforms.json', json_encode($platforms, getJsonOpts()));
		//print_r($platforms);
	}
}
$source = [
    'companies' => [],
    'platforms' => [],
    'emulators' => [
        'launchbox' => [
            'id' => 'launchbox',
            'name' => 'LaunchBox',
            'platforms' => [],
        ],
        'retropie' => [
            'id' => 'retropie',
            'name' => 'RetroPie',
            'platforms' => [],
        ],
        'recalbox' => [
            'id' => 'recalbox',
            'name' => 'RecalBox',
            'platforms' => [],
        ]
    ],
    'games' => []
];
$data = $source;
foreach ($platforms as $idx => $platform) {
    $id = intval($platform['id']);
    if (isset($platform['noms']['noms_commun']) && trim($platform['noms']['noms_commun']) != '') {
        $altNames = explode(',', trim($platform['noms']['noms_commun']));
    } else {
        $altNames = [];
    }
    $name = false;
    foreach (['nom_us', 'nom_eu', 'nom_jp'] as $field) {
        if ($name === false && isset($platform['noms'][$field])) {
            $name = $platform['noms'][$field];
        } elseif (isset($platform['noms'][$field]) && !in_array($platform['noms'][$field], $altNames)) {
            $altNames[] = $platform['noms'][$field];
        }
    }
    $source['platforms'][$id] = [
        'id' => $id,
        'name' => $name,
        'altNames' => $altNames
    ];
    $data['platforms'][$id] = [
        'id' => $id,
        'name' => $name,
        'altNames' => $altNames
    ];
    foreach (['type', 'romtype', 'supporttype'] as $field) {
        if (isset($platform[$field])) {
            $platform[$field] = translate($platform[$field]);
            $data['platforms'][$id][$field] = $platform[$field];
        }
    }
    if (isset($platform['compagnie'])) {
        $source['platforms'][$id]['company'] = $platform['compagnie'];
        $data['platforms'][$id]['company'] = $platform['compagnie'];
        $source['companies'][$platform['compagnie']] = [
            'id' => $platform['compagnie'],
            'name' => $platform['compagnie'],
        ];
        $data['companies'][$platform['compagnie']] = [
            'id' => $platform['compagnie'],
            'name' => $platform['compagnie'],
        ];
    }
    foreach (['launchbox', 'retropie', 'recalbox', 'hyperspin'] as $field) {
        if (isset($platform['noms']['nom_'.$field])) {
            $source['emulators'][$field]['platforms'][] = $id;
            $data['emulators'][$field]['platforms'][] = $id;
            if (!isset($source['platforms'][$platform['id']]['matches'])) {
                $source['platforms'][$id]['matches'] = [];
                $data['platforms'][$id]['matches'] = [];
            }
            if (!isset($source['platforms'][$platform['id']]['matches'][$field])) {
                $source['platforms'][$id]['matches'][$field] = [];
                $data['platforms'][$id]['matches'][$field] = [];
            }
            $matches = explode(',', trim($platform['noms']['nom_'.$field]));
            foreach ($matches as $matchPlatId) {
                $source['platforms'][$id]['matches'][$field][] = $matchPlatId;
                $data['platforms'][$id]['matches'][$field][] = $matchPlatId;
            }
        }
    }
    if (isset($platform['extensions']))
        $data['platforms'][$id]['ext'] = explode(',', $platform['extensions']);
    if (isset($platform['datedebut'])) {
        $data['platforms'][$id]['date_start'] = $platform['datedebut'];
    }
    if (isset($platform['datefin'])) {
        $data['platforms'][$id]['date_end'] = $platform['datefin'];
    }
    $regionPrio = ['us', 'uk', 'wor', 'eu'];
    $medias = [];
    foreach ($platform['medias'] as $media) {
        $media['type'] = translate($media['type']);
        if (!isset($medias[$media['type']])) {
            $medias[$media['type']] = [];
        }
        $url = html_entity_decode($media['url']);
        parse_str(parse_url($url)['query'], $result);
        $file = translate($result['media']).'.'.$media['format'];
        $dir = __DIR__.'/../../../../public/images/ScreenScraper/platforms/'.str_replace('/', '-', (isset($platform['compagnie']) ? $platform['compagnie'].' ' : '').$name);
        @mkdir($dir, 0777, true);
        //if (!file_exists($dir.'/'.$file) || md5_file($dir.'/'.$file) != $media['md5'])
        if (!file_exists($dir.'/'.$file)) {
            echo "File {$dir}/{$file} does not exist";
            exit;
            passthru("wget -nv '{$url}' -O '{$dir}/{$file}'");
        }
        $media['url'] = 'https://consolo.is.cc/images/ScreenScraper/platforms/'.str_replace('/', '-', (isset($platform['compagnie']) ? $platform['compagnie'].' ' : '').$name).$file;
        unset($media['format']);
        unset($media['parent']);
        unset($media['crc']);
        unset($media['md5']);
        unset($media['sha1']);
        $type = $media['type'];
        unset($media['type']);
        $medias[$type][] = $media;
    }
    $data['platforms'][$id]['media'] = $medias;
}
file_put_contents(__DIR__.'/../../../../../emulation-data/screenscraper.json', json_encode($data, getJsonOpts()));
$sources = json_decode(file_get_contents(__DIR__.'/../../../../../emurelation/sources.json'), true);
$sources['screenscraper']['updatedLast'] = time();
file_put_contents(__DIR__.'/../../../../../emurelation/sources.json', json_encode($sources, getJsonOpts()));
foreach ($source as $type => $data) {
    file_put_contents(__DIR__.'/../../../../../emurelation/'.$type.'/screenscraper.json', json_encode($data, getJsonOpts()));
}
if (!$skipDb) {
    echo "Mapping Platforms to db\n";
    $db->query('truncate ss_platforms');
    foreach ($platforms as $platform) {
	    $db->insert('ss_platforms')
	    ->cols(['doc' => json_encode($platform, getJsonOpts())])
	    ->query();
    }
}
