<?php

require_once __DIR__.'/StringCompare.php';

$pathGlob = '/storage/vault*/roms/*/*';

$xmlFile = '/storage/Emulators/LaunchBox/Data/Platforms.xml';
$xmlString = file_get_contents($xmlFile);
preg_match_all('/<Platform>.*<Name>(.*)<\/Name>.*<\/Platform>/msuU', $xmlString, $matches);
$platforms = $matches[1];
$platformCount = count($matches[1]);
echo "Parsed out {$platformCount} platforms from {$xmlFile}\n";
$pathPlatforms = [];
foreach (glob($pathGlob) as $path) {
	if (is_dir($path)) {
        $pathPlatforms[] = [
            'company' => basename(dirname($path)),
            'platform' => basename($path)
        ];
	}
}
$pathPlatformCount = count($pathPlatforms);
echo "Parsed out {$pathPlatformCount} platforms from {$pathGlob}\n";
$matches = [];
foreach ($platforms as $platform) {
    $matches[$platform] = [];
    $platformMatches = [];
    $platformPercentMatches = [];
    foreach ($pathPlatforms as $pathPlatformData) {
        $pathCompany  = $pathPlatformData['company'];
        $pathPlatform  = $pathPlatformData['platform'];
        $pathPlatformArray = [
            $pathPlatform => $pathPlatform,
            $pathCompany.' '.$pathPlatform => $pathPlatform,
            preg_replace("/^{$pathCompany} -* */", '', $pathPlatform) => $pathPlatform,
        ];
        if (substr(trim($pathPlatform), -1) == ')') {
            $pathPlatformArray[preg_replace('/^(.*) \(.*\)\s*$/uU', '\1', trim($pathPlatform))] = $pathPlatform;
            $pathPlatformArray[$pathCompany.' '.preg_replace('/^(.*) \(.*\)\s*$/uU', '\1', trim($pathPlatform))] = $pathPlatform;
            $pathPlatformArray[preg_replace("/^{$pathCompany} -* */", '', preg_replace('/^(.*) \(.*\)\s*$/uU', '\1', trim($pathPlatform)))] = $pathPlatform;
        } 
        foreach ($pathPlatformArray as $pathPlatformString => $pathPlatform) {
            $phpStringCompare = new StringCompare($platform, $pathPlatformString, [
                'remove_html_tags' => true, 
                'remove_extra_spaces' => true,
                'remove_punctuation' => true, 
            ]);
            $matchPercent = $phpStringCompare->getSimilarityPercentage();
            $diffPercent = $phpStringCompare->getDifferencePercentage();
            $platformMatches[$pathPlatform] = $matchPercent;
            if (!isset($platformPercentMatches[$matchPercent]))
                $platformPercentMatches[$matchPercent] = [];
            $platformPercentMatches[$matchPercent][] = [$pathCompany, $pathPlatformString, $pathPlatform, $diffPercent];
        }
    }
    $percents = array_keys($platformPercentMatches);
    rsort($percents);
    foreach ($percents as $idx => $percent) {
        //echo "Platform {$platform} checking percent {$percent} results\n";
        foreach ($platformPercentMatches[$percent] as $platformPercentIdx => $pathPlatformData) {
            list($pathCompany, $pathPlatformString, $pathPlatform, $diffPercent) = $pathPlatformData;                          
            echo sprintf("%47s %6.2f %6.2f %40s %47s %47s\n", $platform, $percent, $diffPercent, $pathCompany, $pathPlatform, $pathPlatformString);
            break 2;
        }
    }    
}