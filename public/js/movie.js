$(document).ready(function () {
	$.getJSON("https://consolo.is.cc/item.php?type=movie&id=11674", function (
		data
	) {
		$("#json").JSONView(data.movie, { collapsed: true });
	});
	$('.nav-sidebar li a[data-toggle="tab"]').click(function (e) {
		e.preventDefault();
		$(".nav-sidebar li.active").removeClass("active");
		$(this).tab("show");
	});
});
