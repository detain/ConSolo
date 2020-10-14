<?php
`wget "https://www.tosecdev.org/downloads/category/50-2020-07-29?download=99:tosec-dat-pack-complete-3036-tosec-v2020-07-29" -O tosec.zip;unzip -o -d tosec tosec.zip;rm -f tosec.zip;`;
$cmd='grep mkdir "tosec/Scripts/create folders/TOSEC_folders.bat" "tosec/Scripts/create folders/TOSEC-ISO_folders.bat"|cut -d"\\"" -f2|cut -d"\\\\" -f1-2|uniq';
preg_match_all('/^(?P<manufacturer>.*)\\(?P<name>.*)$/muU', trim(`{$cmd}`), $matches);
`rm -rf tosec;`;
$platforms = [];
foreach ($matches['manufacturer'] as $idx => $manufacturer) {
	if (!array_key_exists($manufacturer, $platforms))
		$platforms[$manufacturer] = [];
	$platforms[$manufacturer][] = $matches['name'][$idx];
}
print_r($platforms);