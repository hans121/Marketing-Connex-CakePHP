<h1>TwitterCallback</h1>
<pre>
	<?php print_r($twitterCallback); ?>
</pre>

<?php
	foreach($twitterCallback as $tweet) {
		echo $tweet->text;
	}
?>
