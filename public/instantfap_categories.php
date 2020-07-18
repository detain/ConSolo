<?php
$pageSize = 50;
$allFilters = ['gif', 'webm', 'static'];
$filters = ['gif', 'webm', 'static'];
$sorts = ['popular', 'newest', 'hottest', 'random'];
$sort = 'newest';
$categories = [];
$images = [];
$cacheDir = '/storage/data/json/instantfap/';
$html = `curl -s "http://instantfap.com/loadNormalCategoriesSidebar.php?sortBy=alphabetical"`;
preg_match_all('/<a href=.*\/category\/(?P<category>[^"]*)">.<div[^\n]*title="(?P<title>[^"]*)">.<[^>]*>.<div class="name">(?P<name>[^<]*)<\/div><div class="counter">(?P<counter>[^<]*)<\/div>/msUu', $html, $matches);
foreach ($matches['category'] as $idx => $category) {
	$categories[trim($matches['name'][$idx])] = [
		'category' => trim($category),
		'title' => trim($matches['title'][$idx]),
		'counter' => intval(str_replace("'", '', trim($matches['counter'][$idx]))),
	];
}
file_put_contents($cacheDir.'categories.json', json_encode($categories, JSON_PRETTY_PRINT));
foreach ($categories as $name => $cat) {
    $images[$name] = [];
    $end = false;
    $offset = 0;
    while ($end === false) {
	    $url = 'http://instantfap.com/load.php?category='.$name.'&count='.$offset.'&q=&contentFilters='.implode(',', $filters).'&contentSort='.$sort;
        $cacheFile = $name.'-'.implode('-',$filters).'-'.$sort.'-'.$offset;
        if (file_exists($cacheDir.'pages/'.$cacheFile)) {
            //echo 'Getting '.$name.' - '.implode(',', $filters).' - '.$sort.' - '.$offset.'/'.$cat['counter'].' - Cached';
            $html = file_get_contents($cacheDir.'pages/'.$cacheFile);
        } else {
            echo 'Getting '.$name.' - '.implode(',', $filters).' - '.$sort.' - '.$offset.'/'.$cat['counter'].' - Live';
            $html = `curl -s "$url"`;
            eval("\$html = $html;");
            file_put_contents($cacheDir.'pages/'.$cacheFile, $html);
        }
	    $json = json_decode($html, true);
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                //echo ' - Good'.PHP_EOL;
                break;
            case JSON_ERROR_DEPTH:
                echo ' - Maximum stack depth exceeded (file '.$cacheFile.')'.PHP_EOL;
                unlink($cacheDir.'pages/'.$cacheFile);
                break;
            case JSON_ERROR_STATE_MISMATCH:
                echo ' - Underflow or the modes mismatch (file '.$cacheFile.')'.PHP_EOL;
                unlink($cacheDir.'pages/'.$cacheFile);
                break;
            case JSON_ERROR_CTRL_CHAR:
                echo ' - Unexpected control character found (file '.$cacheFile.')'.PHP_EOL;
                unlink($cacheDir.'pages/'.$cacheFile);
                break;
            case JSON_ERROR_SYNTAX:
                echo ' - Syntax error, malformed JSON (file '.$cacheFile.')'.PHP_EOL;
                unlink($cacheDir.'pages/'.$cacheFile);
                break;
            case JSON_ERROR_UTF8:
                echo ' - Malformed UTF-8 characters, possibly incorrectly encoded (file '.$cacheFile.')'.PHP_EOL;
                unlink($cacheDir.'pages/'.$cacheFile);
                break;
            default:
                echo ' - Unknown error (file '.$cacheFile.')'.PHP_EOL;
                unlink($cacheDir.'pages/'.$cacheFile);
                break;
        }
	    if (is_array($json)) {
		    foreach ($json as $idx => $data) {
			    $images[$name][] = $data;
		    }
		    if (count($json) < $pageSize) {
			    $end = true;
		    }
	    }
	    $offset += $pageSize;
    }
    echo 'Wrtiting '.$name.' images to images-'.$name.'.json'.PHP_EOL;
    file_put_contents($cacheDir.'images-'.$name.'.json', json_encode($images[$name], JSON_PRETTY_PRINT));
    $imageCount = count($images[$name]);
    if ($categories[$name]['counter'] != $imageCount) {
        echo "Setting {$name} Counter from {$categories[$name]['counter']} to {$imageCount}\n";
        $categories[$name]['counter'] = $imageCount;
    }
}
echo 'Wrtiting All images to images.json'.PHP_EOL;
file_put_contents($cacheDir.'images.json', json_encode($images, JSON_PRETTY_PRINT));