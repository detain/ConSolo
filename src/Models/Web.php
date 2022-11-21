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

    public function emulators_new() {
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
        sort($platforms);
        ksort($companies);
        ksort($jsonEmus);
        echo $this->twig->render('emulators_new.twig', [
            'companies' => $companies,
            'platResults' => $jsonPlats,
            'platforms' => $platforms,
            'results' => $jsonEmus,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

    public function emulators() {
        $json = json_decode(file_get_contents(__DIR__.'/../../../emurelation/emulators/local.json'), true);
        echo $this->twig->render('emulators.twig', [
            'results' => $json,
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
        if (isset($vars['id'])) {
            $id = $vars['id'];
        }
        $json = $json[$id];
        if (file_exists(__DIR__.'/../../../emulation-data/'.$id.'.json')) {
            $json['data'] = file_get_contents(__DIR__.'/../../../emulation-data/'.$id.'.json');
        }
        echo $this->twig->render('source.twig', [
            'data' => $json,
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
