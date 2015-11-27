
<?php
if ($email_type=='customer') {	
?>
<!-- This can be filled when customer email is needed in future -->

<?php
}  else {
?>	
	<p>A new enquiry has been received from <strong><a href="<?= $landingpage ?>"><?= $landingpage ?> landing page</a></strong></p>
	<p>Details as follows:</p>
	<p>
		<strong>Name</strong>: <?= $firstname . ' ' . $lastname ?><br/>
		<strong>Email</strong>: <?= $email ?><br/>
		<strong>Website</strong>: <?= $website ?><br/>
		<strong>Phone</strong>: <?= $phone ?><br/>
		<strong>Information Requested</strong>: <?= $info ?>
	</p>

<?php	
}
?>	

