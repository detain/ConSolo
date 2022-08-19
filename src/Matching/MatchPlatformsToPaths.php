<?php
/**
* grabs latest TheGamesDB data and updates db
*/

require_once __DIR__.'/../bootstrap.php';

use FuzzyWuzzy\Fuzz;
use FuzzyWuzzy\Process;
use Fuse\Fuse;

/**
* @var \Workerman\MySQL\Connection
*/
global $db;

$glob = '/storage/vault*/roms/*/*';
$platforms = [];
$name2id = [];
$path2id = [];
$good = [];
$missing = [];
echo 'Loading Platforms'.PHP_EOL;
$rows = $db->query("select * from platforms");
foreach ($rows as $idx => $row) {
    $platforms[$row['id']] = $row;
    $name2id[$row['name']] = $row['id'];
}

echo 'Loading Platform Matchs with all sources'.PHP_EOL;
$rows = $db->query("select * from platform_matches");
foreach ($rows as $idx => $row) {
    $name2id[$row['name']] = $row['platform_id'];
}
            
echo 'Loading LaunchBox Alternative Platforms'.PHP_EOL;
$rows = $db->query("select Name as name, Alternate as alternate from launchbox_platformalternatenames");
foreach ($rows as $idx => $row) {
    if (!isset($name2id[$row['name']])) {
        echo 'Error finding '.$row['name'].PHP_EOL;
    } else {
        $name2id[$row['alternate']] = $name2id[$row['name']];
    }
}

echo 'Mapping Developer and Manufacturer Platform Names'.PHP_EOL;
foreach ($name2id as $name => $id) {
    if (isset($platforms[$id])) {
        foreach (['developer','manufacturer'] as $field) {
            if (!is_null($platforms[$id][$field])) {
                $name2id[$platforms[$id][$field].' '.$name] = $id;
                $name2id[$platforms[$id][$field].' - '.$name] = $id;
                if (strpos($name, $platforms[$id][$field].' - ') !== false) {
                    $name = str_replace($platforms[$id][$field].' - ', '', $name);
                    $name2id[$name] = $id;
                    $name2id[$platforms[$id][$field].' '.$name] = $id;
                }
            }
        }
    }
}

echo 'Setting up Searching'.PHP_EOL;
$maxResults = 10;
$names = [];
$namesAssoc = [];
foreach ($name2id as $name => $id) {
    $names[] = $name;
    $namesAssoc[] = [
        'name' => $name
    ];
}
$fuse = new Fuse($namesAssoc, ['keys' => ['name']]);
$fuzz = new Fuzz();
$process = new Process($fuzz);

echo 'Mapping File Paths'.PHP_EOL;
foreach (glob($glob) as $path) {
    if (is_dir($path)) {
        $name = basename($path);
        if (strpos($name, ' (') !== false) {
            $name = substr($name, 0, strpos($name, ' ('));
        }
        $manufacturer = basename(dirname($path));
        $found = false;
        $names = [$name, $manufacturer.' '.$name, $manufacturer.' - '.$name];
        if (strpos($name, $manufacturer.' - ') !== false) {
            $name = str_replace($manufacturer.' - ', '', $name);
        }
        foreach ($names as $search) {
            if (array_key_exists($search, $name2id)) {
                $found = true;
                $path2id[$path] = $name2id[$search];
                if (!in_array($manufacturer.'/'.$name, $good))
                    $good[] = $manufacturer.'/'.$name;
                break;
            }
        }
        if ($found == false) {
            if (!in_array($manufacturer.'/'.$name, $missing))
                $missing[] = $manufacturer.'/'.$name;
        }
    }
}
$done = [];
echo 'Found:'.PHP_EOL;
foreach ($path2id as $path => $id) {
    $platform = $platforms[$id];
    $name = basename($path);
    $manufacturer = basename(dirname($path));
    echo '    '.$manufacturer.'/'.$name.'  =>  '.$platform['name'].PHP_EOL;
}
echo 'Missing:'.json_encode($missing, getJsonOpts()).PHP_EOL;
echo 'Found '.count($path2id).' Missing '.count($missing).PHP_EOL;

foreach ($missing as $missingData) {
    list($manufacturer, $name) = explode('/', $missingData);
    //$search = $name;
    $searches = [$name];
    if (!in_array(str_replace($manufacturer.' '.$manufacturer, $manufacturer, $manufacturer.' '.$name), $searches)) {
        $searches[] = str_replace($manufacturer.' '.$manufacturer, $manufacturer, $manufacturer.' '.$name); 
    }
    if (!in_array(str_replace($manufacturer.' - '.$manufacturer, $manufacturer, $manufacturer.' - '.$name), $searches)) {
        $searches[] = str_replace($manufacturer.' - '.$manufacturer, $manufacturer, $manufacturer.' - '.$name); 
    }
    foreach ($searches as $search) {
        $scores = [];
        echo 'Searching for '.$search.PHP_EOL;
        
        $results = $fuse->search($search); 
        foreach ($results as $idx => $data) {
            $out[] = $data['name'];
            $scores[$data['name']] = (isset($scores[$data['name']]) ? $scores[$data['name']] : 0) + ceil(100 - ($idx * (100 / count($results))));
            if ($idx >= $maxResults) {
                break;
            }
        }
        if (count($out) > 0) {
            echo '      Fuse:'.implode(', ', $out).PHP_EOL;
        }
        
        $c = $process->extract($search, $names);
        $results = $c->toArray();
        $out = [];
        foreach ($results as $idx => $data) {
            $out[] = $data[0].' ('.$data[1].'%)';
            $scores[$data[0]] = (isset($scores[$data[0]]) ? $scores[$data[0]] : 0) + $data[1];
            if ($idx >= $maxResults) {
                break;
            }
        }
        if (count($out) > 0) {
            echo '      Fuzzy:'.implode(', ', $out).PHP_EOL;
        }
        
        $levs = [];
        foreach ($names as $name) {
            $levs[$name] = levenshtein($search, $name);
            //$scores[$name] = (isset($scores[$name]) ? $scores[$name] : 0) + (100 - ($levs[$name] * 15));
        }
        $levValues = array_values($levs);
        $levValues = array_unique($levValues);
        sort($levValues);
        reset($levValues);
        $found = 0;
        $foundResults = 0;
        $out = [];
        foreach ($levValues as $levValue) {
            $found++;
            foreach ($levs as $name => $value) {
                if ($value == $levValue) {
                    $foundResults++;
                    $out[] = $name.' ('.$value.')';
                    $scores[$name] = (isset($scores[$name]) ? $scores[$name] : 0) + (100 - ($found * 10 + $value)); 
                    if ($foundResults >= $maxResults) {
                        break;
                    }
                }
            }
            if ($found >= 5 || $foundResults >= $maxResults) {
                break;
            }
        }
        echo '      Levenshtein:'.implode(', ', $out).PHP_EOL;
        
        /*
        $scoreValues = array_values($scores);
        $scoreValues = array_unique($scoreValues);
        rsort($scoreValues);
        reset($scoreValues);
        $found = 0;
        $foundResults = 0;
        $out = [];
        foreach ($scoreValues as $scoreValue) {
            $found++;
            foreach ($scores as $name => $value) {
                if ($value == $scoreValue) {
                    $foundResults++;
                    $out[] = $name.' ('.$value.')';
                    if ($foundResults >= $maxResults) {
                        break;
                    }
                }
            }
            if ($found >= 5 || $foundResults >= $maxResults) {
                break;
            }
        }
        echo '      Overall:'.implode(', ', $out).PHP_EOL;
        */
    }
}

/*
echo 'Found:'.PHP_EOL;
foreach ($path2id as $path => $id) {
    $platform = $platforms[$id];
    $name = basename($path);
    $developer = basename(dirname($path));
    echo '    '.$developer.'/'.$name.'  =>  '.$platform['name'].PHP_EOL;
}
echo 'Missing:'.json_encode($missing, getJsonOpts()).PHP_EOL;
*/
echo 'Found '.count($path2id).' Missing '.count($missing).PHP_EOL;
