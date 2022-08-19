<?php

use \DetectLanguage\DetectLanguage;

/**
 * Detects the end-of-line character of a string.
 * @param string $str The string to check.
 * @param string $default Default EOL (if not detected).
 * @return string The detected EOL, or default one.
 */
function detectEol($str, $default = PHP_EOL) {
	static $eols = [
		"\r\n",
		"\n",
		"\0x000D000A", // [UNICODE] CR+LF: CR (U+000D) followed by LF (U+000A)
		"\0x000A",     // [UNICODE] LF: Line Feed, U+000A
		"\0x000B",     // [UNICODE] VT: Vertical Tab, U+000B
		"\0x000C",     // [UNICODE] FF: Form Feed, U+000C
		"\0x000D",     // [UNICODE] CR: Carriage Return, U+000D
		"\0x0085",     // [UNICODE] NEL: Next Line, U+0085
		"\0x2028",     // [UNICODE] LS: Line Separator, U+2028
		"\0x2029",     // [UNICODE] PS: Paragraph Separator, U+2029
		"\0x0D0A",     // [ASCII] CR+LF: Windows, TOPS-10, RT-11, CP/M, MP/M, DOS, Atari TOS, OS/2, Symbian OS, Palm OS
		"\0x0A0D",     // [ASCII] LF+CR: BBC Acorn, RISC OS spooled text output.
		"\0x0A",       // [ASCII] LF: Multics, Unix, Unix-like, BeOS, Amiga, RISC OS
		"\0x0D",       // [ASCII] CR: Commodore 8-bit, BBC Acorn, TRS-80, Apple II, Mac OS <=v9, OS-9
		"\0x1E",       // [ASCII] RS: QNX (pre-POSIX)
		//"\0x76",       // [?????] NEWLINE: ZX80, ZX81 [DEPRECATED]
		"\0x15",       // [EBCDEIC] NEL: OS/390, OS/400
	];
	$cur_cnt = 0;
	$cur_eol = $default;
	foreach ($eols as $eol) {
		if (($count = substr_count($str, $eol)) > $cur_cnt) {
			$cur_cnt = $count;
			$cur_eol = $eol;
		}
	}
	return $cur_eol;
}

/**
* Recursively scan a directory for files skipping .git .svn . ..
* @param string $directory
* @param array $entries_array array of files
*/
function recursive_read($directory, $entries_array = []) {
	if (is_dir($directory)) {
		$handle = opendir($directory);
		while (FALSE !== ($entry = readdir($handle))) {
			if ($entry == '.' || $entry == '..' || $entry == '.git' || $entry == '.svn')
				continue;
			$Entry = $directory.'/'.$entry;
			if (is_dir($Entry))
				$entries_array = recursive_read($Entry, $entries_array);
			else
				$entries_array[] = $Entry;
		}
		closedir($handle);
	}
	return $entries_array;
}

/**
* Translates text using a local translation cache file
*
* @param string $old the foreign text
* @return string the translated text
*/
function translate($old) {
	global $translations, $language, $translator;
	if (array_key_exists($old, $translations))
		return $translations[$old];
	throttleCode();
	if ($language === false) {
		$language = 'auto';
		$language = detectLanguage($old);
	}
	$cmd = 'deep_translator -trans '.escapeshellarg($translator).' -src '.escapeshellarg($language).' -tg en --text '.escapeshellarg($old).'|grep -v -e "^ | Translation" -e "^Translated text"|cut -c2-';
	echo '💱 Looking up the translation using:'.$cmd.PHP_EOL;
	$new = trim(`{$cmd}`);
	echo "OLD:{$old}\nGOT:{$new}\n";
	if (trim($new) != '') {
		$translations[$old] = $new;
		file_put_contents('translations.json', json_encode($translations, getJsonOpts()));
	}
	return $new;
}

/**
* Detects what language $text is written in
* @param string $text text in an unknown language
* @return string the language used in the text
*/
function detectLanguage($text) {
	echo " detecting language for:".$text;
	if (substr($text, -1) == "\r")
		$text = substr($text, 0, -1);
	if (strlen($text) > 2000)
		return 'auto';
	$result = DetectLanguage::simpleDetect($text);
	if ($result == 'zh')
		$result = 'zh_CN';
	echo ' = '.$result.PHP_EOL;
	return $result;
}

/**
* ensures you do not go over a certain amount of requests per second to avoid bans
*
* @param int $requestsPerSecond
* @return void
*/
function throttleCode($requestsPerSecond = 5) {
	global $throttle;
	$end = false;
	while ($end === false) {
		$now = time();
		$old = $now - 2;
		if (count($throttle) > 0)
			while ($throttle[0] >= $old)
				array_shift($throttle);
		if (count($throttle) >= 4) {
			echo " 😴 Sleeping for a second ⌛ to avoid hitting the {$requestPerSecond} requests/sec rate limit 😴";
			sleep(1);
			echo '🥱 Woke Up 🥱'.PHP_EOL;
		} else
			$end = true;
	}
	$throttle[] = $now;
}

include 'src/bootstrap.php';
if ($_SERVER['argc'] < 2)
	die('Missing directory argument(s)');
global $translations, $throttle, $language, $translator;
DetectLanguage::setApiKey("1bcf8a4de966ec9e01e0c4010015a732");
//$translator = 'pons';
//$translator = 'linguee';
//$translator = 'mymemory';
$translator = 'google';
$throttle = [];
$language = false;
$translations = file_exists('translations.json') ? json_decode(file_get_contents('translations.json'), true) : [];
for ($arg = 1; $arg < $_SERVER['argc']; $arg++) {
	$path = $_SERVER['argv'][$arg];
	echo '📂 Got Path '.$path.' 📂'.PHP_EOL;
	$files = recursive_read($path);
	foreach ($files as $fileName) {
		$updates = 0;
		$file = file_get_contents($fileName);
		$eol = detectEol($file);
		if (false !== $pos = strpos(json_encode($file, getJsonOpts()), '\\u')) {
			$lines = explode($eol, $file);
			foreach ($lines as $idx => $line) {
				$lineEnc = json_encode($line, getJsonOpts());
				$pos = strpos($lineEnc, '\\u');
				if (false !== $pos) {
					$old = substr($line, $pos - 1);
					echo 'Translationg '.$fileName.PHP_EOL;
					if (strlen($old) < 2000) {
						$new = translate($old);
						if (trim($new) != '') {
							$updates++;
							$line = str_replace($old, $new, $line);
							$lines[$idx] = $line;
						}
					}
				}
			}
			$newFile = implode($eol, $lines);
			file_put_contents($fileName, $newFile);
			echo '✍ Wrote '.$updates.' changes to '.$fileName.' ✍'.PHP_EOL;
		}
	}
}
