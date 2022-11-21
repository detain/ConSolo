<?php

require_once __DIR__.'/../src/bootstrap.php';

// Common Methods: GET, POST, PUT, PATCH, DELETE and HEAD
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
	$r->addRoute(['POST', 'HEAD'], '/bad_method', 'get_all_users_handler');
	$r->get('/users', 'get_all_users_handler');
	// {id} must be a number (\d+)
	$r->get('/user/{id:\d+}', 'get_user_handler');
	// The /{title} suffix is optional
	$r->get('/articles/{id:\d+}[/{title}]', 'get_article_handler');
	$r->get('[/]', ['\Detain\ConSolo\Models\Web', 'index']);
        $r->get('/sourcesnew[/]', ['\Detain\ConSolo\Models\Web', 'sources']);
        $r->get('/sources[/]', ['\Detain\ConSolo\Models\Web', 'sources']);
        $r->get('/source/{id}[/]', ['\Detain\ConSolo\Models\Web', 'source']);
        $r->get('/companies[/]', ['\Detain\ConSolo\Models\Web', 'companies']);
        $r->get('/company/{id}[/]', ['\Detain\ConSolo\Models\Web', 'company']);
        $r->get('/emulatorsnew[/]', ['\Detain\ConSolo\Models\Web', 'emulators_new']);
        $r->get('/emulators[/]', ['\Detain\ConSolo\Models\Web', 'emulators']);
        $r->get('/emulator/{id}[/]', ['\Detain\ConSolo\Models\Web', 'emulator']);
		$r->get('/platforms[/]', ['\Detain\ConSolo\Models\Web', 'platforms']);
		$r->get('/platform/{id}[/]', ['\Detain\ConSolo\Models\Web', 'platform']);
		$r->get('/games[/]', ['\Detain\ConSolo\Models\Web', 'games']);
		$r->get('/game/{id}[/]', ['\Detain\ConSolo\Models\Web', 'game']);
		$r->get('/genres[/]', ['\Detain\ConSolo\Models\Web', 'genres']);
		$r->get('/genre/{id:\d+}[/]', ['\Detain\ConSolo\Models\Web', 'genre']);
		$r->get('/movies/genre/{id:\d+}[/]', ['\Detain\ConSolo\Models\Web', 'genre']);
		$r->get('/tv/genre/{id:\d+}[/]', ['\Detain\ConSolo\Models\Web', 'genre']);
		$r->get('/movies[/]', ['\Detain\ConSolo\Models\Web', 'movies']);
		$r->get('/movie/{id:\d+}[/]', ['\Detain\ConSolo\Models\Web', 'movie']);
		$r->get('/movies/collections[/]', ['\Detain\ConSolo\Models\Web', 'collections']);
		$r->get('/movies/collection/{id:\d+}[/]', ['\Detain\ConSolo\Models\Web', 'collection']);
		$r->get('/people[/]', ['\Detain\ConSolo\Models\Web', 'people']);
		$r->get('/person/{id:\d+}[/]', ['\Detain\ConSolo\Models\Web', 'person']);
		$r->get('/tv[/]', ['\Detain\ConSolo\Models\Web', 'tv']);
		$r->get('/tv/shows[/]', ['\Detain\ConSolo\Models\Web', 'tv_shows']);
		$r->get('/tv/show/{show:\d+}[/]', ['\Detain\ConSolo\Models\Web', 'tv_show']);
		$r->get('/tv/show/{show:\d+}/episodes[/]', ['\Detain\ConSolo\Models\Web', 'tv_episodes']);
		$r->get('/tv/show/{show:\d+}/episode/{episode:\d+}[/]', ['\Detain\ConSolo\Models\Web', 'tv_episode']);
		$r->get('/tv/show/{show:\d+}/seasons[/]', ['\Detain\ConSolo\Models\Web', 'tv_seasons']);
		$r->get('/tv/show/{show:\d+}/season/{season:\d+}[/]', ['\Detain\ConSolo\Models\Web', 'tv_season']);
		$r->get('/tv/show/{show:\d+}/season/{season:\d+}/episodes[/]', ['\Detain\ConSolo\Models\Web', 'tv_episodes']);
		$r->get('/tv/show/{show:\d+}/season/{season:\d+}/episode/{episode:\d+}[/]', ['\Detain\ConSolo\Models\Web', 'tv_episode']);
	$r->addGroup('/api', function (FastRoute\RouteCollector $r) {
		$r->get('[/]', ['\Detain\ConSolo\Models\Api', 'index']);
        $r->get('/sources[/]', ['\Detain\ConSolo\Models\Api', 'sources']);
        $r->get('/source/{id}[/]', ['\Detain\ConSolo\Models\Api', 'source']);
        $r->get('/companies[/]', ['\Detain\ConSolo\Models\Api', 'companies']);
        $r->get('/company/{id}[/]', ['\Detain\ConSolo\Models\Api', 'company']);
        $r->get('/emulators[/]', ['\Detain\ConSolo\Models\Api', 'emulators']);
        $r->get('/emulator/{id}[/]', ['\Detain\ConSolo\Models\Api', 'emulator']);
		$r->get('/platforms[/]', ['\Detain\ConSolo\Models\Api', 'platforms']);
		$r->get('/platform/{id}[/]', ['\Detain\ConSolo\Models\Api', 'platform']);
		$r->get('/games[/]', ['\Detain\ConSolo\Models\Api', 'games']);
		$r->get('/game/{id}[/]', ['\Detain\ConSolo\Models\Api', 'game']);
		$r->get('/genres[/]', ['\Detain\ConSolo\Models\Api', 'genres']);
		$r->get('/genre/{id:\d+}[/]', ['\Detain\ConSolo\Models\Api', 'genre']);
		$r->get('/movies/genre/{id:\d+}[/]', ['\Detain\ConSolo\Models\Api', 'genre']);
		$r->get('/tv/genre/{id:\d+}[/]', ['\Detain\ConSolo\Models\Api', 'genre']);
		$r->get('/movies[/]', ['\Detain\ConSolo\Models\Api', 'movies']);
		$r->get('/movie/{id:\d+}[/]', ['\Detain\ConSolo\Models\Api', 'movie']);
		$r->get('/movies/collections[/]', ['\Detain\ConSolo\Models\Api', 'collections']);
		$r->get('/movies/collection/{id:\d+}[/]', ['\Detain\ConSolo\Models\Api', 'collection']);
		$r->get('/people[/]', ['\Detain\ConSolo\Models\Api', 'people']);
		$r->get('/person/{id:\d+}[/]', ['\Detain\ConSolo\Models\Api', 'person']);
		$r->get('/tv[/]', ['\Detain\ConSolo\Models\Api', 'tv']);
		$r->get('/tv/shows[/]', ['\Detain\ConSolo\Models\Api', 'tv_shows']);
		$r->get('/tv/show/{show:\d+}[/]', ['\Detain\ConSolo\Models\Api', 'tv_show']);
		$r->get('/tv/show/{show:\d+}/episodes[/]', ['\Detain\ConSolo\Models\Api', 'tv_episodes']);
		$r->get('/tv/show/{show:\d+}/episode/{episode:\d+}[/]', ['\Detain\ConSolo\Models\Api', 'tv_episode']);
		$r->get('/tv/show/{show:\d+}/seasons[/]', ['\Detain\ConSolo\Models\Api', 'tv_seasons']);
		$r->get('/tv/show/{show:\d+}/season/{season:\d+}[/]', ['\Detain\ConSolo\Models\Api', 'tv_season']);
		$r->get('/tv/show/{show:\d+}/season/{season:\d+}/episodes[/]', ['\Detain\ConSolo\Models\Api', 'tv_episodes']);
		$r->get('/tv/show/{show:\d+}/season/{season:\d+}/episode/{episode:\d+}[/]', ['\Detain\ConSolo\Models\Api', 'tv_episode']);
	});
});
$routeInfo = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
if ($routeInfo[0] == FastRoute\Dispatcher::NOT_FOUND) {
	echo 'PAGE <b>'.parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH).'</b> NOT FOUND<br>'.
	'This Does Not Point An Existing Page';
	exit;
} elseif ($routeInfo[0] == FastRoute\Dispatcher::METHOD_NOT_ALLOWED) {
	$allowedMethods = $routeInfo[1];
	header('Allow: '.implode(', ', $allowedMethods));
	echo 'METHOD <b>'.$_SERVER['REQUEST_METHOD'].'</b> NOT ALLOWED<br>' .
	'Allowed Methods For <b>'.parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH).'</b> Are:  <b>'.implode(', ', $allowedMethods).'</b>';
	exit;
}
// FastRoute\Dispatcher::FOUND
$handler = $routeInfo[1];
$vars = $routeInfo[2];
$className = $handler[0];
$method = $handler[1];
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
/**
* @var \Twig\Environment
*/
global $twig;
$class = new $className($db, $twig);
if (sizeof($vars) > 0)
	$class->$method($vars);
else
	$class->$method();
