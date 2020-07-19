<?php

use pxgamer\YTS\Movies;

require_once __DIR__.'/../../../yts/vendor/autoload.php';
require_once __DIR__.'/inc.php';

function obj2arr( $obj, $nestLevel = 0 ) {
    if ($nestLevel > 15) return;                // limit nesting level (for performance and not to go over the maximum)
    if (is_object($obj)) $obj = (array)$obj;    // if current member is an object - turn it to an array
    if (is_array($obj)) {                       // if current member is an array - recursively call this function to each of his children
        $return = [];
        foreach( $obj as $key => $val ) {
            $aux = explode("\0", $key);         // correct private and protected key names
            $newkey = $aux[count($aux) - 1];
            $return[$newkey] = obj2arr($val, $nestLevel + 1);
        }
    } else $return = $obj;
    return $return;                             // return transformed object
}

$yts = loadJson('yts');
$stillGettingResults = true;
$page = 1;
while ($stillGettingResults) {
    $failCount = 0;
    $needResults = true;
    while ($needResults) {
        try {
            $results = Movies::list([
                'quality'         => Movies::QUALITY_ALL,   // A quality constant
                'query_term'      => 0,                     // A query string, or 0 to ignore
                'page'            => $page,                 // An integer page number
                'minimum_rating'  => 0,                     // The minimum movie rating
                'genre'           => '',                    // A string containing the genre
                'sort_by'         => 'date-added',          // The sort-by order
                'order_by'        => 'desc',                // The direction to order by
                'with_rt_ratings' => true,                  // Returns the list with Rotten Tomatoes ratings
            ]);
            $needResults = false;
        } catch (\Exception $e) {
            $failCount++;
            sleep(5);
            echo 'Failed getting page '.$page.' '.$failCount.' times'.PHP_EOL;
            if ($failCount >= 3) {
                $needResults = false;
            }
        }
    }
    echo 'Got '.$results->count().' results on page '.$page.PHP_EOL;
    if ($results->count() == 0) {
        $stillGettingResults = false;
    } else {
        $results->each(function ($item, $key) use (&$yts) {
            $yts[$item->getId()] = obj2arr($item);
            /*
            $movie = Movies::details([
                'movie_id'    => $movieId,  // The ID of the movie to retrieve
                'with_images' => true, // Return with image URLs
                'with_cast'   => true, // Return with information about the cast        
            ]);
            $json[$item->getId()] = obj2arr($movie);
            */
        });
        $page++;
    }
    if ($page % 10 == 0) {
        putJson('yts', $yts);
    }
}
ksort($yts);
putJson('yts', $yts);
