<?php

namespace Detain\ConSolo\Models;

class Api extends Base {

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
			$json = json_decode($db->single("select doc from tmdb_movie where id={$id} limit 1"), true);
		}
		$fileId = $db->single("select id from files where tmdb_id={$json['id']} and host={$hostId}");
		echo $twig->render('movie.twig', [
			'movie' => $json,
			'fileId' => $fileId,
			'queryString' => $_SERVER['QUERY_STRING']
		]);
		
	}    

	public function genres() {
		
	}    

	public function collections() {
		
	}    

	public function people() {
		
	}    

	public function tv() {
		
	}    
}  
