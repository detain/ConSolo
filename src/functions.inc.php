<?php

function write_db() {
	file_put_contents(__DIR__.'/db.json', json_encode($GLOBALS['db'], JSON_PRETTY_PRINT));
}

function read_db() {
	global $db;
	$db = json_decode(file_get_contents(__DIR__.'/db.json'), true);
}

global $db;
read_db();
