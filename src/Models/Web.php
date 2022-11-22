<?php

namespace Detain\ConSolo\Models;

class Web extends Base {

	public function index() {

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
        foreach ($jsonEmus as $emuId => $emuData) {
            if (!isset($emuData['platforms']) || count($emuData['platforms']) == 0) {
                $emuData['platforms'] = ['Unknown'];
                $jsonEmus[$emuId]['platforms'] = ['Unknown'];
            }
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
        echo $this->twig->render('platforms.twig', [
            'results' => $json,
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
        $matchNames = [$json['name']];
        $matchCompanies = [];
        if (isset($json['company'])) {
            $matchNames[] = $json['company'].' '.$json['name'];
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
            $targetNames = [$data['name']];
            $targetCompanies = [];
            if (isset($data['company'])) {
                $targetNames[] = $data['company'].' '.$data['name'];
                $targetCompanies[] = $data['company'];
            }
            foreach ($matchNames as $matchName)
                foreach ($targetNames as $targetName) {
                    $levenshtein += levenshtein($matchName, $targetName, $insertCost, $replaceCost, $deleteCost);
                    $soundex += levenshtein(soundex($matchName), soundex($targetName), $insertCost, $replaceCost, $deleteCost);
                    $metaphone += levenshtein(metaphone($matchName), metaphone($targetName), $insertCost, $replaceCost, $deleteCost);
                    similar_text($matchName, $targetName, $percent);
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
                $targetName = (isset($data['company']) ? $data['company'].' ' : '').$data['name'];
                echo "{$targetName}<br>";
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
        if (!$this->validType($type)) {
            echo "Invalid Type {$type}";
            return;
        }
        if (!$this->validSource($sourceId)) {
            echo "Invalid Source {$sourceId}";
            return;
        }
        $missing = [];
        $json = json_decode(file_get_contents(__DIR__.'/../../../emurelation/'.$type.'/local.json'), true);
        foreach ($json as $id => $data) {
            if (!isset($data['matches']) || !isset($data['matches'][$sourceId])) {
                $missing[$id] = $data;
            }
        }
        echo $this->twig->render('missing.twig', [
            'results' => $missing,
            'sourceId' => $sourceId,
            'type' => $type,
            'singular' => $this->getSingular(),
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
