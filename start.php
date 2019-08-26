#!/usr/bin/env php
<?php
use Workerman\Worker;

include_once __DIR__.'/src/bootstrap.php';

define('GLOBAL_START', 1); // The flag is globally activated
Worker::$stdoutFile = __DIR__.'/stdout.log';
foreach (glob(__DIR__.'/src/Workers/*.php') as $start_file) {
    require_once $start_file;
}

Worker::runAll();
