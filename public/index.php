<?php
require_once __DIR__.'/../src/bootstrap.php';

/**
* @var \Workerman\MySQL\Connection
*/
global $db;
/**
* @var \Twig\Environment
*/
global $twig;

echo $twig->render('index.twig', array(
//    'client_id' => $_GET['client_id'],
//    'response_type' => $_GET['response_type'],
    'queryString' => $_SERVER['QUERY_STRING']
));
