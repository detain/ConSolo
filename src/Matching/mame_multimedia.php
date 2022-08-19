<?php
require_once __DIR__.'/../bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
$rows = $db->query('select name from mame_machines');
$mameMachines = [];
foreach ($rows as $row) {
	$mameMachines[] = $row['name'];
}
$rows = $db->query('select platform, name from mame_software');
$mameSoftware = [];
foreach ($rows as $row) {
	if (!array_key_exists($row['platform'], $mameSoftware))
		$mameSoftware[$row['platform']] = [];
	$mameSoftware[$row['platform']][] = $row['name'];
}
$media = [];
preg_match_all('/^(?P<section>[^\/]+)\/(?P<platform>[^\/]+)\/(?P<name>.*)$/muU', file_get_contents('gfx_SL.txt'), $matches);
foreach ($matches['section'] as $idx => $section) {
	$platform = $matches['platform'][$idx];
	$name = $matches['name'][$idx];
	if (false !== $pos = strrpos($name, '.'))
		$name = substr($name, 0, $pos);
	if (!array_key_exists($platform, $media))
		$media[$platform] = [];
	if (!array_key_exists($name, $media[$platform]))
		$media[$platform][$name] = [];
	if (!in_array($platform, $mameSoftware))
		echo 'Found unmatched SL game platform '.$platform.PHP_EOL;
	elseif (!in_array($name, $mameSoftware[$platform]))
		echo 'Found unmatched SL game platform '.$platform.' name '.$name.' section '.$section.PHP_EOL;
	$media[$platform][$name][] = $section;
}
preg_match_all('/^(?P<section>[^\/]+)\/(?P<name>.*)$/muU', file_get_contents('gfx.txt'), $matches);
$platform = 'mame';
$media[$platform] = [];
foreach ($matches['section'] as $idx => $section) {
	$name = $matches['name'][$idx];
	if (false !== $pos = strrpos($name, '.'))
		$name = substr($name, 0, $pos);
	if (!array_key_exists($name, $media[$platform]))
		$media[$platform][$name] = [];
	if (!in_array($name, $mameMachines))
		echo 'Found unmatched arcade game name '.$name.' section '.$section.PHP_EOL;
	$media[$platform][$name][] = $section;
}
file_put_contents('media.json', json_encode($media, getJsonOpts()));
/*
files in these dirs dont corrispond to game names
* ctrlr
* dats
* folders

the rest have names that corrispond to game names and if the software ones hten also nested inside a platform named dir
artwork lay
cheat xml
cheat_SL xml
ctrlr cfg
dats dat
folders ini
icons ico
manuals pdf
manuals_SL pdf
samples wav

artpreview png
bosses png
cabinets png
covers_SL png
cpanel png
devices png
ends png
flyers png
gameover png
howto png
logo png
marquees png
pcb png
scores png
select png
snap png
snap_SL png
titles png
titles_SL png
versus png
warning png


artwork  	contains: bezels, control panels, marquees, instruction cards, backdrops, overlays, lamps and LEDs
ctrlr  	controller configurations
samples  	zipped WAV files for systems that don't have audio emulated yet; see Mame samples
cheat  	compilation of cheats
artpreview 	artwork preview screenshots
bosses 	boss (final and hardest enemy of a level) screenshots
cabinets 	cabinets screenshots
covers_SL 	covers of the Software List
cpanel 	images of control panels
devices 	images of electronic gadgets that are attached to main systems
ends 	screenshot of the end of each game (when the game is completed)
flyers 	scanned paper advertisement intended for wide distribution to promote the systems
gameover 	screenshot of the game over message of every game
howto 	screenshot of the general instructions that the games display
icons 	icons of arcade games and the other systems
logo 	screenshot of the logo of the company that created every game
manuals 	manuals in PDF (usage and operational)
manuals_SL 	manuals in PDF (usage and operational) of Software List
marquees 	photos of the brand of the cab that is on the top of the cabinet, usually back-lit neon sign
pcb 	Printed Circuit Board snapshots; photos of the motherboards of the systems
scores 	screenshot of the default high score of every game
select 	screenshot of one selection menu of every game (character, country, level, gun, tool, language etc)
snap 	in-game screenshots
snap_SL 	in-game Software List screenshots
titles 	title screenshots, usually taken when the name of the game is shown during attract mode
titles_SL 	title screenshots of Software List, usually taken when the name of the game is shown during attract mode
versus 	screenshot of the presentation of the characters that will play against each other
warning 	screenshots of warnings displayed by the games


dats dir :
command.dat 	list of the commands (e.g. how to do a Hadouken in Street Fighter)
gameinit.dat 	initialization procedures for games that are not playable on the first run
hiscore.dat 	unofficial highest scores achieved
history.dat 	history information text file
mameinfo.dat 	information text file of arcade games
messinfo.dat 	information text file of non-arcade games; also lists changes in "whatsnew" and SVN
story.dat 	MAMESCORE top scores
sysinfo.dat 	systems information text file; contains details of the original machines and basic usage instructions

folders dir :
arcade.ini 	arcade games
arcade_NOBIOS.ini 	arcade games that don't require a BIOS to run
category.ini 	systems in about 235 categories
catlist.ini 	systems in about 224 categories (with slightly different criteria)
genre.ini 	systems in about 28 categories
languages.ini 	systems in about 16 languages
mamescore.ini 	games with MAMESCORE entries
mess.ini 	non-arcade systems
monochrome.ini 	games with two colors in three categories: "Black and White Games", "Monochromatic Games" and "Vectorial Black and White"
nplayers.ini 	how many players the game supports and if it's simultaneous play or not
screenless.ini 	systems without video output
series.ini 	lists series of games
version.ini 	lists of games that were added on every MAME version


*/
