<?php
$invalid = ['Magazines', 'Newsletters', 'Manuals', 'Books', 'Commercials', 'Comics', 'Video', 'Catalogs', 'Artbooks', 'Game Guides', 'TV Series'];
//`wget -q "https://www.tosecdev.org/downloads/category/50-2020-07-29?download=99:tosec-dat-pack-complete-3036-tosec-v2020-07-29" -O tosec.zip;unzip -qq -o -d tosec tosec.zip;rm -f tosec.zip;`;
$platforms = [];
foreach (['TOSEC', 'TOSEC-ISO', 'TOSEC-PIX'] as $type) {
	preg_match_all('/mkdir "(?P<manufacturer>[^\\\\"]+)\\\\(?P<name>[^\\\\"]+)[\\\\"].*$/muU', file_get_contents('tosec/Scripts/create folders/'.$type.'_folders.bat'), $matches);
	foreach ($matches['manufacturer'] as $idx => $manufacturer) {
		$platform = $matches['name'][$idx];
		if (in_array($platform, $invalid))
			continue;
		if (!array_key_exists($manufacturer, $platforms))
			$platforms[$manufacturer] = [];
		if (!in_array($platform, $platforms[$manufacturer]))
			$platforms[$manufacturer][] = $platform;
	}
}
//`rm -rf tosec;`;
echo json_encode($platforms, JSON_PRETTY_PRINT);