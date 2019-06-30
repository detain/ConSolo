#!/usr/bin/env php
<?php

require_once __DIR__.'/../src/xml2array.php';

foreach (['Files','Mame','Metadata'] as $name) {
	echo $name.'	reading..';
	$xml = file_get_contents('xml/'.$name.'.xml');
	echo 'read	parsing..';
	$array = xml2array($xml);
	echo 'parsed	writing..';
	$array = $array['LaunchBox'];
	foreach ($array as $type => $data) {
		echo $type.'('.count($data).') ';
		file_put_contents('json/'.$type.'.json', json_encode($data));
	}
	echo 'written'.PHP_EOL;
	//unlink($name.'.xml');
}
//print_r($array);
