<?php
use \Workerman\Worker;
use \Workerman\WebServer;
use \Workerman\Autoloader;

$context = [                                                                                        // Certificate is best to apply for a certificate
    'ssl' => [                                                                                        // use the absolute/full paths
        'local_cert' => '/home/my/files/apache_setup/interserver.net.crt',                            // can also be a crt file
        'local_pk' => '/home/my/files/apache_setup/interserver.net.key',
        'cafile' => '/home/my/files/apache_setup/AlphaSSL.root.crt',
        'verify_peer' => false,
        'verify_peer_name' => false,
    ]
];
$web = new WebServer("http://0.0.0.0:55151", $context); // WebServer
$web->count = 2; // WebServer number of processes
$web->transport = 'ssl';
$web->addRoot(isset($_SERVER['HOSTNAME']) ? $_SERVER['HOSTNAME'] : trim(`hostname -f`), __DIR__.'/../../Web'); // Set the site root

if (!defined('GLOBAL_START')) { // If it is not started in the root directory, run the runAll method
    Worker::runAll();
}

    
$web->onConnect = function ($connection) {
    $connection->maxSendBufferSize = 50663296;
};
