$(document).ready(function() {

	// on signup click, hide login and show registration form
	$('#signup').click(function() {
		$('#first').slideUp('slow', function() {
			$('#second').slideDown('slow');
		});
	});

	// on signin click, hide register form and show login form
	$('#signin').click(function() {
		$('#second').slideUp('slow', function() {
			$('#first').slideDown('slow');
		});
	});

});