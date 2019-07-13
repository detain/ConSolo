<?php
$agent = escapeshellarg('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36');
echo "Loading Page";
$index = escapeshellarg('https://datomatic.no-intro.org/index.php?page=redump');
if (file_exists('html.txt')) {
	$html = trim(file_get_contents('html.txt'));
} else {
	$html = trim(`wget -q --keep-session-cookies --save-cookies=cookies.txt -U {$agent} {$index} -O -`);
	file_put_contents('html.txt', $html);
}
echo "\nParsing HTML";
preg_match_all('/<form action="index.php\?page=redump&fun=download".*name="datset_id" value="([^"]*)"\/\>.*name="datset_page" value="([^"]*)"\/\>.*name="datset_date" value="([^"]*)"\/\>.*<\/form>/smuU', $html, $matches);
echo "\n".count($matches[0])." Download Links Parsed";
$submitUrl = escapeshellarg('https://datomatic.no-intro.org/index.php?page=redump&fun=download');
echo "CMd:\n";
foreach ($matches[0] as $idx => $form) {
	$id = $matches[1][$idx];
	$page = $matches[2][$idx];
	$date = $matches[3][$idx];
	$post = escapeshellarg(http_build_query([
        'Download' => 'ho-ho-ho', 
        'datset_id' => $id, 
        'datset_page' => $page, 
        'datset_date' => $date
    ]));
	$out = `curl -s {$submitUrl} -H 'Connection: keep-alive' -H 'Cache-Control: max-age=0' -H 'Origin: https://datomatic.no-intro.org' -H 'Upgrade-Insecure-Requests: 1' -H 'Content-Type: application/x-www-form-urlencoded' -H 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8' -H "Referer: {$index}" -H 'Accept-Encoding: gzip, deflate, br' -H 'Accept-Language: en-US,en;q=0.9,de;q=0.8' -H 'Cookie: PHPSESSID=eHBQ3v%2CwLfRG8cXUQ4tCS1' --compressed --data {$post};`;
	$csv= "/storage/dat/Redump CSV/{$page} - Dump Status ({$date}).csv";
	file_put_contents($csv, $out);
	echo "Wrote CSV $csv\n";
}
unlink('html.txt');
unlink('cookie.txt');
