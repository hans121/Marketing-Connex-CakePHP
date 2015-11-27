<?php
if ($email_type=='vendor') {	
?>
	<p>Dear <?= $firstname ?>,</p>
	<p>We noticed that you left the registration process before completing your payment and therefore your account has not been activated.</p>
	<p>We would be very sorry to lose you so for any assistance, please don't hesitate to contact customer support.</p>
	<p>To continue with registration, please go to <strong><a href="<?= $site_url ?>/vendors/checkout/<?= $vendor_id ?>"><?= $site_url ?>/vendors/checkout/<?= $vendor_id ?></a></strong></p>

<?php
} elseif ($email_type=='admin') {	
?>

	<p><?php if ($username!="") { ?>Dear <?= $username ?>,<?php } ?></p>
	<p>A Vendor (<strong><?= $company_name ?></strong>) has abandoned the checkout process <em>after</em> creating a vendor manager.</p>
	<p>We have contacted them with a link to the checkout process as follows:<br/>
		<a href="<?= $site_url ?>/vendors/checkout/<?= $vendor_id ?>"><?= $site_url ?>/vendors/checkout/<?= $vendor_id ?></a>
	</p>
	
	<p>To access the vendor's details, log-in and go to <a href="<?= $site_url ?>/admins/viewVendor/<?= $vendor_id ?>"><?= $site_url ?>/admins/viewVendor/<?= $vendor_id ?></a></p>
	
	<p>Over and Out.</p>


<?php
} else {
?>	
	
	<p><?php if ($username!="") { ?>Dear <?= $username ?>,<?php } ?></p>
	<p>A Vendor (<strong><?= $company_name ?></strong>) has abandoned the checkout process <em>before</em> creating a vendor manager.</p>
	<p>Their application may need to be completed manually or can be picked up via the following link:
		<a href="<?= $site_url ?>/vendors/primarycontact/<?= $vendor_id ?>"><?= $site_url ?>/vendors/primarycontact/<?= $vendor_id ?></a>
	</p>
	
	<p>To access the vendor's details, log-in and go to <a href="<?= $site_url ?>/admins/viewVendor/<?= $vendor_id ?>"><?= $site_url ?>/admins/viewVendor/<?= $vendor_id ?></a></p>
	
	<p>Over and Out.</p>
<?php	
}
?>	

