<?php

require_once __DIR__.'/../../bootstrap.php';


$token  = new \Tmdb\ApiToken($config['tmdb']['api_key']);
$client = new \Tmdb\Client($token);
$plugin = new \Tmdb\HttpClient\Plugin\LanguageFilterPlugin('en'); // Tries to fetch everything it can in english
$client->getHttpClient()->addSubscriber($plugin);
$plugin = new \Tmdb\HttpClient\Plugin\AdultFilterPlugin(true); // explicitly set this to true to show adult results
$client->getHttpClient()->addSubscriber($plugin);



$prefix = 'http://s2.tinydl.info/Series/';
$gb = 1024 * 1024 * 1024;
$tb = 1024 * 1024 * 1024 * 1024;
$lines = explode("\n", trim(file_get_contents('matches.txt')));
$dirs = [];
$result = $client->getGenresApi()->getGenres();
$genres = [];
foreach ($result['genres'] as $resultData) {
    $genres[$resultData['id']] = $resultData['name'];
}
foreach ($lines as $line) {
    list($title, $key) = explode(':', $line);
    $title = str_replace('_', ' ', $title);
    echo "Working on {$title}\n";
    $sizes=explode("\n", trim(`grep "${key}" tinydl.txt|awk '{ print $1 }'`));
    $dirfiles = [];
    $cmd = 'grep "'.$key.'" tinydl.txt|sed s#"^ *\([0-9]*\)  *\([^/]*\)/\(.*\)$"#"\1:\3"#g';
    $files = explode("\n", trim(`$cmd`));
    foreach ($files as $fileData) {
        list($size, $name) = explode(':', $fileData);
        $dirfiles[$name] = $size;
    }
    $dir = [
        'name' => $title, 
        'count' => count($sizes), 
        'size' => array_sum($sizes),
        'hash_name' => $key, 
        'prefix' => $prefix . $key . '/',
    ];
    $result = $client->getSearchApi()->searchTv($title);
    if ($result['total_results'] > 0) {
        $result = $result['results'][0];
        $genreIds = $result['genre_ids'];
        unset($result['genre_ids']);
        $result['genres'] = [];
        foreach ($genreIds as $genreId) {
            $result['genres'][] = $genres[$genreId];
        }
        $result['genres'] = implode(',', $result['genres']);
        $result['country'] = implode(',', $result['origin_country']);
        unset($result['origin_country']);
        $result['language'] = $result['original_language'];
        unset($result['original_language']);
        $dir['tvdb_id'] = $result['id'];
        unset($result['id']); 
        $dir = array_merge($dir, $result);
    }
    $result = $client->getTvApi()->getTvshow(1396);
    $dir['files'] = $dirfiles;
    $dirs[] = $dir;
}
file_put_contents('tinydl.json', json_encode($dirs, JSON_PRETTY_PRINT));
