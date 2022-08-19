<?php

namespace Detain\ConSolo\Models;

class Api extends Base {

	public function index() {
		
	}    

	public function movies() {
		$limit = 100;
		$rows = $this->db->query("select tmdb_movie.id, title, poster_path, vote_average, overview, release_date from movies left join tmdb_movie on tmdb_movie.id=movies.tmdb_id left join files on file_id=files.id where host={$this->hostId} and title is not null order by title limit {$limit}");
		header('Content-type: application/json; charset=UTF-8');
		echo json_encode($rows, getJsonOpts());
	}
	
	public function movie($vars) {
		$response = [];
		
		$id = (int)$vars['id'];
		$json = json_decode($this->db->single("select doc from tmdb_movie where id={$id} limit 1"), true);
		$json['fileId'] = $this->db->single("select id from files where tmdb_id={$json['id']} and host={$this->hostId}");
		header('Content-type: application/json; charset=UTF-8');
		echo json_encode($json, getJsonOpts());
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
		header('Content-type: application/json; charset=UTF-8');
		echo json_encode($genres, getJsonOpts());
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
}  
