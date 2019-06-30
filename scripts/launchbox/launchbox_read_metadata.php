#!/usr/bin/env php
<?php
$launchBox = [];
foreach (['Files','Mame','Metadata'] as $name) $launchBox[$name] = json_decode(file_get_contents($name.'.json'), true);
