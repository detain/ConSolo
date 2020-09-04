<?php
require_once __DIR__.'/../src/bootstrap.php';
/**
* @var \Workerman\MySQL\Connection
*/
global $db;
global $config, $curl_config;
$response = [];
if (isset($_REQUEST['id'])) {
	$id = (int)$_REQUEST['id'];
	$json = json_decode($db->single("select doc from tmdb_movie where id={$id} limit 1"), true);
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>CodePen - TheMovieDB Movie Details bootstrap</title>
  <meta name="viewport" content="width=device-width, initial-scale=1"><link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://rawgit.com/yesmeck/jquery-jsonview/master/dist/jquery.jsonview.css'>
<link rel='stylesheet' href='css/movie.css'>
</head>
<body>
<!-- partial:index.partial.html -->
<nav class="navbar navbar-inverse navbar-static-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">ConSolo</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#">Files</a></li>
					<li><a href="#links" aria-controls="links" role="tab" data-toggle="tab">Links</a></li>
					<li><a href="#">Settings</a></li>
					<li><a href="#">About</a></li>
				</ul>
				<form class="navbar-form navbar-right">
					<input type="text" class="form-control" placeholder="Search...">
				</form>
			</div>
		</div>
	</nav>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3 col-md-2 sidebar">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">ConSolo</a>
				</div>
				<ul class="nav nav-sidebar" style="padding-top: 40px">
					<li class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Details <span class="sr-only">(current)</span></a></li>
					<li><a href="#">Movies</a></li>
					<li><a href="#">TV Shows</a></li>
					<li><a href="#">Files</a></li>
					<li><a href="#">Music</a></li>
					<li><a href="#">Emulation</a></li>
					<li><a href="#json" aria-controls="json" role="tab" data-toggle="tab">JSON Data View</a></li>
				</ul>
				<ul class="nav nav-sidebar">
					<li><a href="">Genres</a></li>
					<li><a href="">Production Companies</a></li>
					<li><a href="">Collections</a></li>
					<li><a href="">People</a></li>
				</ul>
			</div>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active" id="home">
						<div class="row" style='background-image: url("https://image.tmdb.org/t/p/w1920_and_h800_multi_faces/mz75dVXfen4J1Z0R8DbTenXNywz.jpg"); background-position: right -200px top;background-size: cover;background-repeat: no-repeat;border-bottom: 1px solid rgba(2.35%, 43.53%, 84.71%, 1);'>
							<div style="background-image: linear-gradient( to right, rgba(0%, 40%, 80%, 1) 150px, rgba(4.71%, 47.06%, 89.41%, 0.84) 100% );display: flex;justify-content: center;flex-wrap: wrap;">
								<div class="col-xs-6 col-md-4">
									<div class="poster">
										<div class="image_content backdrop">
											<img class="poster" src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/8o2ADoAyG796UwTjwBFjPyBz0yG.jpg">
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-8">
									<div class="header_poster_wrapper true">
										<section class="header poster" style="color: #ffffff;">
											<div class="title ott_true" dir="auto">
												<h2 class="14">
													<a href="/movie/{{ item.id }}-101-dalmations" style="color: #ffffff;">101 Dalmatians</a>
													<span class="tag release_date">(1996)</span>
												</h2>
												<div class="facts">
													<span class="certification">
														G
													</span>
													<span class="release">
														1996-11-17 (US)
													</span>
													<span class="genres" v-for="(genre, index) in item.genres">
														<a href="/genre/{{ genre.id }}-{{ genre.name | slugify }}/movie">Family</a>
														<span v-if="index == genres.length - 1">,&nbsp;</span>
													</span>
													<span class="runtime">
														1h 43m
													</span>
												</div>
											</div>
											<ul class="auto actions">
												<li class="chart">
													<div class="consensus details">
														<div class="outer_ring">
															58%
														</div>
													</div>
												</li>
												<li class="video none">
													<a class="no_click play_trailer" href="#" :data-site="item.videos.results[0].site" :data-id="item.videos.results[0].key" data-title="Play {{ item.videos.results[0].type }}"><span class="glyphicon glyphicon-play invert svg"></span> Play {{ item.videos.results[0].type }}</a>
												</li>
											</ul>
											<div class="header_info">
												<h3 class="tagline" dir="auto">{{ item.tagline }}.</h3>
												<h3 dir="auto">Overview</h3>
												<div class="overview" dir="auto">
													<p>{{ item.overview }}</p>
												</div>
												<ol class="people no_image">
													<li class="profile">
														<p><a href="/person/{{ director.id }}-{{ director.name | slugify }}">{{ director.name }}</a></p>
														<p class="character">{{ director.job }}</p>
													</li>
													<li class="profile">
														<p><a href="/person/{{ screenplay.id }}-{{ screenplay.name | slugify }}">{{ screenplay.name }}</a></p>
														<p class="character">{{ screenplay.job }}</p>
													</li>
												</ol>
											</div>
										</section>
									</div>

								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 col-xs-12">
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6 col-md-4">
								<div class="thumbnail">
									<img data-src="holder.js/100%x200" alt="100%x200" style="height: 200px; width: 100%; display: block;" src="" data-holder-rendered="true">
									<div class="caption">
										<h3>Thumbnail label</h3>
										<p>Second Line</p>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-md-4">
								<div class="thumbnail">
									<img data-src="holder.js/100%x200" alt="100%x200" style="height: 200px; width: 100%; display: block;" src="" data-holder-rendered="true">
									<div class="caption">
										<h3>Thumbnail label</h3>
										<p>Second Line</p>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-md-4">
								<div class="thumbnail">
									<img data-src="holder.js/100%x200" alt="100%x200" style="height: 200px; width: 100%; display: block;" src="" data-holder-rendered="true">
									<div class="caption">
										<h3>Thumbnail label</h3>
										<p>Second Line</p>
									</div>
								</div>
							</div>
						</div>

						<div class="row placeholders">
							<div class="col-xs-6 col-sm-3 placeholder">
								<img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
								<h4>Label</h4>
								<span class="text-muted">Something else</span>
							</div>
							<div class="col-xs-6 col-sm-3 placeholder">
								<img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
								<h4>Label</h4>
								<span class="text-muted">Something else</span>
							</div>
							<div class="col-xs-6 col-sm-3 placeholder">
								<img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
								<h4>Label</h4>
								<span class="text-muted">Something else</span>
							</div>
							<div class="col-xs-6 col-sm-3 placeholder">
								<img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
								<h4>Label</h4>
								<span class="text-muted">Something else</span>
							</div>
						</div>

						<h2 class="sub-header">Section title</h2>
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Header</th>
										<th>Header</th>
										<th>Header</th>
										<th>Header</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>1,001</td>
										<td>Lorem</td>
										<td>ipsum</td>
										<td>dolor</td>
										<td>sit</td>
									</tr>
									<tr>
										<td>1,005</td>
										<td>Nulla</td>
										<td>quis</td>
										<td>sem</td>
										<td>at</td>
									</tr>
									<tr>
										<td>1,006</td>
										<td>nibh</td>
										<td>elementum</td>
										<td>imperdiet</td>
										<td>Duis</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="row">
							<div class="col-md-12" id="json-view">

							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane fade" id="json">
					</div>
					<div role="tabpanel" class="tab-pane fade" id="links">
						<h3>Links</h3>
						<ul class="list-group">
							<li class="list-group-item"><a href="https://getbootstrap.com/docs/3.4/css/" target="_blank">BootStrap Docs</a></li>
							<li class="list-group-item"><a href="https://github.com/yesmeck/jquery-jsonview" target="_blank">jQuery JSONView</a></li>
							<li class="list-group-item"><a href="https://www.themoviedb.org/tv/63174-lucifer" target="_blank">TV Example</a></li>
							<li class="list-group-item"><a href="https://www.themoviedb.org/person/515-glenn-close" target="_blank">Person Example</a></li>
							<li class="list-group-item"><a href="https://www.themoviedb.org/movie/11674-101-dalmatians/cast" target="_blank">Movie Cast Example</a></li>
							<li class="list-group-item"><a href="https://www.themoviedb.org/genre/35-comedy/movie" target="_blank">Comedy Genre Movie List Example</a></li>
							<li class="list-group-item"><a href="" target="_blank"></a></li>
							<li class="list-group-item"><a href="" target="_blank"></a></li>
							<li class="list-group-item"><a href="" target="_blank"></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-jsonview/1.2.3/jquery.jsonview.min.js'></script>
<script src='https://rawgit.com/yesmeck/jquery-jsonview/master/dist/jquery.jsonview.css'></script>
<script src='js/movie.js'></script>
</body>
</html>
