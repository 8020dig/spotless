jQuery(document).ready(function($){
	// script to change the content of main search form
	$(".search-handler").click(function(){
		$(this).find(".search-field").attr("placeholder", "Search Spotless.com.au");
	});
});