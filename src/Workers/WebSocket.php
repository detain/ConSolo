<?php
use Workerman\Worker;

$context = array(
    'ssl' => array(
        'local_cert'                 => '/server.pem',
        'local_pk'                   => '/server.key',
        'verify_peer'                => false,
        'allow_self_signed' => true,
    )
);
$worker = new Worker('websocket://0.0.0.0:443', $context);
$worker->transport = 'ssl';
$worker->onMessage = function($con, $msg) {
    $con->send('ok');
};

Worker::runAll();