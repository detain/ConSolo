<?php
include 'vendor/autoload.php';
$db = new Workerman\MySQL\Connection('127.0.0.1', '3306', 'consolo', 'consolo', 'consolo');
$files = json_decode(file_get_contents('/storage/data/files.json'), true);
echo count($files).' json records loaded'.PHP_EOL;
$count = 0;
$maxPath = 0;
$temp = $db->query("select * from files");
$paths = [];
foreach ($temp as $data)
    $paths[$data['path']] = $data['id'];
unset($temp); 
foreach ($files as $path => $data) {
	if (strlen($path) > $maxPath) {
		$maxPath = strlen($path);
		echo "new max path: $maxPath\n";
	}
    if (array_key_exists($path, $paths)) {
        continue;
    }
    if (!isset($data['size']) || is_null($data['size'])) {
        unset($files[$path]);
        continue;
    }
	foreach (['md5','sha1','crc32'] as $field) {
		if (!isset($data[$field]))
			$data[$field] = null;
	}
    $values = [
        'path' => $path,
        'size' => $data['size'],
        'mtime' => $data['mtime'],
        'md5' => isset($data['md5']) ? $data['md5'] : null,
        'sha1' => isset($data['sha1']) ? $data['sha1'] : null,
        'crc32' => isset($data['crc32']) ? $data['crc32'] : null,
        //'parent' => null,
    ];
    try {
        $db->insert('files')->cols($values)->query();
    } catch (\PDOException $e){
        echo "Caught PDO Exception!".PHP_EOL;
        echo "Values: ".var_export($values, true).PHP_EOL;
        echo "Message: ".$e->getMessage().PHP_EOL;
        echo "Code: ".$e->getCode().PHP_EOL;
        echo "File: ".$e->getFile().PHP_EOL;
        echo "Line: ".$e->getLine().PHP_EOL;
        echo "Trace: ".$e->getTraceAsString().PHP_EOL;
    }
	$count++;
	if ($count % 1000 == 0)
		echo $count.', ';
}
echo 'done'.PHP_EOL;

