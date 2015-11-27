<?php
if (isset($custom_code)) {
	echo $custom_code;
} else {
?>	


<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width" name="viewport">

    <title>Email Archive:  <?=$code_subject_line ?></title>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-57286022-1', 'auto');
		  ga('send', 'pageview');
		
		</script>	

</head>

<body>
	<?php
		echo $viewhtml;	
	?>
</body>
</html>
<?php
};
?>	
