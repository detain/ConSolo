<?php
require_once __DIR__.'/../../src/xml2array.php';
foreach (glob('/storage/Emulators/LaunchBox/Data/Platforms/*.xml') as $file) {
	echo 'Parsing '.$file.' on line '.__LINE__.PHP_EOL;
	$dir = dirname($file);
	$name = str_replace(' ','_', basename($file, '.xml'));
	$file = file_get_contents($file);
	echo 'Writing platforms_'.$name.'.json on line '.__LINE__.PHP_EOL;
	file_put_contents('platforms_'.$name.'.json', json_encode(xml2array($file,0), JSON_PRETTY_PRINT));
}
