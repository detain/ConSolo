// https://api.themoviedb.org/3/configuration?api_key=94a2f36cd4e27626b6a7a07766a76196
$(document).ready(function () {
	var apiKey = "94a2f36cd4e27626b6a7a07766a76196";
	var imagePath = '';
	var sizeOptions = '';
	var logo_sizes = '';	
	var poster_sizes = '';
	var profile_sizes = '';
	var siteConfig = 'https://api.themoviedb.org/3/configuration?api_key='+apiKey;
	$.getJSON(siteConfig, function(results) {
		console.log(results);
		imagePath = results.images.base_url;
		sizeOptions = results.images.poster_sizes;
		// 0: "w92", 1: "w154", 2: "w185", 3: "w342", 4: "w500", 5: "w780", 6: "original"
		posterSize = 'w154';
		logo_size = logo_sizes['original'];
		profileSize = profile_sizes['original'];
	});
	$('#search').click(function() {
		var input = $('#search-input').val(),
		movieName = encodeURI(input);
		console.log("Searched for: " + movieName);
		var url = 'https://api.themoviedb.org/3/search/movie?api_key=' + apiKey + '&query=' + movieName;
		console.log(url);
		$.getJSON(url, function (json) {
			var movieID =  json.results[0].id ;
			console.log("movie ID: " + movieID);
			//var imageUrl = 'http://image.tmdb.org/t/p/w154';
			// videoUrl allows access to YouTube videos @ "videos": { "results": [ ] ...
			var videoUrl = 'https://api.themoviedb.org/3/movie/' + movieID + '?api_key=' + apiKey + '&append_to_response=alternative_titles,credits,similar,videos';
			$.getJSON(videoUrl, function (data) {
				console.log(data);
				var cast = data.credits.cast;
				var youTube = "https://www.youtube.com/embed/";
				var tr;
				tr = $('<tr/>');
				tr.append("<td>" + data.title + "</td>");
				tr.append("<td><img src=" + imagePath + posterSize + data.poster_path + "></td>");
				tr.append("<td>" + data.release_date.substr(0, 4) + "</td>");
				tr.append("<td><img src=" + imagePath + posterSize + data.backdrop_path + "></td>");
				tr.append("<td style='min-width:200px;'>" + data.overview + "</td>");
				tr.append("<td style='min-width:200px;'><div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' src=" + youTube + data.videos.results[0].key + "?html5=1' frameborder='0'></iframe></div></td>");
				cast.forEach(function(profile) {
					console.log(profile);
					tr.append("<td>" + profile.character + "<img src=" + imagePath + posterSize + profile.profile_path + ">" + profile.name + "</td>");
				});
				$('#imdb').append(tr);
			});
		})
	})
	$('#clear').click(function() {
		$("#tbodyid").empty();
	});
});