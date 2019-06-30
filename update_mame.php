<?php
include __DIR__.'/xml2array.php';
function FlattenAttr(&$parent) {
    if (isset($parent['attr'])) {
        if (count($parent['attr']) == 2 && isset($parent['attr']['name']) && isset($parent['attr']['value'])) {
            $parent[$parent['attr']['name']] = $parent['attr']['value'];
            unset($parent['attr']);
        } else {
            foreach ($parent['attr'] as $attrKey => $attrValue) {
                $parent[$attrKey] = $attrValue;
            }
            unset($parent['attr']); 
        }
    }
}
function FlattenValues(&$parent) {
    foreach ($parent as $key => $value) {
        if (is_array($value) && count($value) == 1 && isset($value['value'])) {
            $parent[$key] = $value['value'];
        }
    }
}
function RunArray(&$data) {
    if (is_array($data)) {
        if (count($data) > 0) {
            if (isset($data[0])) {
                foreach ($data as $dataIdx => $dataValue) {
                    RunArray($dataValue);
                    $data[$dataIdx] = $dataValue;
                }
            } else {
                FlattenAttr($data);
                FlattenValues($data);
                foreach ($data as $dataIdx => $dataValue) {
                    RunArray($dataValue);
                    $data[$dataIdx] = $dataValue;
                }
            }
        }
    }
}
/*$txt = ['brothers', 'clones', 'crc', 'devices', 'full', 'media', 'roms', 'samples', 'slots', 'source'];
foreach ($txt as $list) {
    echo "Getting and Writing {$list} List   ";
    file_put_contents($list.'.txt', `mame -list{$list}`);
    echo "done\n";
}*/
$xml = ['software', 'xml'];
$dest = '/storage/json';
foreach ($xml as $list) {
	echo "Getting {$list} List   ";
    $xmlFile = $dest.'/mame-'.$list.'.xml';
    if (file_exists($xmlFile))
        $string = file_get_contents($xmlFile);
    else
        file_put_contents($xmlFile, $string = `mame -list{$list}`);
	echo "Parsing XML To Array   ";
	$array = xml2array($string, 1, 'attribute');
    unset($string);
    echo "Simplifying Array   ";
    RunArray($array);
	echo "Writing to JSON {$list}.json   ";
	file_put_contents($list.'.json', json_encode($array, JSON_PRETTY_PRINT));
	echo "done\n";
}
