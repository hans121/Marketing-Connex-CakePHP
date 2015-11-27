<!DOCTYPE html>

<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if gt IE 8]><!--> <html>         <!--<![endif]-->

	<head>
	
		
		<title>
			Getty Images API
		</title>
		
		<?php
			//Search for images with an api key and show the output
			var apiKey = 'kd8858qa6vatc2vybusperw6';
			
			$.ajax(
			{
			type:'GET',
			url:"https://api.gettyimages.com/v3/search/images/creative?phrase=kitties",
			 beforeSend: function (request)
			    {
			        request.setRequestHeader("Api-Key", apiKey);
			    }})
			.done(function(data){
			console.log("Success with data")
			for(var i = 0;i<data.images.length;i++)
			{
			   $("#output").append("<img src='" + data.images[i].display_sizes[0].uri + "'/>");
			}
			})
			.fail(function(data){
			alert(JSON.stringify(data,2))
			});
			
		?>	
	</head>
	
	<body>
		<div id="output"></div>		
	</body>
</html>			
