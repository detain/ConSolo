<?php

namespace Detain\ConSolo\Matching;

require_once __DIR__.'/../bootstrap.php';

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Classifiers\KNearestNeighbors;

$samples = [
    [3, 4, 50.5], [1, 5, 24.7], [4, 4, 62.0], [3, 2, 31.1]
];
$labels = ['married', 'divorced', 'married', 'divorced'];
$dataset = new Labeled($samples, $labels);
$estimator = new KNearestNeighbors(5);
$estimator->train($dataset);
var_dump($estimator->trained());
$unknown = [
    [4, 3, 44.2], [2, 2, 16.7], [2, 4, 19.5], [1, 5, 8.6], [3, 3, 55.0],
];
$dataset = new Unlabeled($unknown);
$predictions = $estimator->predict($dataset);
var_dump($predictions);