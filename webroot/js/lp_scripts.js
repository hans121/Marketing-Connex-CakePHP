$( document ).ready(function() {
	//Log Landing Page View:
	ga('send', 'event', 'Landing Page', 'Campaign', $( "input[name=campaign_desc]").val());
	ga('send', 'event', 'Landing Page', 'Vendor', $( "input[name=vendor_name]").val());
	
	// Using jQuery Event API v1.3
	$('#external_link').on('click', function() {
	  ga('send', 'event', 'External Link', 'click', $(this).text());
	});
	
	$('#download_link').on('click', function() {
	  ga('send', 'event', 'Landing Page', 'download', $( "input[name=vendor_name]").val()+' ('+$( "input[name=campaign_desc]").val()+')');
	});
	
	
	$("#landingForm").on('submit', function(e) {
		 ga('send', 'event', 'Landing Page', 'form submit', $(location).attr('href') );
	}); 
});