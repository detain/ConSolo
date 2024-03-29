<?php

namespace Detain\ConSolo\Models;

class Web extends Base {

    public function index() {
        echo $this->twig->render('index.twig', [
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

    public function movies() {
        $limit = 100;
        $rows = $this->db->query("select tmdb_movie.id, title, poster_path, vote_average, overview, release_date from movies left join tmdb_movie on tmdb_movie.id=movies.tmdb_id left join files on file_id=files.id where host={$this->hostId} and title is not null order by title limit {$limit}");
        echo $this->twig->render('movies.twig', [
            'results' => $rows,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

    public function movie($vars) {
        $response = [];
        if (isset($vars['id'])) {
            $id = (int)$vars['id'];
            $json = json_decode($this->db->single("select doc from tmdb_movie where id={$id} limit 1"), true);
        }
        $fileId = $this->db->single("select id from files where tmdb_id={$json['id']} and host={$this->hostId}");
        echo $this->twig->render('movie.twig', [
            'movie' => $json,
            'fileId' => $fileId,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);

    }

    public function genres() {
        $limit = 100;
        $rows = $this->db->query("select tmdb_movie.id,doc->'\$.genres[*]' as genres from movies,tmdb_movie where tmdb_id=tmdb_movie.id");
        $genres = [];
        foreach ($rows as $row) {
            $rowGenres = json_decode($row['genres'], true);
            if (!is_null($rowGenres))
                foreach ($rowGenres as $genre) {
                    if (!array_key_exists($genre['name'], $genres))
                        $genres[$genre['name']] = [
                            'id' => $genre['id'],
                            'name' => $genre['name'],
                            'count' => 0,
                        ];
                    $genres[$genre['name']]['count']++;
                }
        }
        echo $this->twig->render('genres.twig', [
            'genres' => $genres,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

    public function genre($vars) {
        $limit = 100;
        $id = (int)$vars['id'];
        $rows = $this->db->query("select tmdb_movie.id, title, poster_path, vote_average, overview, release_date from movies left join tmdb_movie on tmdb_movie.id=movies.tmdb_id left join files on file_id=files.id where host={$this->hostId} and title is not null and {$id} member of (doc->'$.genres[*].id') order by title limit {$limit}");
        echo $this->twig->render('movies.twig', [
            'results' => $rows,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

    public function collections() {

    }

    public function people() {

    }

    public function person($vars) {
        $response = [];
        if (isset($_REQUEST['id'])) {
            $id = (int)$_REQUEST['id'];
            $json = json_decode($this->db->single("select doc from tmdb_person where id={$id} limit 1"), true);
            $response['status'] = 'ok';
            $response['movie'] = $json;
        } else {
            $response['status'] = 'error';
        }
        header('Content-type: application/json; charset=UTF-8');
        echo json_encode($response, getJsonOpts());

    }

    public function tv() {
        $response = [];
        if (isset($_REQUEST['id'])) {
            $id = (int)$_REQUEST['id'];
            $json = json_decode($this->db->single("select doc from tmdb_tv_series where id={$id} limit 1"), true);
            $response['status'] = 'ok';
            $response['movie'] = $json;
        } else {
            $response['status'] = 'error';
        }
        header('Content-type: application/json; charset=UTF-8');
        echo json_encode($response, getJsonOpts());
    }

    public function sources() {
        $json = json_decode(file_get_contents(__DIR__.'/../../../emurelation/sources.json'), true);
        unset($json['']);
        $types = ['API', 'Custom', 'DAT', 'Emulator', 'Frontend', 'Tools', 'Website'];
        $provides = ['companies', 'platforms', 'emulators', 'games'];

        foreach ($json as $sourceId => $sourceData) {
            if (isset($sourceData['updatedLast']) && !is_null($sourceData['updatedLast'])) {
                $json[$sourceId]['updatedLast'] = date('Y-m-d', $sourceData['updatedLast']);
            }
        }
        echo $this->twig->render('sources.twig', [
            'provides' => $provides,
            'sourceTypes' => $types,
            'results' => $json,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

    public function emulators() {
        $jsonPlats = json_decode(file_get_contents(__DIR__.'/../../../emurelation/platforms/local.json'), true);
        $jsonEmus = json_decode(file_get_contents(__DIR__.'/../../../emurelation/emulators/local.json'), true);
        $companies = ['Unknown' => []];
        $platforms = ['Unknown'];
        $types = ['Unknown'];
        foreach ($jsonEmus as $emuId => $emuData) {
            if (!isset($emuData['platforms']) || count($emuData['platforms']) == 0) {
                $emuData['platforms'] = ['Unknown'];
                $jsonEmus[$emuId]['platforms'] = ['Unknown'];
            }
            if (!in_array($emuData['type'], $types))
                $types[] = $emuData['type'];
            foreach ($emuData['platforms'] as $platId) {
                if (!in_array($platId, $platforms)) {
                    $platforms[] = $platId;
                    $platData = $jsonPlats[$platId];
                    if (!isset($platData['company'])) {
                        $platData['company'] = 'Unknown';
                    }
                    if (!array_key_exists($platData['company'], $companies)) {
                        $companies[$platData['company']] = [];
                    }
                    $companies[$platData['company']][] = $platId;
                }
            }
        }
        if (count($companies['Unknown']) == 0) {
            unset($platforms['Unknown']);
            unset($companies['Unknown']);
        }
        sort($platforms);
        ksort($companies);
        ksort($jsonEmus);
        echo $this->twig->render('emulators.twig', [
            'companies' => $companies,
            'platResults' => $jsonPlats,
            'platforms' => $platforms,
            'types' => $types,
            'results' => $jsonEmus,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

    public function companies() {
        $json = json_decode(file_get_contents(__DIR__.'/../../../emurelation/companies/local.json'), true);
        echo $this->twig->render('companies.twig', [
            'results' => $json,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

    public function platforms() {
        $json = json_decode(file_get_contents(__DIR__.'/../../../emurelation/platforms/local.json'), true);
        $types = [];
        foreach ($json as $idx => $data)
            if (isset($data['type']) && !in_array($data['type'], $types))
                $types[] = $data['type'];
        sort($types);
        echo $this->twig->render('platforms.twig', [
            'results' => $json,
            'types' => $types,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

    public function games() {
        $json = json_decode(file_get_contents(__DIR__.'/../../../emurelation/games/local.json'), true);
        echo $this->twig->render('games.twig', [
            'results' => $json,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

    public function source($vars) {
        $json = json_decode(file_get_contents(__DIR__.'/../../../emurelation/sources.json'), true);
        $id = $vars['id'];
        $json = $json[$id];
        if (file_exists(__DIR__.'/../../../emulation-data/'.$id.'.json')) {
            $json['data'] = file_get_contents(__DIR__.'/../../../emulation-data/'.$id.'.json');
        }
        echo $this->twig->render('source.twig', [
            'data' => $json,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

    public function validSource($source) {
        return array_key_exists($source, json_decode(file_get_contents(__DIR__.'/../../../emurelation/sources.json'), true));
    }

    public function validType($type) {
        return in_array($type, ['emulators', 'games', 'platforms', 'companies']);
    }

    public function getSingular() {
        return [
            'sources' => 'source',
            'emulators' => 'emulator',
            'games' => 'game',
            'platforms' => 'platform',
            'companies' => 'company'
        ];
    }

    public function findClosestTypeFieldFromSource($field, $type, $sourceId, $limitIds = false, $maxResults = false)  {
        if (!$this->validType($type)) {
            echo "Invalid Type {$type}";
            return false;
        }
        if (!$this->validSource($sourceId)) {
            echo "Invalid Source {$sourceId}";
            return false;
        }
        $source = json_decode(file_get_contents(__DIR__.'/../../../emurelation/'.$type.'/'.$sourceId.'.json'), true);
        $localSource = json_decode(file_get_contents(__DIR__.'/../../../emurelation/'.$type.'/local.json'), true);
        if ($type == 'emulators') {
            $parentType = 'platforms';
            $parentSource = json_decode(file_get_contents(__DIR__.'/../../../emurelation/'.$parentType.'/'.$sourceId.'.json'), true);
            $localParentSource = json_decode(file_get_contents(__DIR__.'/../../../emurelation/'.$parentType.'/local.json'), true);
        }
        $insertCost = 1;
        $deleteCost = 5;
        $replaceCost = 20;
        $closest = [];
        foreach ($source as $sourceTypeId => $data) {
            if (is_array($limitIds) && !in_array($sourceTypeId, $limitIds))
                continue;
            $levenshteins = [];
            $soundexs = [];
            $metaphones = [];
            $similarTexts = [];
            $totals = [];
            $sourceNames = [$data[$field]];
            $sourceParents = [];
            if ($type == 'platforms') {
                if (isset($data['company'])) {
                    $sourceNames[] = $data['company'].' '.$data[$field];
                    $sourceParents[] = $data['company'];
                }
            } elseif ($type == 'emulators') {
                if (isset($data['platforms'])) {
                    foreach ($data['platforms'] as $parentId) {
                        if (isset($parentSource[$parentId])) {
                            $sourceNames[] = $parentSource[$parentId]['name'].' '.$data[$field];
                            $sourceParents[] = $parentSource[$parentId]['name'];
                        }
                    }
                }
            }
            foreach ($localSource as $localId => $localData) {
                $localNames = [$localData[$field]];
                $localParents = [];
                if ($type == 'platforms') {
                    if (isset($localData['company'])) {
                        $localNames[] = $localData['company'].' '.$localData[$field];
                        $localParents[] = $localData['company'];
                    }
                } elseif ($type == 'emulators') {
                    if (isset($localData['platforms'])) {
                        foreach ($localData['platforms'] as $localParentId) {
                            if (isset($localParentSource[$localParentId])) {
                                $localNames[] = $localParentSource[$localParentId]['name'].' '.$localData[$field];
                                $localParents[] = $localParentSource[$localParentId]['name'];
                            }
                        }
                    }
                }
                $similarText = 0;
                $levenshtein = 0;
                $soundex = 0;
                $metaphone = 0;
                foreach ($localNames as $localName)
                    foreach ($sourceNames as $sourceName) {
                        $levenshtein += levenshtein($localName, $sourceName, $insertCost, $replaceCost, $deleteCost);
                        $soundex += levenshtein(soundex($localName), soundex($sourceName), $insertCost, $replaceCost, $deleteCost);
                        $metaphone += levenshtein(metaphone($localName), metaphone($sourceName), $insertCost, $replaceCost, $deleteCost);
                        similar_text($localName, $sourceName, $percent);
                        $similarText += $percent;
                    }
                foreach ($localParents as $localParent)
                    foreach ($sourceParents as $sourceParent) {
                        $levenshtein += levenshtein($localParent, $sourceParent, $insertCost, $replaceCost, $deleteCost);
                        $soundex += levenshtein(soundex($localParent), soundex($sourceParent), $insertCost, $replaceCost, $deleteCost);
                        $metaphone += levenshtein(metaphone($localParent), metaphone($sourceParent), $insertCost, $replaceCost, $deleteCost);
                        similar_text($localParent, $sourceParent, $percent);
                        $similarText += $percent;
                    }
                $levenshteins[$localId] = $levenshtein;
                $soundexs[$localId] = $soundex;
                $metaphones[$localId] = $metaphone;
                $similarTexts[$localId] = $similarText;
                $totals[$localId] = 0;
            }
            asort($levenshteins);
            asort($soundexs);
            asort($metaphones);
            arsort($similarTexts);
            foreach ([$levenshteins, $soundexs, $metaphones, $similarTexts] as $rowIdx => $row) {
                $position = 0;
                foreach ($row as $localId => $lev) {
                    $totals[$localId] += (count($levenshteins) - $position) / count($levenshteins) * 100;
                    $position++;
                }
            }
            arsort($totals);
            $closest[$sourceTypeId] = $maxResults !== false ? array_slice(array_keys($totals), 0, $maxResults) : array_keys($totals);
            /* foreach ($totals as $idx => $score) {
                    $data = $source[$idx];
                    $sourceName = (isset($data['company']) ? $data['company'].' ' : '').$data[$field];
                    echo "{$sourceName}<br>";
            } */
        }
        return $closest;
    }

    public function findClosestTypeFieldInSourceItem($field, $type, $sourceId, $localId) {

    }

    public function findClosest($field, $vars, $maxResults = false) {
        $sourceId = $vars['sourceId'];
        $type = $vars['type'];
        $id = $vars['id'];
        if (!$this->validType($type)) {
            echo "Invalid Type {$type}";
            return;
        }
        if (!$this->validSource($sourceId)) {
            echo "Invalid Source {$sourceId}";
            return;
        }
        $source = json_decode(file_get_contents(__DIR__.'/../../../emurelation/'.$type.'/'.$sourceId.'.json'), true);
        $json = json_decode(file_get_contents(__DIR__.'/../../../emurelation/'.$type.'/local.json'), true);
        if (!isset($json[$id])) {
            echo "Invalid ID {$id}";
            return;
        }
        $json = $json[$id];
        $localNames = [$json[$field]];
        $matchCompanies = [];
        if (isset($json['company'])) {
            $localNames[] = $json['company'].' '.$json[$field];
            $matchCompanies[] = $json['company'];
        }
        $levenshteins = [];
        $soundexs = [];
        $metaphones = [];
        $similarTexts = [];
        $totals = [];
        $insertCost = 1;
        $deleteCost = 5;
        $replaceCost = 20;
        foreach ($source as $idx => $data) {
            $similarText = 0;
            $levenshtein = 0;
            $soundex = 0;
            $metaphone = 0;
            $sourceNames = [$data[$field]];
            $targetCompanies = [];
            if (isset($data['company'])) {
                $sourceNames[] = $data['company'].' '.$data[$field];
                $targetCompanies[] = $data['company'];
            }
            foreach ($localNames as $localName)
                foreach ($sourceNames as $sourceName) {
                    $levenshtein += levenshtein($localName, $sourceName, $insertCost, $replaceCost, $deleteCost);
                    $soundex += levenshtein(soundex($localName), soundex($sourceName), $insertCost, $replaceCost, $deleteCost);
                    $metaphone += levenshtein(metaphone($localName), metaphone($sourceName), $insertCost, $replaceCost, $deleteCost);
                    similar_text($localName, $sourceName, $percent);
                    $similarText += $percent;
                }
            foreach ($matchCompanies as $matchCompany)
                foreach ($targetCompanies as $targetCompany) {
                    $levenshtein += levenshtein($matchCompany, $targetCompany, $insertCost, $replaceCost, $deleteCost);
                    $soundex += levenshtein(soundex($matchCompany), soundex($targetCompany), $insertCost, $replaceCost, $deleteCost);
                    $metaphone += levenshtein(metaphone($matchCompany), metaphone($targetCompany), $insertCost, $replaceCost, $deleteCost);
                    similar_text($matchCompany, $targetCompany, $percent);
                    $similarText += $percent;
                }
            $levenshteins[$idx] = $levenshtein;
            $soundexs[$idx] = $soundex;
            $metaphones[$idx] = $metaphone;
            $similarTexts[$idx] = $similarText;
            $totals[$idx] = 0;
        }
        asort($levenshteins);
        asort($soundexs);
        asort($metaphones);
        arsort($similarTexts);
        foreach ([$levenshteins, $soundexs, $metaphones, $similarTexts] as $rowIdx => $row) {
            $position = 0;
            foreach ($row as $idx => $lev) {
                $totals[$idx] += (count($levenshteins) - $position) / count($levenshteins) * 100;
                $position++;
            }
        }
        arsort($totals);
        $return = $maxResults !== false ? array_slice(array_keys($totals), 0, $maxResults) : array_keys($totals);
        /* foreach ($totals as $idx => $score) {
                $data = $source[$idx];
                $sourceName = (isset($data['company']) ? $data['company'].' ' : '').$data[$field];
                echo "{$sourceName}<br>";
        } */
        return $return;
    }

    public function missing_item($vars) {
        $sourceId = $vars['sourceId'];
        $type = $vars['type'];
        $id = $vars['id'];
        if (!$this->validType($type)) {
            echo "Invalid Type {$type}";
            return;
        }
        if (!$this->validSource($sourceId)) {
            echo "Invalid Source {$sourceId}";
            return;
        }
        $source = json_decode(file_get_contents(__DIR__.'/../../../emurelation/'.$type.'/'.$sourceId.'.json'), true);
        $json = json_decode(file_get_contents(__DIR__.'/../../../emurelation/'.$type.'/local.json'), true);
        if (!isset($json[$id])) {
            echo "Invalid ID {$id}";
            return;
        }
        $json = $json[$id];
        echo '<pre>';
        print_r($json);
        echo "\n";
        echo '</pre>';
        $localNames = [$json['name']];
        $matchCompanies = [];
        if (isset($json['company'])) {
            $localNames[] = $json['company'].' '.$json['name'];
            $matchCompanies[] = $json['company'];
        }
        $levenshteins = [];
        $soundexs = [];
        $metaphones = [];
        $similarTexts = [];
        $totals = [];
        $insertCost = 1;
        $deleteCost = 5;
        $replaceCost = 20;
        foreach ($source as $idx => $data) {
            $similarText = 0;
            $levenshtein = 0;
            $soundex = 0;
            $metaphone = 0;
            $sourceNames = [$data['name']];
            $targetCompanies = [];
            if (isset($data['company'])) {
                $sourceNames[] = $data['company'].' '.$data['name'];
                $targetCompanies[] = $data['company'];
            }
            foreach ($localNames as $localName)
                foreach ($sourceNames as $sourceName) {
                    $levenshtein += levenshtein($localName, $sourceName, $insertCost, $replaceCost, $deleteCost);
                    $soundex += levenshtein(soundex($localName), soundex($sourceName), $insertCost, $replaceCost, $deleteCost);
                    $metaphone += levenshtein(metaphone($localName), metaphone($sourceName), $insertCost, $replaceCost, $deleteCost);
                    similar_text($localName, $sourceName, $percent);
                    $similarText += $percent;
                }
            foreach ($matchCompanies as $matchCompany)
                foreach ($targetCompanies as $targetCompany) {
                    $levenshtein += levenshtein($matchCompany, $targetCompany, $insertCost, $replaceCost, $deleteCost);
                    $soundex += levenshtein(soundex($matchCompany), soundex($targetCompany), $insertCost, $replaceCost, $deleteCost);
                    $metaphone += levenshtein(metaphone($matchCompany), metaphone($targetCompany), $insertCost, $replaceCost, $deleteCost);
                    similar_text($matchCompany, $targetCompany, $percent);
                    $similarText += $percent;
                }
            $levenshteins[$idx] = $levenshtein;
            $soundexs[$idx] = $soundex;
            $metaphones[$idx] = $metaphone;
            $similarTexts[$idx] = $similarText;
            $totals[$idx] = 0;
        }
        asort($levenshteins);
        asort($soundexs);
        asort($metaphones);
        arsort($similarTexts);
        foreach ([$levenshteins, $soundexs, $metaphones, $similarTexts] as $rowIdx => $row) {
            $position = 0;
            foreach ($row as $idx => $lev) {
                $totals[$idx] += (count($levenshteins) - $position) / count($levenshteins) * 100;
                $position++;
            }
        }
        arsort($totals);
        foreach ($totals as $idx => $score) {
                $data = $source[$idx];
                $sourceName = (isset($data['company']) ? $data['company'].' ' : '').$data['name'];
                echo "{$sourceName}<br>";
        }
        return;
        echo $this->twig->render('missing.twig', [
            'missing' => $missing,
            'sourceId' => $sourceId,
            'type' => $type,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

    public function missing($vars) {
        $sourceId = $vars['sourceId'];
        $type = $vars['type'];
        $maxMatches = 20;
        if (!$this->validType($type)) {
            echo "Invalid Type {$type}";
            return;
        }
        if (!$this->validSource($sourceId)) {
            echo "Invalid Source {$sourceId}";
            return;
        }
        $missing = [];
        $found = [];
        $matches = [];
        $json = json_decode(file_get_contents(__DIR__.'/../../../emurelation/'.$type.'/local.json'), true);
        $updated = false;
        foreach ($json as $id => $data) {
            if (isset($data['matches'][$sourceId]) && !empty($data['matches'][$sourceId])) {
                foreach ($data['matches'][$sourceId] as $typeId) {
                    if (!array_key_exists($typeId, $matches)) {
                        $matches[$typeId] = [];
                    }
                    $matches[$typeId][] = $id;
                }
            }
        }
        $source = json_decode(file_get_contents(__DIR__.'/../../../emurelation/'.$type.'/'.$sourceId.'.json'), true);
        foreach ($source as $id => $data) {
            $slug = str_replace([' ', '/', ':', '-'], ['_', '_', '_', '_'], strtolower($id));
            if (isset($_GET['check_'.$slug])) {
                $localIds = $_GET['check_'.$slug];
                foreach ($localIds as $localId) {
                    if (!array_key_exists($localId, $json)) {
                        echo "Invalid Local {$type} ID {$localId}\n";
                        exit;
                    }
                    if (!isset($json[$localId]['matches']))
                        $json[$localId]['matches'] = [];
                    if (!isset($json[$localId]['matches'][$sourceId]))
                        $json[$localId]['matches'][$sourceId] = [];
                    if (!array_key_exists($id, $json[$localId]['matches'][$sourceId]))
                        $json[$localId]['matches'][$sourceId][] = $id;
                    $updated = true;
                }
            }
            if (!array_key_exists($id, $matches)) {
                $missing[$id] = $data;
            }
        }
        if ($updated === true) {
            file_put_contents(__DIR__.'/../../../emurelation/'.$type.'/local.json', json_encode($json, getJsonOpts()));
        }
        $closest = $this->findClosestTypeFieldFromSource('name', $type, $sourceId, array_keys($missing), $maxMatches);
        //echo '<pre>';print_r($found);echo '</pre>';
        //echo '<pre>';print_r(array_keys($missing));echo '</pre>';exit;
        echo $this->twig->render('missing.twig', [
            'closest' => $closest,
            'missing' => $missing,
            'source' => $source,
            'local' => $json,
            'sourceId' => $sourceId,
            'type' => $type,
            'singular' => $this->getSingular(),
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

    public function status() {
        $sources = json_decode(file_get_contents(__DIR__.'/../../../emurelation/sources.json'), true);
        $unmatched = [];
        $totals = [];
        $return = [];
        $types = ['emulators','platforms','companies','games'];
        foreach ($sources as $sourceId => $sourceData) {
            $unmatched[$sourceId] = [];
            $totals[$sourceId] = [];
            foreach ($sourceData['provides'] as $type) {
                if (file_exists(__DIR__.'/../../../emurelation/'.$type.'/'.$sourceId.'.json')) {
                    $source = json_decode(file_get_contents(__DIR__.'/../../../emurelation/'.$type.'/'.$sourceId.'.json'), true);
                    $unmatched[$sourceId][$type] = array_keys($source);
                    $totals[$sourceId][$type] = count($unmatched[$sourceId][$type]);
                }
            }
        }
        foreach ($types as $type) {
            $local = json_decode(file_get_contents(__DIR__.'/../../../emurelation/'.$type.'/local.json'), true);
            foreach ($local as $localId => $localData) {
                if (isset($localData['matches'])) {
                    foreach ($localData['matches'] as $sourceId => $sourceTypeIds) {
                        foreach ($sourceTypeIds as $sourceTypeId) {
                            if (isset($unmatched[$sourceId][$type])) {
                                $idx = array_search($sourceTypeId, $unmatched[$sourceId][$type]);
                                if ($idx !== false) {
                                    array_splice($unmatched[$sourceId][$type], $idx, 1);
                                }
                            }
                        }
                    }
                }
            }
            $unmatched['local'][$type] = [];
            $return[$type] = [];
            foreach ($sources as $sourceId => $sourceData) {
                if (isset($unmatched[$sourceId][$type]) && isset($totals[$sourceId][$type])) {
                    $return[$type][$sourceId] = [
                        'unmatched' => count($unmatched[$sourceId][$type]),
                        'total' => $totals[$sourceId][$type],
                    ];
                }
            }
        }
        //echo '<pre>'.json_encode($totals, JSON_PRETTY_PRINT).'</pre><br>';
        //echo '<pre>'.json_encode($unmatched, JSON_PRETTY_PRINT).'</pre><br>';
        //echo '<pre>'.json_encode($return, JSON_PRETTY_PRINT).'</pre><br>';
        echo $this->twig->render('status.twig', [
            'return' => $return,
            'types' => $types,
            'sources' => $sources,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);

    }

    public function emulator($vars) {
        $json = json_decode(file_get_contents(__DIR__.'/../../../emurelation/emulators/local.json'), true);
        if (isset($vars['id'])) {
            $id = $vars['id'];
        }
        $json = $json[$id];
        global $cachedSources;
        if (!isset($cachedSources)) {
            $cachedSources = [];
        }
        $matches = [];
        if (isset($json['matches'])) {
            foreach ($json['matches'] as $matchSourceId => $matchIds) {
                if (isset($cachedSources[$matchSourceId])) {
                    $matchSource = $cachedSources[$matchSourceId];
                } else {
                    if (file_exists(__DIR__.'/../../../emulation-data/'.$matchSourceId.'.json')) {
                        $matchSource = json_decode(file_get_contents(__DIR__.'/../../../emulation-data/'.$matchSourceId.'.json'), true);
                        $cachedSources[$matchSourceId] = $matchSource;
                    } else {
                        continue;
                    }
                }
                if (!isset($matches[$matchSourceId])) {
                    $matches[$matchSourceId] = [];
                }
                foreach ($matchIds as $matchId) {
                    if (isset($matchSource['emulators'])) {
                        $matches[$matchSourceId][$matchId] = json_encode($matchSource['emulators'][$matchId], JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE |  JSON_UNESCAPED_SLASHES);
                    }
                }
            }

        }
        echo $this->twig->render('emulator.twig', [
            'data' => $json,
            'matches' => $matches,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

    public function company($vars) {
        $json = json_decode(file_get_contents(__DIR__.'/../../../emurelation/companies/local.json'), true);
        if (isset($vars['id'])) {
            $id = $vars['id'];
        }
        $json = $json[$id];
        global $cachedSources;
        if (!isset($cachedSources)) {
            $cachedSources = [];
        }
        $matches = [];
        if (isset($json['matches'])) {
            foreach ($json['matches'] as $matchSourceId => $matchIds) {
                if (isset($cachedSources[$matchSourceId])) {
                    $matchSource = $cachedSources[$matchSourceId];
                } else {
                    if (file_exists(__DIR__.'/../../../emulation-data/'.$matchSourceId.'.json')) {
                        $matchSource = json_decode(file_get_contents(__DIR__.'/../../../emulation-data/'.$matchSourceId.'.json'), true);
                        $cachedSources[$matchSourceId] = $matchSource;
                    } else {
                        continue;
                    }
                }
                if (!isset($matches[$matchSourceId])) {
                    $matches[$matchSourceId] = [];
                }
                foreach ($matchIds as $matchId) {
                    if (isset($matchSource['companies']) && isset($matchSource['companies'][$matchId])) {
                        $matches[$matchSourceId][$matchId] = json_encode($matchSource['companies'][$matchId], JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE |  JSON_UNESCAPED_SLASHES);
                    }
                }
            }

        }
        echo $this->twig->render('company.twig', [
            'data' => $json,
            'matches' => $matches,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

    public function platform($vars) {
        $json = json_decode(file_get_contents(__DIR__.'/../../../emurelation/platforms/local.json'), true);
        if (isset($vars['id'])) {
            $id = $vars['id'];
        }
        $json = $json[$id];
        global $cachedSources;
        if (!isset($cachedSources)) {
            $cachedSources = [];
        }
        $matches = [];
        if (isset($json['matches'])) {
            foreach ($json['matches'] as $matchSourceId => $matchIds) {
                if (isset($cachedSources[$matchSourceId])) {
                    $matchSource = $cachedSources[$matchSourceId];
                } else {
                    if (file_exists(__DIR__.'/../../../emulation-data/'.$matchSourceId.'.json')) {
                        $matchSource = json_decode(file_get_contents(__DIR__.'/../../../emulation-data/'.$matchSourceId.'.json'), true);
                        $cachedSources[$matchSourceId] = $matchSource;
                    } else {
                        continue;
                    }
                }
                if (!isset($matches[$matchSourceId])) {
                    $matches[$matchSourceId] = [];
                }
                foreach ($matchIds as $matchId) {
                    if (isset($matchSource['platforms'])) {
                        $matches[$matchSourceId][$matchId] = json_encode($matchSource['platforms'][$matchId], JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE |  JSON_UNESCAPED_SLASHES);
                    }
                }
            }

        }
        echo $this->twig->render('platform.twig', [
            'data' => $json,
            'matches' => $matches,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

    public function game($vars) {
        $json = json_decode(file_get_contents(__DIR__.'/../../../emurelation/games/local.json'), true);
        if (isset($vars['id'])) {
            $id = $vars['id'];
        }
        $json = $json[$id];
        global $cachedSources;
        if (!isset($cachedSources)) {
            $cachedSources = [];
        }
        $matches = [];
        if (isset($json['matches'])) {
            foreach ($json['matches'] as $matchSourceId => $matchIds) {
                if (isset($cachedSources[$matchSourceId])) {
                    $matchSource = $cachedSources[$matchSourceId];
                } else {
                    if (file_exists(__DIR__.'/../../../emulation-data/'.$matchSourceId.'.json')) {
                        $matchSource = json_decode(file_get_contents(__DIR__.'/../../../emulation-data/'.$matchSourceId.'.json'), true);
                        $cachedSources[$matchSourceId] = $matchSource;
                    } else {
                        continue;
                    }
                }
                if (!isset($matches[$matchSourceId])) {
                    $matches[$matchSourceId] = [];
                }
                foreach ($matchIds as $matchId) {
                    if (isset($matchSource['games'])) {
                        $matches[$matchSourceId][$matchId] = json_encode($matchSource['games'][$matchId], JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE |  JSON_UNESCAPED_SLASHES);
                    }
                }
            }

        }
        echo $this->twig->render('game.twig', [
            'data' => $json,
            'matches' => $matches,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

}
