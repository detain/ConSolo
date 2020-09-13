(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
	'use strict';

	$(function () {

		$('.main-watchlist').perfectScrollbar();
		var tvShows = $('#main').find('.watchlist');

		tvShows.hide();

		var key = '6459fcd631e69317f25758b82f77615d';
		var img_key = 'https://image.tmdb.org/t/p/w500';

		var template = '\n    <div class="col s10 push-s1 m6 l3 movie" data-id=":id:">\n        <div class="datas">\n            <img class="center responsive-img" src=":img:" alt=":img alt:">\n            <div class="data-info">\n            <div class="category">MOVIE</div>\n            <div class="movie-title">:name:</div>\n            <div class="like">\n                <i class="material-icons">thumb_up</i>\n                :likes: Likes\n                </div>\n            </div>\n            <div class="play circle scale-transition">\n                <i class="material-icons">play_arrow</i>\n            </div>\n        </div>\n    </div>';

		function renderShow(shows) {
			$('.load').fadeOut(1000);
			shows.forEach(function (show, i) {
				col = template.replace(':name:', show.title ? show.title : '').replace(':id:', show.id ? show.id : '').replace(':img:', show.poster_path ? img_key + show.poster_path : 'images/no-image.jpg').replace(':img alt:', show.name ? show.name + " Logo" : '').replace(':country:', show.network ? show.network.country.name : '').replace(':likes:', show.vote_count ? show.vote_count : '');

				var col = $(col);
				tvShows.append(col);
			});
			tvShows.delay(1500).fadeIn(1000);
			$('.movie').click(function () {
				$('#back').removeClass('disabled');
				$('#trailer').removeClass('disabled');
				$('.movie-view').hide();
				$('.movie-view-list').remove();
				var templateMovie = '\n        <div class="movie-view-list" data-id=":id:">\n          <div class="col s12 movie-view-title">\n            <small>MOVIES</small>\n            <h1>:title:</h1>\n          </div>\n          <div class="col s12 valign-wrapper popularity">\n            <div class="col s12 m4 l2 stars">\n                <i id="star1" class="material-icons ">star</i>\n                <i id="star2" class="material-icons">star</i>\n                <i id="star3" class="material-icons">star</i>\n                <i id="star4" class="material-icons">star</i>\n                <i id="star5" class="material-icons">star</i>\n            </div>\n            <div class="col s12 m10 movie-view-like">\n              <i class="material-icons">thumb_up</i> :likes: Likes\n            </div>\n          </div>\n          <div class="col s12 divider"></div>\n          <div class="col s10 m8 l6 geners">\n            <ul>\n            </ul>\n          </div>\n          <div class="col s2 m4 l6 right-align trailer">\n            <div class="trailer-play circle">\n              <i class="material-icons">play_arrow</i>\n            </div>\n          </div>\n        </div>';

				var id = $(this).attr('data-id');
				$.ajax({
					"async": true,
					"crossDomain": true,
					"url": 'https://api.themoviedb.org/3/movie/' + id + '?api_key=' + key + '&language=en-US',
					"method": "GET",
					"headers": {},
					"data": "{}"
				}).then(function (show) {
					var average = Math.round(show.vote_average * 5 / 10);
					var gener = show.genres;

					$('.movie-view').css('background-image', 'url(https://image.tmdb.org/t/p/w1280' + show.backdrop_path + ')');

					col = templateMovie.replace(':title:', show.title ? show.title : '').replace(':id:', show.id ? show.id : '').replace(':likes:', show.vote_count ? show.vote_count : '');

					var col = col;
					$('.movie-view').append(col);

					for (var i = 0; i <= average; i++) {
						var star = '#star' + i;
						$('.stars').children(star).addClass('star-active');
					}
					gener.forEach(function (gener) {
						$('.geners ul').append('<li>' + gener.name + '</li>');
					});

					$('.main-watchlist').fadeOut(1000);
					$('.movie-view').delay(1000).fadeIn(1000);
					$('.trailer-play').click(function () {

						playTrailer();
					});
				});
			});
		}

		function loadMovies() {
			var settings = {
				"async": true,
				"crossDomain": true,
				"url": 'https://consolo.is.cc/list.php?page=1&language=en-US&api_key=' + key,
				"method": "GET",
				"headers": {},
				"data": "{}"
			};
			if (!localStorage.shows) {
				$.ajax(settings).then(function (shows) {

					localStorage.shows = JSON.stringify(shows.results);
					renderShow(shows.results);
				});
			} else {
				renderShow(JSON.parse(localStorage.shows));
			}
		}
		function playTrailer() {
			var breakVideo = false;
			var id = $('.movie-view-list').attr('data-id');
			var videoTemplate = '       \n        <div class="video-responsive">\n          <iframe src="https://www.youtube.com/embed/:video:?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>\n        </div>';
			$.ajax({
				"async": true,
				"crossDomain": true,
				"url": 'https://api.themoviedb.org/3/movie/' + id + '/videos?api_key=6459fcd631e69317f25758b82f77615d&language=en-US',
				"method": "GET",
				"headers": {},
				"data": "{}"
			}).then(function (show) {
				videos = show.results;
				videos.forEach(function (a) {
					if (a.site === "YouTube") {

						if (a.type === "Trailer" && breakVideo === false) {

							console.log(a.key);
							col = videoTemplate.replace(':video:', a.key);

							breakVideo = true;
						}
					}
				});

				var col = $(col);
				$('.video-trailer').append(col).fadeIn(1000);
				$('.close-trailer').click(function () {
					$('.video-responsive').fadeOut(1000).delay(1000).remove();
					$('.video-trailer').fadeOut(1000);
				});
			});
		}
		$('#search').find('form').submit(function (ev) {
			ev.preventDefault();
			var search = $(this).find('input[type="text"]').val();
			searchMovie(search);
		});

		function searchMovie(search) {

			tvShows.find('.movie').remove();
			$('.load').show();
			$.ajax({
				url: 'https://consolo.is.cc/list.php?api_key=' + key + '&language=en-US&query=' + search + '&include_adult=false',
				data: {},
				success: function success(res, textStatus, xhr) {
					if (res.results.length > 0) {
						var shows = res.results.map(function (show) {
							return show;
						});
						renderShow(shows);
					} else {
						tvShows.append('<h4>No hay resultados para <spam>' + search + '</spam></h4>');
						$('.load').fadeOut();
					}
					$('.main-watchlist').scrollTop(0);
					closeMenu();
				}
			});
		}

		//Cargar zona de peliculas de Upcoming
		function loadUpcoming() {
			var upcommingSettings = {
				"async": true,
				"crossDomain": true,
				"url": 'https://consolo.is.cc/list.php?api_key=' + key + '&language=en-US&page=1',
				"method": "GET",
				"headers": {},
				"data": "{}"
			};
			var upcoming = $('.upcoming-list ul li');
			$.ajax(upcommingSettings).then(function (shows) {
				var upcomingTemplate = '\n                <div class="col m12 upcoming-movie">\n                  <img class="center responsive-img" src=":img:" alt=":img alt:">\n                </div>';
				var show = shows.results;
				for (var i = 0; i < 3; i++) {
					col = upcomingTemplate.replace(':img:', show[i].poster_path ? img_key + show[i].poster_path : '').replace(':img alt:', show[i].name ? show[i].name + " Logo" : '');
					var col = $(col);
					upcoming.append(col);
				}
			});
		}

		//comprobar si los link del menu estan presionados o no
		function enableMenu(e) {
			if ($(e).hasClass('active-menu')) {
				$(e).removeClass('active-menu');
				return false;
			} else {
				$(e).addClass('active-menu');
				return true;
			}
		}
		//Cierra el menu de busqueda

		function closeMenu() {
			$('.menu-section').fadeOut(); //desaparece el menu
			enableMenu($('#search-link')); //poner al link en su estado original
			alert();
		}

		$('.navbar li').click(function (e) {

			if ($(this).attr('data-activities') === 'back') {
				$('#back').addClass('disabled');
				$('#trailer').addClass('disabled');

				$('.main').css('background-image', 'none');
				$('.main').find('.movie-view-list').remove();
				$('.movie-view').hide();
				$('.main-watchlist').fadeIn();
				$('.head-info').fadeIn();
			}
			if ($(this).attr('data-activities') === 'search') {
				if (enableMenu(this) === true) {
					$('.menu-section').fadeIn();
				} else {
					closeMenu();
				}
			}
			if ($(this).attr('data-activities') === 'trailer') {
				playTrailer();
			}

			if ($(this).attr('data-activities') === 'refresh') {
				location.reload();
			}

			if ($(this).attr('data-activities') === 'airplay') {
				if (enableMenu(this)) {
					launchIntoFullscreen(document.documentElement); // the whole page
				} else {
					exitFullscreen();
				}
			}
		});

		$('.close').click(function closeSearch() {
			closeMenu();
		});

		// Lanza full screen
		function launchIntoFullscreen(element) {
			if (element.requestFullscreen) {
				element.requestFullscreen();
			} else if (element.mozRequestFullScreen) {
				element.mozRequestFullScreen();
			} else if (element.webkitRequestFullscreen) {
				element.webkitRequestFullscreen();
			} else if (element.msRequestFullscreen) {
				element.msRequestFullscreen();
			}
		}
		// Cancela full screen
		function exitFullscreen() {
			if (document.exitFullscreen) {
				document.exitFullscreen();
			} else if (document.mozCancelFullScreen) {
				document.mozCancelFullScreen();
			} else if (document.webkitExitFullscreen) {
				document.webkitExitFullscreen();
			}
		}

		loadMovies();
		loadUpcoming();
	});

	},{}]},{},[1]);