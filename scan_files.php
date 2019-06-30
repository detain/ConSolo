<?php
$pathGlobs = ['/storage/vault*/roms'];
$hashAlgos = ['md5', 'sha1', 'crc32'];
$statFields = ['uid', 'gid', 'size', 'mtime'];


foreach (glob($pathGlobs) as $path) {
	if (is_dir($path)) {
		
	} else {
		$pathStat = stat($path);
		$fileData = [];
		foreach ($statFields as $statField) {
			$fileData[$statField] = $pathStat[$statField];
		}
		foreach ($hashAlgos as $hashAlgo) {
			$fileData[$hashAlgo] = hash_file($hashAlgo, $path);
		}
	}
}
