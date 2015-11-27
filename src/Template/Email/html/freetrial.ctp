<?php
if ($email_type=='vendor') {	
?>
	<p>Dear <?= $firstname ?>,</p>
	<p>Thank you for requesting a free trial with MarketingConneX.</p>
	<p>We will process your trial account within the next 24 hours and notify you when you are able to access it.  Should you have any questions at all, please don't hesitate to contact customer support.</p>

<?php
} elseif ($email_type=='admin') {	
?>

	<p><?php if ($username!="") { ?>Dear <?= $username ?>,<?php } ?></p>
	<p>A Vendor (<strong><?= $company_name ?></strong>) has requested a free trial.</p>
	
	<p>To activate the vendor, view their details as an administrator at <a href="<?= $site_url ?>/admins/viewVendor/<?= $vendor_id ?>"><?= $site_url ?>/admins/viewVendor/<?= $vendor_id ?></a></p>
	
	<p>Out.</p>


<?php
} else {
?>	
	
	<p><?php if ($username!="") { ?>Dear <?= $username ?>,<?php } ?></p>
	<p>A Vendor (<strong><?= $company_name ?></strong>) has attempted to sign-up for a free trial and abandoned the process <em>before</em> creating a vendor manager.</p>
	<p>Their application may need to be completed manually or can be picked up via the following link:
		<a href="<?= $site_url ?>/vendors/primarycontact/<?= $vendor_id ?>"><?= $site_url ?>/vendors/primarycontact/<?= $vendor_id ?></a>
	</p>
	
	<p>To access the vendor's details, log-in and go to <a href="<?= $site_url ?>/admins/viewVendor/<?= $vendor_id ?>"><?= $site_url ?>/admins/viewVendor/<?= $vendor_id ?></a></p>
	
	<p>Out.</p>
<?php	
}
?>	

