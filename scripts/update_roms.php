<?php
`rm -rf /storage/roms; mkdir /storage/roms;`;
$paths = [
	'' => glob('/storage/vault*/roms/*'),
	' (No-Intro)' => glob('/storage/vault*/roms/No-Intro/No-Intro 2018/*'),
	' (TOSEC)' => glob('/storage/vault*/roms/TOSEC/TOSEC Main Branch (2018-12-27)/*'),
];
$vendors = [];
$systems = [];
foreach  ($paths as $type => $vendorDirs) {
	foreach ($vendorDirs as $vendorDir) {
		if (is_dir($vendorDir)) {
			$vendor = basename($vendorDir);
			if (!isset($vendors[$vendor])) {
				$vendors[$vendor] = [];
				$systems[$vendor] = [];
			}
			$vendors[$vendor][] = [$type, $vendorDir];
			foreach (glob($vendorDir.'/*') as $systemDir) {
				$system = basename($systemDir);
				if (!isset($systems[$vendor][$system])) {
					$systems[$vendor][$system] = [];
				}
				$systems[$vendor][$system][] = [$type, $systemDir];
			}
		}
	}
}
foreach ($vendors as $vendor => $vendorDirs) {
	if (count($vendorDirs) == 1) {
		$type = $vendorDirs[0][0];
		$vendorDir = $vendorDirs[0][1];
		symlink(preg_replace('/^\/storage\//msU', '../', $vendorDir), '/storage/roms/'.$vendor.$type);
		echo "Adding Vendor {$vendor}{$type}\n";
	} else {
		mkdir('/storage/roms/'.$vendor);
		foreach ($systems[$vendor] as $system => $systemDirs) {
			foreach ($systemDirs as $systemDir) {
				$type = $systemDir[0];
				$systemDir = $systemDir[1];
				symlink(preg_replace('/^\/storage\//msU', '../../', $systemDir), '/storage/roms/'.$vendor.'/'.$system.$type);
				echo "Adding System {$system}{$type}\n";
			}
		}
		//foreach ($vendorDirs as $vendorDir) {
		//	$type = $vendorDir[0];
		//	$vendorDir = $vendorDir[1];
		//}
	}
}

