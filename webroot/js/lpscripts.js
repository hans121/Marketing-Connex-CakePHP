$( document ).ready(function() {
	// Using jQuery Event API v1.3
	$('#external_link').on('click', function() {
		alert ($(this).text());
	  ga('send', 'event', 'External Link', 'click', 'ee');
	});

});