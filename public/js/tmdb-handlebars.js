function getMovie() {	
	// Don't cache data when using SetTimeout 
	// $.ajaxSetup({ cache: false });
	// Alien 1979 - ID: 348
	// Deadpool 2016 - ID: 293660
	$.getJSON("https://api.themoviedb.org/3/movie/293660?api_key=94a2f36cd4e27626b6a7a07766a76196&append_to_response=credits,person,videos",
		// $.getJSON("https://api.themoviedb.org/3/movie/293660?api_key=94a2f36cd4e27626b6a7a07766a76196&append_to_response=keywords,credits,person,images,videos",
		function(data, status) {

			console.log(data, status);

			// Helper to limit Videos and Cast to a 'set' number (see Handlebars template)
			Handlebars.registerHelper('each_upto', function(ary, max, options) {
				if(!ary || ary.length == 0)
					return options.inverse(this);

				var result = [ ];
				for(var i = 0; i < max && i < ary.length; ++i)
					result.push(options.fn(ary[i]));
				return result.join('');
			});

			// Format release dates
			var DateFormats = {
				short: 	"YYYY",
				med: 		"MMMM YYYY",
				long: 	"MMMM Do, YYYY"
			};
			Handlebars.registerHelper('formatDate', function(release_date, format) {
				format = DateFormats[format] || format;
				return moment(release_date).format(format);
			});

			var source = $("#simple-template").html();
			var template = Handlebars.compile(source);
			var html = template(data);

			console.log(data, status);

			$("#main").html(html);

	})
	.done(function() {
		console.log( ".done" );

		/*
		// refresh function (when workingwith "live" data)
		setTimeout(function() {
		console.log('REFRESH DATA');
		getMovie();
		}, 60000);	// = 1 minute | 60000 * 5 = 5 minutes
		*/
	})

	.fail(function() {
		console.error( ".fail" );
		/*
		var i = 10;
		var cntDwn = setInterval(function() {
		if(i==0){
		getMovie();
		console.log('ERROR REFRESH');
		clearInterval(cntDwn);
		} else {
		document.getElementById('countdown').innerHTML = i--;
		//console.log(i--);
		}
		}, 1000);
		*/

	})

	.always(function() {
		// Stuff to do every single time the script runs
		console.info( ".always" );
	})

};
// uncomment below to create a run function
getMovie()

// Perform other work here ...


/* Fetching a Cast members detials */
function render(ID) {
	console.log(ID);
	$.getJSON( 'https://api.themoviedb.org/3/person/'+ ID +'?api_key=94a2f36cd4e27626b6a7a07766a76196&language=en-US&append_to_response=credits', 
		function(data, status) {
			console.log(data, status);

			var source = $("#bioTemplate").html();
			var template = Handlebars.compile(source);
			var html = template(data);

			$("#castBio").html(html);
	})
};


$('#myModal').on('hidden.bs.modal', function () {
	$(this).removeData('bs.modal');
});


/*
REF:
poster_path: "http://image.tmdb.org/t/p/"

"backdrop_sizes": [
"w300",
"w780",
"w1280",
"original"
],
"logo_sizes": [
"w45",
"w92",
"w154",
"w185",
"w300",
"w500",
"original"
],
"poster_sizes": [
"w92",
"w154",
"w185",
"w342",
"w500",
"w780",
"original"
],
"profile_sizes": [
"w45",
"w185",
"h632",
"original"
],
"still_sizes": [
"w92",
"w185",
"w300",
"original"
]

*/