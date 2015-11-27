
<?php
if ($email_type=='customer') {	
?>
	<p>Hello <?=$name ?>,<br/><br/>
	Thank you for contacting the team here at <strong><a href="<?= $site_url ?>"><?= $SITE_NAME ?></a></strong>.<br/><br/>
	We have received your details and someone will be back in touch as soon as possible.</p>
	<br/>
<?php
}  else {
?>	
	<p>A new enquiry has been received on the <strong><a href="<?= $site_url ?>/contact/"><?= $SITE_NAME ?> Contact Form</a></strong></p>
	<p>Details as follows:</p>
	<p>
		<strong>Name</strong>: <?= $name ?><br/>
		<strong>Company</strong>: <?= $company ?><br/>
		<strong>Position</strong>: <?= $position ?><br/>
		<strong>Email</strong>: <?= $email ?><br/>
		<strong>Phone</strong>: <?= $phone ?><br/>
		<strong>Information Requested</strong>: <?= $info ?><br/><br/>
		<strong>Message Text</strong>: <br/><?= $message ?>
	</p>
	<hr>

<?php	
}
?>	

