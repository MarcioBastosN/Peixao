$(document).ready(function(){
	$('#top-link').topLink({
		min: 400,
		fadeSpeed: 500
	});
	$('#top-link').click(function(e) {
		e.preventDefault();
		window.scrollTo(0,0);
	});		
});