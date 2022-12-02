#!/usr/bin/env php
<?php
$xml = file_get_contents('gamelist.xml');
$xml = preg_replace('/(<path>\.\/Games\/)([^\/<]*)(\/?[^<]*\.[rw][pu]x<\/path>[\s\n]*<name>)([^<]*)(<\/name>)/', '$1$2$3$2$5', $xml);
$xml = preg_replace('/(<name>[^<]*) \[\w{16}\]([^<]*<\/name>)/', '$1$2', $xml);
file_put_contents('gamelist.xml', $xml);