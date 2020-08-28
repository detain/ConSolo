<?php

use LastFmApi\Api\AuthApi;
use LastFmApi\Api\UserApi;
use LastFmApi\Exception\ApiFailedException;

require_once __DIR__.'/../../../bootstrap.php';

global $config;
$apiKey = $config['lastfm']['api_key'];
$apiSecret = $config['lastfm']['api_secret'];
$user = 'lorddetain';
$limit = 50;
try {
	$auth = new AuthApi('gettoken', array(
		'apiKey' => $config['lastfm']['api_key'],
		'apiSecret' => $config['lastfm']['api_secret']
	));
	if (empty($auth->token))
		exit('Empty Auth Token Response on GetToken call'.PHP_EOL);
} catch (ApiFailedException $e) {
	exit('Got Error Code '.$e->getCode().' Message '.$e->getMessage().PHP_EOL);
}
$config['lastfm']['token'] = $auth->token;
$auth = new AuthApi('getsession', array(
	'apiKey' => $config['lastfm']['api_key'],
	'apiSecret' => $config['lastfm']['api_secret'],
	'token' => $config['lastfm']['token']
));
foreach (['username', 'subscriber', 'sessionKey'] as $idx) {
	$config['lastfm'][$idx] = $auth->{$idx};
	if (is_null($config['lastfm'][$idx]))
		exit('LastFM returned null '.$idx);
} 

$auth = new AuthApi('setsession', ['apiKey' => $config['lastfm']['api_key']]);
$userApi = new UserApi($auth);
$page = 0;
$end = false;
$fullInfo = [];
while ($end === false) {
		$page++;
		try {
				$userInfo = $userApi->getLovedTracks(['user' => $user, 'limit' => $limit, 'page' => $page]);
		} catch (\LastFmApi\Exception\LastFmApiException $e) {
				echo $e->getMessage() . ',  Skipping Page'.PHP_EOL;
				continue;
		}
		foreach ($userInfo as $idx => $userData)
				$fullInfo[] = $userData;
		if (count($userInfo) < $limit)
				$end = true;
		echo count($fullInfo).' Total Rows'.PHP_EOL;
}
file_put_contents('loved_tracks.json', json_encode($fullInfo, JSON_PRETTY_PRINT));
