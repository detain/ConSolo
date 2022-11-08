<?php
/**
* ScreenScraper API v2 Wrapper
*/
namespace Detain\ConSolo\Importing\API;

class ScreenScraper
{


	/**
	* Perform an API call and parse the result
	*
	* @param string $page the page base name to visit, such as ssuserInfos
	* @param string $params optional params for the url like '&param1=value&param2=value'
	* @erturn array anm array indicating a respones code, the response text
	*/
	public static function api($page, $params = '') {
		global $config, $curl_config;
		$url = 'https://www.screenscraper.fr/api2/'.$page.'.php'
			.'?devid='.$config['screenscraper']['api_user']
			.'&devpassword='.$config['screenscraper']['api_pass']
			.'&softname=ConSolo'
			.'&output=json'
			. $params;
		$response = getcurlpage($url, '', $curl_config);
		$code = $GLOBALS['curl_http_code'];
		// display errors, otherwise deccode response
		$success = $code === 200;
		if ($success)
			$response = json_decode($response, true);
		else
			echo "ScreenScraper API returned HTTP code {$code} with response: {$response}\n";
		$return = [
			'code' => $code,
			'response' => $response
		];
		file_put_contents('screenscraper_response.json', json_encode($return, getJsonOpts()));
		return $return;
	}


}
