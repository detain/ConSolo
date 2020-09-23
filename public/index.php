<?php

require_once __DIR__.'/../src/bootstrap.php';

// Common Methods: GET, POST, PUT, PATCH, DELETE and HEAD
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
	$r->addRoute(['POST', 'HEAD'], '/bad_method', 'get_all_users_handler');
	$r->get('/', 'get_bad_error');
	$r->get('/movies/', 'get_bad_error');
	$r->get('/users', 'get_all_users_handler');
	// {id} must be a number (\d+)
	$r->get('/user/{id:\d+}', 'get_user_handler');
	// The /{title} suffix is optional
	$r->get('/articles/{id:\d+}[/{title}]', 'get_article_handler');
	$r->addGroup('/api', function (FastRoute\RouteCollector $r) {
		$r->get('[/]', ['Detain\ConSolo\Models\Api', 'index']);
		$r->get('/genres[/]', ['Detain\ConSolo\Models\Api', 'genres']);
		$r->get('/movies[/]', ['Detain\ConSolo\Models\Api', 'movies']);
		$r->get('/movies/collections[/]', ['Detain\ConSolo\Models\Api', 'collections']);
		$r->get('/people[/]', ['Detain\ConSolo\Models\Api', 'people']);
		$r->get('/tv[/]', ['Detain\ConSolo\Models\Api', 'tv']);
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
	call_user_func_array([$class, $method], $vars);
else
	call_user_func([$class, $method]);
