(function ($) {
	$(".judge-familiar-stacked-pills .nav-link").click(function (event) {
		document.location.hash = this.getAttribute("href");
	});

	if (document.location.hash) {
		$(".judge-familiar-stacked-pills .nav-pills a[href=" + document.location.hash + "]").tab("show");
	}
})(jQuery);
