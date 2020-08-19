<?php
/**
* @link https://github.com/loilo/Fuse 
*/

require_once __DIR__.'/../../../bootstrap.php';

$fuseWeights = [
	"keys" => [
		["name" => "year", "weight" => 0.3],
		["name" => "title", "weight" => 0.7]
]];
$limit = 25000;
$offset = 0;
$end = false;
$fuseData = [];
echo "Loading TMDB starting at:";
while (!$end) {
	echo " $offset";
	$tempFiles = $db->query("select * from tmdb_movie limit $offset, $limit");
	foreach ($tempFiles as $idx => $data) {
		$doc = json_decode($data['doc'], true);
		$titles = [];
		$titles[] = $data['title'];
		if (isset($doc['original_title']) && !in_array($doc['original_title'], $titles))
			$titles[] = $doc['original_title'];
		$year = substr($data['release_date'], 0, 4);
		foreach ($titles as $title)
			$fuseData[] = [
				'id' => $data['id'],
				'title' => $data['title'],
				'year' => $year
			];
	}
	$offset += $limit;
	$end = count($tempFiles) < $limit;
}
echo '  done'.PHP_EOL;
echo 'caching data';
file_put_contents(__DIR__.'/../../../../data/json/tmdb_fuse.json', json_encode($fuseData, JSON_PRETTY_PRINT));
echo '  done'.PHP_EOL;
$fuse = new \Fuse\Fuse($fuseData, $fuseWeights);
$results = $fuse->search('hamil');
print_r($results);
