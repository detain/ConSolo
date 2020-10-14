<?php
`wget -q "https://www.tosecdev.org/downloads/category/50-2020-07-29?download=99:tosec-dat-pack-complete-3036-tosec-v2020-07-29" -O tosec.zip;unzip -qq -o -d tosec tosec.zip;rm -f tosec.zip;`;
$platforms = [];
foreach (['TOSEC', 'TOSEC-ISO'] as $type) {
	preg_match_all('/mkdir "(?P<manufacturer>[^\\\\"]+)\\\\(?P<name>[^\\\\"]+)[\\\\"].*$/muU', file_get_contents('tosec/Scripts/create folders/'.$type.'_folders.bat'), $matches);
	foreach ($matches['manufacturer'] as $idx => $manufacturer) {
		if (!array_key_exists($manufacturer, $platforms))
			$platforms[$manufacturer] = [];
		if (!in_array($matches['name'][$idx], $platforms[$manufacturer]))
			$platforms[$manufacturer][] = $matches['name'][$idx];
	}
}
`rm -rf tosec;`;
echo json_encode($platforms, JSON_PRETTY_PRINT);