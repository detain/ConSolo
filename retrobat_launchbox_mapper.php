<?php

include_once __DIR__.'/vendor/autoload.php';
include_once __DIR__.'/src/xml2array.php';

$config = [
	'launchbox' => [
		'base' => '/mnt/f/Consoles/LaunchBox',
		'seperator' => '/',
	],
	'retrobat' => [
		'base' => '/mnt/f/Consoles/RetroBat',
		'seperator' => '\\',

	]
];
$retroToLbImages = [
	'marquee' => ['Clear Logo', 'Banner', 'Arcade - Marquee'],
	'thumbnail' => ['Box - Front', 'Box - 3D'],
	'image' => ['Screenshot - Gameplay', 'Screenshot - Game Title', 'Box - Front', 'Box - 3D', 'Clear Logo', 'Banner', 'Arcade - Marquee', 'Cart - Front', 'Cart - 3D', 'Disc'],
	//'fanart' => ['Fanart - Background'],
	//'titleshot' => ['Screenshot - Game Title'],
	//'boxback' => ['Box - Back'],
	//'extra1' => ['Arcade - Marquee'],
];
$retroToLbFields = [
	'path' => 'ApplicationPath',
	'name' => 'Title',
	'desc' => 'Notes',
	'rating' => 'CommunityStarRating',
	'releasedate' => 'ReleaseDate',
	'developer' => 'Developer',
	'publisher' => 'Publisher',
	'genre' => 'Genre',
	'players' => 'MaxPlayers',
	'playcount' => 'PlayCount',
	'gametime' => 'PlayTime',
];

$map = [
	'launchbox' => [
		'platforms' => [],
		'games' => [],
		'altNames' => [],
		'altVers' => [],
		'filePaths' => [],
		'images' => [],
	],
	'retrobox' => [
		'platforms' => [],
		'games' => [],
		'links' => [],
	],
];
// load LaunchBox games
echo "Loading LaunchBox information\n";
$listXml = file_get_contents($config['launchbox']['base'].'/Data/Platforms.xml');
$list = xml2array($listXml, false);
$map['launchbox']['platforms'] = $list['LaunchBox']['Platform'];
foreach ($map['launchbox']['platforms'] as $platform) {
	$name = $platform['Name'];
	if (!file_exists($config['launchbox']['base'].'/Data/Platforms/'.$name.'.xml'))
		continue;
	$listXml = file_get_contents($config['launchbox']['base'].'/Data/Platforms/'.$name.'.xml');
	$list = xml2array($listXml, false);
	if (isset($list['LaunchBox']['AlternateName'])) {
		foreach ($list['LaunchBox']['AlternateName'] as $data) {
			if (!is_array($data))
				continue;
			if (!array_key_exists('GameID', $data))
				continue;
			if (!isset($map['launchbox']['altNames'][$data['GameID']]))
				$map['launchbox']['altNames'][$data['GameID']] = [];
			$map['launchbox']['altNames'][$data['GameID']][] = $data;
		}
	}
	if (isset($list['LaunchBox']['AdditionalApplication'])) {
		foreach ($list['LaunchBox']['AdditionalApplication'] as $data) {
			if (!isset($map['launchbox']['altVers'][$data['GameID']]))
				$map['launchbox']['altVers'][$data['GameID']] = [];
			$map['launchbox']['altVers'][$data['GameID']][] = $data;
		}
	}
	$games = $list['LaunchBox']['Game'];
	echo "[LaunchBox] Working on {$name} (".count($games)." games)\n";
	foreach ($games as $game) {
		if (!is_array($game) || !array_key_exists('ApplicationPath', $game))
			continue;
		$gamePath = str_replace("\\", '/', $game['ApplicationPath']);
		if (preg_match('/^([A-Z]):\//i', $gamePath, $matches))
			$gamePath = str_replace($matches[0], '/mnt/'.strtolower($matches[1]).'/', $gamePath);
		echo "[LaunchBox] Game {$gamePath}\n";
		$map['launchbox']['filePaths'][$gamePath] = $game;
		if (array_key_exists('ID', $game) && isset($map['launchbox']['altVers'][$game['ID']])) {
			foreach ($map['launchbox']['altVers'][$game['ID']] as $data) {
				$gamePath = str_replace("\\", '/', $data['ApplicationPath']);
				if (preg_match('/^([A-Z]):\//i', $gamePath, $matches))
					$gamePath = str_replace($matches[0], '/mnt/'.strtolower($matches[1]).'/', $gamePath);
				echo "[LaunchBox] Game {$gamePath}\n";
				$map['launchbox']['filePaths'][$gamePath] = $game;
			}
		}
		if (isset($map['launchbox']['altNames'][$game['ID']])) {
		}
	}
}
preg_match_all('/Images\/(?P<platform>[^\/]*)\/(?P<type>.*)\/(?P<game>[^\/]*)-(?P<index>\d+)\.[pj][np]g$/muU', trim(`find {$config['launchbox']['base']}/Images -type f`), $matches);
foreach ($matches[0] as $idx => $imageFile) {
	$platform = $matches['platform'][$idx];
	$type = $matches['type'][$idx];
	$game = $matches['game'][$idx];
	$index = $matches['index'][$idx];
	if (!array_key_exists($platform, $map['launchbox']['images']))
		$map['launchbox']['images'][$platform] = [];
	if (!array_key_exists($game, $map['launchbox']['images'][$platform]))
		$map['launchbox']['images'][$platform][$game] = [];
	if (!array_key_exists($type, $map['launchbox']['images'][$platform][$game]))
		$map['launchbox']['images'][$platform][$game][$type] = [];
	$map['launchbox']['images'][$platform][$game][$type][intval($index)] = basename($imageFile);
}

// load Retrobat games
echo "Loading RetroBat information\n";
// get symlinked paths
$links = explode("\n", trim(`find {$config['retrobat']['base']}/roms -type l`));
// map symlink paths back to real paths
foreach ($links as $link)
	$map['retrobox']['links'][$link] = realpath($link); // '/mnt/f/Consoles/RetroBat/roms/msx2+' => '/mnt/i/MSX/MSX2+'
$map['retrobat']['platforms'] = json_decode(file_get_contents($config['retrobat']['base'].'/systems.json'), true);
foreach ($map['retrobat']['platforms'] as $platform) {
		$path = $platform['path'];
		$path = str_replace(["\\", "~/.."], ['/', $config['retrobat']['base']], $path);
		echo "[RetroBat] Platform {$platform['name']} {$path}\n";
		if (file_exists($path.'/gamelist.xml')) {
			$listXml = file_get_contents($path.'/gamelist.xml');
			$list = xml2array($listXml, false);
			if (!isset($list['gameList']['game']))
				continue;
			$games = $list['gameList']['game'];
			echo "[RetroBat] Working on {$platform['name']} (".count($games)." games)\n";
			$updated = false;
			foreach ($games as $game) {
				if (!is_array($game)) {
					echo json_encode($game, JSON_PRETTY_PRINT).PHP_EOL;
					exit;
				}
				if (!array_key_exists('path', $game))
					continue;
				$gamePath = $path.substr($game['path'], 1);
				foreach ($map['retrobox']['links'] as $link => $target)
					if (substr($gamePath, 0, strlen($link)+1) == $link.'/')
						$gamePath = str_replace($link.'/', $target.'/', $gamePath);
				echo "[RetroBat] Game {$gamePath}\n";
				if (array_key_exists($gamePath, $map['launchbox']['filePaths'])) {
					$data = $map['launchbox']['filePaths'][$gamePath];
					echo "[RetroBat] Found matching LaunchBox game {$gamePath}\n";
					if (isset($data['DatabaseID'])) {
						echo "[RetroBat] Found LaunchBox DatabaseID, Updating RetroBat\n";
						$listXml = str_replace("<path>{$game['path']}</path>\n\t\t<name>{$game['name']}</name>", "<path>{$game['path']}</path>\n\t\t<name>{$data['Title']}</name>", $listXml);
						$updated = true;
						$imageName = preg_replace('/[<>:"\/\\|\?\*]+/', '_', $data['Title']);
						if (isset($map['launchbox']['images'][$data['Platform']])) {
							if (isset($map['launchbox']['images'][$data['Platform']][$imageName])) {
								foreach ($retroToLbImages as $retroImageType => $retroToLbImageTypes) { // image, marquee, thumbnail
									if (!isset($game[$retroImageType])) {
										foreach ($retroToLbImageTypes as $retroToLbImageType) {
											foreach ($map['launchbox']['images'][$data['Platform']][$imageName] as $lbImageTypes) {
												foreach ($lbImageTypes as $lbImageType => $lbImages) { // Fanart - Background/North America, Arcade - Marquee
													if (substr($lbImageType, 0, strlen($retroToLbImageType)) == $retroToLbImageType) {
														$firstImage = array_shift($lbImages);
														$pathInfo = pathinfo($firstImage);
														$imageExt = $pathInfo['extension'];
														$pathInfo = pathinfo(substr($game['path'], 2));
														$imageName = './images/'.($pathInfo['dirname'] == '.' ? '' : $pathInfo['dirName']).'/'.basename($game['path'], '.'.$pathInfo['extension']).'-'.($retroImageType == 'thumbnail' ? 'thumb' : $retroImageType).'.'.$imageExt;
														if (!file_exists($config['retrobat']['base'].'/roms/'.$platform.'/'.dirname($imageName)))
															mkdir(dirname($imageName), 0777, true);
														copy($config['launchbox']['base'].'/Images/'.$data['Platform'].'/'.$lbImageType.'/'.$firstImage, $config['retrobat']['base'].'/roms/'.$platform.'/'.$imageName);
														$listXml = str_replace("<path>{$game['path']}</path>", "<path>{$game['path']}</path>\n\t\t<{$retroImageType}>{$imageName}</{$retroImageType}>", $listXml);
														continue 4;
													}
												}
											}
										}
									}
								}
								echo "[LaunchBox] {$data['Platform']} - {$data['Title']} Images found: ".json_encode($map['launchbox']['images'][$data['Platform']][$imageName], JSON_PRETTY_PRINT)."\n";
								exit;
							}
						}
					}
				}
			}
			if ($updated === true) {
				echo "[Retroat] Wrote Updated {$path}/gamelist.xml.new\n";
				//file_put_contents($path.'/gamelist.xml', $listXml);
				file_put_contents($path.'/gamelist.xml.new', $listXml);
			}
		}
}

/* $images = [
	'Arcade' => [
		'1943: The Battle of Midway' => [
			"Advertisement Flyer - Back\/North America": {        "1": "1943_ The Battle of Midway-01.jpg",        "2": "1943_ The Battle of Midway-02.jpg",        "3": "1943_ The Battle of Midway-03.jpg",        "4": "1943_ The Battle of Midway-04.jpg"    },
			"Advertisement Flyer - Front\/North America": {        "2": "1943_ The Battle of Midway-02.jpg"    },
			"Arcade - Cabinet\/North America": {        "1": "1943_ The Battle of Midway-01.png"    },
			"Arcade - Circuit Board\/North America": {        "1": "1943_ The Battle of Midway-01.png"    },
			"Arcade - Control Panel": {        "1": "1943_ The Battle of Midway-01.png"    },
			"Arcade - Marquee": {        "1": "1943_ The Battle of Midway-01.jpg"    },
			"Box - 3D\/North America": {        "1": "1943_ The Battle of Midway-01.png",        "2": "1943_ The Battle of Midway-02.png"    },
			"Clear Logo\/North America": {        "1": "1943_ The Battle of Midway-01.png",        "2": "1943_ The Battle of Midway-02.png"    },
			"Fanart - Background": {        "1": "1943_ The Battle of Midway-01.png",        "2": "1943_ The Battle of Midway-02.jpg"    },
			"Fanart - Box - Front": {        "1": "1943_ The Battle of Midway-01.png"    },
			"Screenshot - Game Over": {        "1": "1943_ The Battle of Midway-01.png"    },
			"Screenshot - Game Title": {        "1": "1943_ The Battle of Midway-01.jpg"    },
			"Screenshot - Gameplay": {        "1": "1943_ The Battle of Midway-01.png",        "2": "1943_ The Battle of Midway-02.png",        "3": "1943_ The Battle of Midway-03.png"    },
			"Screenshot - High Scores": {        "1": "1943_ The Battle of Midway-01.png"	}
]]];
RetroBat
	'image' => './images/New Super Mario Bros Wii [SMNE01]-image.jpg',
	'marquee' => './images/New Super Mario Bros Wii [SMNE01]-marquee.png',
	'thumbnail' => './images/New Super Mario Bros Wii [SMNE01]-thumb.png',

*/

$samples = [
	'launchbox' => [
		'platform' => [
			'Category' => [],
			'LocalDbParsed' => 'true',
			'Name' => 'Nintendo Wii',
			'LastSelectedChild' => [],
			'ReleaseDate' => '2006-12-02T03:00:00-05:00',
			'Developer' => 'Nintendo',
			'Manufacturer' => 'Foxconn',
			'Cpu' => 'IBM PowerPC 750CL "Broadway" @ 729 MHz',
			'Memory' => '64 MB RAM, 24 MB VRAM',
			'Graphics' => 'ATI R500 "Hollywood" @ 243 MHz',
			'Sound' => 'Macronix DSP @ 81 MHz + Controllers with built-in speakers',
			'Display' => '480i, 480p',
			'Media' => 'Optical Disc, Download',
			'MaxControllers' => '4',
			'Folder' => [],
			'Notes' => 'The Wii is a home video game console released by Nintendo on November 19, 2006. As a seventh-generation console, the Wii competes with Microsoft\'s Xbox 360 and Sony\'s PlayStation 3. Nintendo states that its console targets a broader demographic than that of the two others. As of the first quarter of 2012, the Wii leads its generation over PlayStation 3 and Xbox 360 in worldwide sales, with more than 101 million units sold; in December 2009, the console broke the sales record for a single month in the United States. The Wii introduced the Wii Remote controller, which can be used as a handheld pointing device and which detects movement in three dimensions. Another notable feature of the console is the now-defunct WiiConnect24, which enabled it to receive messages and updates over the Internet while in standby mode. Like other seventh-generation consoles, it features a game download service, called "Virtual Console", which features emulated games from past systems. It succeeded the Nintendo GameCube, and early models are fully backwards-compatible with all GameCube games and most accessories. Nintendo first spoke of the console at the 2004 E3 press conference and later unveiled it at the 2005 E3. Nintendo CEO Satoru Iwata revealed a prototype of the controller at the September 2005 Tokyo Game Show. At E3 2006, the console won the first of several awards. By December 8, 2006, it had completed its launch in the four key markets. In late 2011, Nintendo released a reconfigured model, the "Wii Family Edition", which lacks Nintendo GameCube compatibility; this model was not released in Japan. The Wii Mini, Nintendo\'s first major console redesign since the compact SNES, succeeded the standard Wii model and was released first in Canada on December 7, 2012. The Wii Mini can only play Wii optical discs, as it omits GameCube compatibility and all networking capabilities. The Wii\'s successor, the Wii U, was released on November 18, 2012. On October 20, 2013, Nintendo confirmed it had discontinued production of the Wii in Japan and Europe, although the Wii Mini is still in production and available in Europe.',
			'VideosFolder' => [],
			'FrontImagesFolder' => [],
			'BackImagesFolder' => [],
			'ClearLogoImagesFolder' => [],
			'FanartImagesFolder' => [],
			'ScreenshotImagesFolder' => [],
			'BannerImagesFolder' => [],
			'SteamBannerImagesFolder' => [],
			'ManualsFolder' => [],
			'MusicFolder' => [],
			'ScrapeAs' => [],
			'VideoPath' => [],
			'ImageType' => [],
			'SortTitle' => [],
			'LastGameId' => [],
			'BigBoxView' => [],
			'BigBoxTheme' => [],
			'AndroidThemeVideoPath' => []
		],
		'game' => [
			'ApplicationPath' => 'I:\\Nintendo\\Wii\\NTSC\\New Super Mario Bros Wii [SMNE01].wbfs',
			'DateAdded' => '2022-06-09T16:45:15.6021122-04:00',
			'DateModified' => '2022-06-09T16:45:15.6021122-04:00',
			'Developer' => 'Nintendo EAD',
			'DosBoxConfigurationPath' => [],
			'Emulator' => '0e82d48b-7646-4d75-a91b-04d973739f5c',
			'Favorite' => 'false',
			'ID' => '6ee58762-e4ae-4bc5-8d7e-35a8e2d958fe',
			'Notes' => 'The game follows the traditional storyline of Princess Peach getting kidnapped by Bowser and his children, the Koopalings and Bowser Jr. When Mario, Luigi, Blue Toad, and Yellow Toad are celebrating Princess Peach\'s birthday in her castle, a large cake rolls in. Immediately, Bowser Jr. and the Koopalings pop out and throw the cake on top of Peach, trapping her. The cake is loaded onto Bowser\'s airship and it takes off, with Mario, Luigi, and the Toads giving chase. The Toads in the castle then grant them access to the Propeller and Penguin Suits via a cannon.',
			'Platform' => 'Nintendo Wii',
			'Publisher' => 'Nintendo',
			'Rating' => 'E - Everyone',
			'ReleaseDate' => '2009-11-20T03:00:00-05:00',
			'Status' => 'Imported ROM',
			'DatabaseID' => '170',
			'WikipediaURL' => 'https://en.wikipedia.org/wiki/New_Super_Mario_Bros._Wii',
			'Title' => 'New Super Mario Bros. Wii',
			'Version' => '[SMNE01]',
			'Genre' => 'Platform',
			'ReleaseType' => 'Released',
			'MaxPlayers' => '4',
			'Series' => [],
			'PlayMode' => 'Cooperative; Multiplayer',
			'PlayCount' => '0',
			'PlayTime' => '0',
			'CommandLine' => [],
			'Completed' => 'false',
			'ConfigurationCommandLine' => [],
			'ConfigurationPath' => [],
			'UseDosBox' => 'false',
			'UseScummVM' => 'false',
			'Portable' => 'false',
			'Hide' => 'false',
			'Broken' => 'false',
			'CloneOf' => [],
			'VideoUrl' => 'http://www.youtube.com/watch?v=ht8r30Vk9P0',
			'ManualPath' => [],
			'MusicPath' => [],
			'RootFolder' => [],
			'SortTitle' => [],
			'Source' => [],
			'StarRatingFloat' => '0',
			'StarRating' => '0',
			'CommunityStarRating' => '4.5285172',
			'CommunityStarRatingTotalVotes' => '263',
			'MissingVideo' => 'true',
			'MissingBoxFrontImage' => 'false',
			'MissingScreenshotImage' => 'false',
			'MissingMarqueeImage' => 'false',
			'MissingClearLogoImage' => 'false',
			'MissingBackgroundImage' => 'false',
			'MissingBox3dImage' => 'false',
			'MissingCartImage' => 'false',
			'MissingCart3dImage' => 'true',
			'MissingManual' => 'true',
			'MissingBannerImage' => 'false',
			'MissingMusic' => 'true',
			'GogAppId' => [],
			'OriginAppId' => [],
			'OriginInstallPath' => [],
			'VideoPath' => [],
			'ThemeVideoPath' => [],
			'ScummVMAspectCorrection' => 'false',
			'ScummVMFullscreen' => 'false',
			'ScummVMGameDataFolderPath' => [],
			'ScummVMGameType' => [],
			'UseStartupScreen' => 'false',
			'HideAllNonExclusiveFullscreenWindows' => 'false',
			'StartupLoadDelay' => '0',
			'HideMouseCursorInGame' => 'false',
			'DisableShutdownScreen' => 'false',
			'AggressiveWindowHiding' => 'false',
			'OverrideDefaultStartupScreenSettings' => 'false',
			'UsePauseScreen' => 'false',
			'PauseAutoHotkeyScript' => [],
			'ResumeAutoHotkeyScript' => [],
			'OverrideDefaultPauseScreenSettings' => 'false',
			'SuspendProcessOnPause' => 'false',
			'ForcefulPauseScreenActivation' => 'false',
			'LoadStateAutoHotkeyScript' => [],
			'SaveStateAutoHotkeyScript' => [],
			'ResetAutoHotkeyScript' => [],
			'SwapDiscsAutoHotkeyScript' => [],
			'CustomDosBoxVersionPath' => [],
			'AndroidBoxFrontThumbPath' => [],
			'AndroidBoxFrontFullPath' => [],
			'AndroidClearLogoThumbPath' => [],
			'AndroidClearLogoFullPath' => [],
			'AndroidBackgroundPath' => [],
			'AndroidBackgroundThumbPath' => [],
			'AndroidGameTitleScreenshotThumbPath' => [],
			'AndroidGameplayScreenshotThumbPath' => [],
			'AndroidGameTitleScreenshotPath' => [],
			'AndroidGameplayScreenshotPath' => [],
			'AndroidVideoPath' => [],
		]
	],
	'retrobat' => [
		'platform' => [
			'name' => 'wii',
			'fullname' => 'Wii',
			'manufacturer' => 'Nintendo',
			'release' => '2006',
			'hardware' => 'console',
			'path' => '~\\..\\roms\\wii',
			'extension' => '.gcz .iso .ciso .wbfs .wad .rvz .GCZ .ISO .CSO .WBFS .WAD .RVZ',
			'command' => '"%HOME%\\emulatorLauncher.exe" %CONTROLLERSCONFIG% -system %SYSTEM% -emulator %EMULATOR% -core %CORE% -rom %ROM%',
			'emulators' => '
  <emulator name="dolphin">
	<core default="true">dolphin</core>
  </emulator>
  <emulator name="libretro">
	<cores>
	  <core>dolphin</core>
	</cores>
  </emulator>
',
			'platform' => 'wii',
			'theme' => 'wii',
		],
		'game' => [
			'path' => './New Super Mario Bros Wii [SMNE01].wbfs',
			'name' => 'New Super Mario Bros. Wii',
			'desc' => 'Princess Peach has been kidnapped!  Again!  Everyone was celebrating the Princess\' birthday when a giant birthday cake arrived... but then Bowser Jr. and the toward the goal.',
			'image' => './images/New Super Mario Bros Wii [SMNE01]-image.jpg',
			'video' => './videos/New Super Mario Bros Wii [SMNE01]-video.mp4',
			'marquee' => './images/New Super Mario Bros Wii [SMNE01]-marquee.png',
			'thumbnail' => './images/New Super Mario Bros Wii [SMNE01]-thumb.png',
			'rating' => '0.85',
			'releasedate' => '20091115T000000',
			'developer' => 'Nintendo',
			'publisher' => 'Nintendo',
			'genre' => 'Action',
			'family' => 'Super Mario Bros',
			'players' => '4',
			'playcount' => '4',
			'lastplayed' => '20220611T000741',
			'gametime' => '1836',
			'lang' => 'en',
			'crc32' => '7C9EDBC6',
			'md5' => '1306778e12a2a39b8c8da648c744f33d',
			'region' => 'jp'
		]
	]
];

?>
