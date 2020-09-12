const urlParams = new URLSearchParams(window.location.search);
const movieId = urlParams.get('id');
$(document).ready(function () {

	$.getJSON("https://consolo.is.cc/item.php?type=movie&id="+movieId, function (data) {
		console.log(data);
		$("#json").JSONView(data, { collapsed: true });
	});
	$('.nav-sidebar li a[data-toggle="tab"]').click(function (e) {
		e.preventDefault();
		$(".nav-sidebar li.active").removeClass("active");
		$(this).tab("show");
	});
});
