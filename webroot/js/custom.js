// © 2015 Strategic Internet Consulting Limited
// Custom scripts



// Resize header on scroll
function resizeHeader() {
	var header = $('.frontend #header');
	var headerbg = $('.frontend #floating-header-bg');
	var headerspacer = $('.frontend #floating-header-spacer');
	var collapse = $('.frontend #bs-navbar-collapse-1');
	var logo = $('.frontend #brand-logo');
	var logoimg = $('.frontend #brand-logo-img');
	var scrollnav = $('.frontend #scroll-nav');
	var contactdetails = $('.frontend .contact-details');
	
    var scrolled = $(window).scrollTop();
	var logoimgrep = '';
	var scrolllimit = $('div#content').offset().top;
	
	if($('body.frontend #floating-header').length)
	if($(window).width()>751) //767 ideal but browser reads 751 for 767
		//Reducte header at point of start of contenr (under hero area) - DPH
		//var scrolllimit = $('div#content').offset().top;
		if(scrolled > scrolllimit)
		{
			// Call resize
			collapse.css('cssText','display:none !important');
			logo.css('cssText','background-position:-60px center');
			header.css('cssText','min-height:0');
			headerbg.css('cssText','height: 115px');
			//if(scrolled>=200)
				//headerspacer.css('cssText','height: 396px');
			logoimg.css('cssText','width:300px');
			logoimgrep = logoimg.attr('src');
			logoimgrep = logoimgrep.replace('logo-marketing-connex.png','logo-marketing-connex-shrunk.png');
			logoimg.attr('src',logoimgrep);
			scrollnav.css('cssText','display:block !important');
			contactdetails.css('cssText','top:0px');
		}
		else
		{
			// Resume size
			collapse.css('cssText','display:block !important');
			logo.css('backgroundPosition','');
			header.css('cssText','min-height:150px');
			headerbg.css('cssText','height: 196px');
			//if(scrolled<200)
				//headerspacer.css('cssText','height: 196px');
			logoimg.css('cssText','width:400px');
			logoimgrep = logoimg.attr('src');
			logoimgrep = logoimgrep.replace('logo-marketing-connex-shrunk.png','logo-marketing-connex.png');
			logoimg.attr('src',logoimgrep);
			scrollnav.css('cssText','display:none !important');
			contactdetails.css('cssText','top:23px');
		}
	else
	{
		collapse.css('display','');
		header.css('cssText','min-height:0');
		scrollnav.css('cssText','display:none !important');
		logoimgrep = logoimg.attr('src');
		logoimgrep = logoimgrep.replace('logo-marketing-connex-shrunk.png','logo-marketing-connex.png');
		logoimg.attr('src',logoimgrep);
		logoimg.css('cssText','width:400px');
		logo.css('backgroundPosition','');
	}
}
$(window).scroll(function() {	
	resizeHeader();
})
$(window).resize(function(){
	resizeHeader();
});

// Password strength meter - https://github.com/ablanco/jquery.pwstrength.bootstrap

$(document).ready(function() {
  $('#password').pwstrength({
		ui: {
			showVerdictsInsideProgressBar: false,
			errorMessages: {
			  wordLength: "Your password is too short",
			  wordNotEmail: "Do not use your email as your password",
			  wordSimilarToUsername: "Your password cannot contain your username",
			  wordTwoCharacterClasses: "Use different character classes",
			  wordRepetitions: "Too many repetitions",
			  wordSequences: "Your password contains sequences"
			},
			showErrors: true,
			showPopover: false,
			scores: [5, 25, 40, 50]
		}
  });
});


	 
var SITE = SITE || {};
 
SITE.fileInputs = function() {
	var $this = $(this),
	$val = $this.val(),
	valArray = $val.split('\\'),
	newVal = valArray[valArray.length-1],
	
	$button = $this.parent().siblings('.btn'),
	$fakeFile = $this.parent().siblings('.file-holder');
	
	//$fakeFile.attr('class', 'TEST');
	if(newVal !== '') {
		$button.text('File Chosen');
		if($fakeFile.length === 0) {
			$button.after('<span class="file-holder pull-right">' + newVal + '</span>');
		} else {
			$fakeFile.text(newVal);
		}
	}
};


	 
$(document).ready(function() {

  //Run Select Picker
  $('.select select, .date select').selectpicker();   


	$('.file-wrapper input[type=file]').bind('change focus click', SITE.fileInputs);

	var isIE8 = $('html').hasClass('ie8');
	
	if (isIE8) {
		$(".onoffswitch-label").bind('change click', function() {
         if ($(this).prev('.onoffswitch-checkbox').attr('checked') == "checked") {
             $(this).prev('.onoffswitch-checkbox').attr('checked', false);
         }
         else {
             $(this).prev('.onoffswitch-checkbox').attr('checked', true);
         }
     });
  };
       

});


	// Activate the Bootstrap 3 'popover' function for tooltips - sitewide //

$(document).ready(function() {
	$('[data-toggle="popover"]').popover({
	    trigger: 'hover',
	        'placement': 'top'
	});
	
});



	// Show/hide toggle of a span with class "show-area" or "hide-area" depending on initial state.  Set class of checkbox to "show-hide-toggle"
	// Remember to set the default visibility in CSS with display: block/none

$(function () {
  $('.show-hide-toggle').change(function () {                
     $('.show-area').toggle(this.checked);
     $('.hide-area').toggle(!this.checked);
  }).change();
});



	// initialize jQuery UI datepicker

$(function() {
	$( "#datepicker" ).datepicker( {dateFormat:"dd/mm/yy"} );
	$( "#datetimepicker" ).datetimepicker( {dateFormat:"dd/mm/yy"} );
	$( "#timepicker" ).timepicker();
});



	
