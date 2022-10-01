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
        $json = json_decode(file_get_contents(__DIR__.'/../../public/emurelation/sources.json'), true);
        unset($json['']);
        echo $this->twig->render('sources.twig', [
            'results' => $json,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

    public function emulators() {
        $json = json_decode(file_get_contents(__DIR__.'/../../public/emurelation/emulators/local.json'), true);
        echo $this->twig->render('emulators.twig', [
            'results' => $json,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

    public function companies() {
        $json = json_decode(file_get_contents(__DIR__.'/../../public/emurelation/companies/local.json'), true);
        echo $this->twig->render('companies.twig', [
            'results' => $json,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

    public function platforms() {
        $json = json_decode(file_get_contents(__DIR__.'/../../public/emurelation/platforms/local.json'), true);
        echo $this->twig->render('platforms.twig', [
            'results' => $json,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

    public function games() {
        $json = json_decode(file_get_contents(__DIR__.'/../../public/emurelation/games/local.json'), true);
        echo $this->twig->render('games.twig', [
            'results' => $json,
            'queryString' => $_SERVER['QUERY_STRING']
        ]);
    }

}
