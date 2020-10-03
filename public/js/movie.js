//const urlParams = new URLSearchParams(window.location.search);
//const movieId = urlParams.get('id');
$(document).ready(function () {
	var player = videojs('my-player', {
		controls: true,
		autoplay: false,
		preload: 'auto'
	}, function() {
		//this.hlsQualitySelector({ displayCurrentQuality: true });
	});
	//$.getJSON("https://consolo.is.cc/item.php?type=movie&id="+movieId, function (data) {
		//$("#json").JSONView(data, { collapsed: true });
	//});
	$("#json").JSONView(movie, { collapsed: true });
	$('.nav-sidebar li a[data-toggle="tab"]').click(function (e) {
		e.preventDefault();
		$(".nav-sidebar li.active").removeClass("active");
		$(this).tab("show");
	});
});
