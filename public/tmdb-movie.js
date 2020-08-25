var windowWidth = $(window).width();
var windowHeight = $(window).height();
$(document).on("mousemove", function(e) {
	var mouseX = e.pageX;
	var mouseY = e.pageY;
	var centerX = windowWidth / 2;
	var centerY = windowHeight / 2;
	var position = $("#bk").position();
	if (mouseX > centerX && mouseY < centerY) {
		console.log("to right top");
		position.left = position.left - 30;
		position.top = position.top + 30;
		$("#bk").css({
			left: position.left + "px",
			top: position.top + "px"
		});
	} else if (mouseX < centerX && mouseY < centerY) {
		console.log("to left top");
		position.left = position.left + 30;
		position.top = position.top + 30;
		$("#bk").css({
			left: position.left + "px",
			top: position.top + "px"
		});
	} else if (mouseX > centerX && mouseY > centerY) {
		console.log("to right bottom");
		position.left = position.left - 30;
		position.top = position.top - 30;
		$("#bk").css({
			left: position.left + "px",
			top: position.top + "px"
		});
	} else {
		console.log("to left bottom");
		position.left = position.left + 30;
		position.top = position.top - 30;
		$("#bk").css({
			left: position.left + "px",
			top: position.top + "px"
		});
	}
});

Vue.component('item', {
	template: '#item-box',
	props: ['movie'],
	data: {
		movie: []
	},
	mounted: function(){
		this.movie.poster_path = "https://image.tmdb.org/t/p/w500/" + this.movie.poster_path;
		$(".item").mouseover(function(){
			$(this).addClass('flip');
		})
		.mouseout(function() {
			$(this).removeClass('flip');
		});
	}
})
var app = new Vue({
	el: '#app',
	data: {
		movies: []
	},
	mounted: function(){
		var vobj = this;
		$.get("https://api.themoviedb.org/3/movie/top_rated?api_key=9485567a0e78094c4eefe449afa30437&language=en-US&page=1").then(function(res) {
			vobj.movies = res.results;
		});
	}
});