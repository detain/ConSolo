<?php
/**
* Loads all the LaunchBox Platforms from its XML Data files, and looks through all your
* rom directories and uses some strong comparison logic to calculate how close the launchbox
* platform names is to the roms platform names and match up the closest ones.  
* 
* It then updates the LaunchBox Platforms XMl setting the Games/Roms folder path for each
* platform to the appropriate directory. 
*/
require_once __DIR__.'/StringCompare.php';

$pathGlob = '/storage/vault*/roms/*/*';

$xmlFile = '/storage/Emulators/LaunchBox/Data/Platforms.xml';
$xmlString = file_get_contents($xmlFile);
preg_match_all('/<Platform>.*<Name>(.*)<\/Name>.*(<Folder.[^>]*>).*<\/Platform>/msuU', $xmlString, $matches);
$platforms = $matches[1];
$folders = $matches[2];
$platformCount = count($matches[1]);               
echo "Parsed out {$platformCount} platforms from {$xmlFile}\n";
$pathPlatforms = [];
foreach (glob($pathGlob) as $path) {
	if (is_dir($path)) {
        $pathPlatforms[] = [
            'path' => $path,
            'company' => basename(dirname($path)),
            'platform' => basename($path)
        ];
	}
}
$pathPlatformCount = count($pathPlatforms);
echo "Parsed out {$pathPlatformCount} platforms from {$pathGlob}\n";
$allMatches = [];
foreach ($platforms as $platformIdx => $platform) {
    $allMatches[$platform] = [];
    $platformMatches = [];
    $platformPercentMatches = [];
    foreach ($pathPlatforms as $pathPlatformData) {
        $pathPath = $pathPlatformData['path'];
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
            $platformPercentMatches[$matchPercent][] = [$pathCompany, $pathPlatformString, $pathPlatform, $diffPercent, $pathPath];
        }
    }
    $percents = array_keys($platformPercentMatches);
    rsort($percents);
    foreach ($percents as $idx => $percent) {
        //echo "Platform {$platform} checking percent {$percent} results\n";
        foreach ($platformPercentMatches[$percent] as $platformPercentIdx => $pathPlatformData) {
            list($pathCompany, $pathPlatformString, $pathPlatform, $diffPercent, $pathPath) = $pathPlatformData;                          
            echo sprintf("%50s %10.2f %10.2f %-60s\n", $platform, $percent, $diffPercent, $pathPath);
            $platformString = $matches[0][$platformIdx];
            $platformFolderString = $matches[2][$platformIdx];
            $platformNewFolderString = '<Folder>'.str_replace(['&', '/storage/','/'], ['&amp;', 'Y:\\', '\\'],$pathPath).'</Folder>';
            $platformNewString = str_replace($platformFolderString, $platformNewFolderString, $platformString);
            $xmlString = str_replace($platformString, $platformNewString, $xmlString);

            break 2;
        }
    }    
}
file_put_contents($xmlFile.'.new', $xmlString);