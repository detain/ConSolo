<?php

namespace Detain\ConSolo\Matching;

require_once __DIR__.'/../bootstrap.php';

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Classifiers\KNearestNeighbors;
use Rubix\ML\CrossValidation\HoldOut;
use Rubix\ML\CrossValidation\Metrics\Accuracy;

$samples = [
    [3, 4, 50.5], [1, 5, 24.7], [4, 4, 62.0], [3, 2, 31.1]
];
$labels = ['married', 'divorced', 'married', 'divorced'];
$dataset = new Labeled($samples, $labels);
$estimator = new KNearestNeighbors(5);
$estimator->train($dataset);
var_dump($estimator->trained());
$validator = new HoldOut(0.2);
$score = $validator->test($estimator, $dataset, new Accuracy());
var_dump($score);