
<?php
if ($email_type=='admin') {	
?>
	<p>Hello <?=$username ?>,</p>
	<p>A new vendor (<?= $company_name ?>) and it's relative vendor manager (<?= $CUSTOMER_NAME ?>) has joined <?= $SITE_NAME ?>.</p>
	<p>To access the vendor's details, log-in and go to <a href="<?= $site_url ?>/admins/viewVendor/<?= $vendor_id ?>"><?= $site_url ?>/admins/viewVendor/<?= $vendor_id ?></a></p>

<?php
}  else {
?>	
	<p>Dear <?= $CUSTOMER_NAME ?>,</p>
	
	<p>Thank you for your recent purchase of a subscription package from <strong><a href="<?= $site_url ?>"><?= $SITE_NAME ?></a></strong>. Your subscription is active now. You can log in to the website using your e-mail address and the password you created on sign-up by <strong><a href="<?= $site_url ?>/login">clicking here</a></strong>. </p>
	<p>If you have any questions at any point during the setup process, feel free to contact us on: 01628 566 001</p>

<?php	
}
?>	

