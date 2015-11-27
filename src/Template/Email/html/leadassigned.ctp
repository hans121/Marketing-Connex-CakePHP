<p>
	The lead "<?=$email?>" is waiting for your response. 

	Please login to your MarketingConnex.com partner account accept or reject your assigned lead immediately.
	
	<?php
	if($vendor_msg!='')
		echo 'Note from your partner vendor:'."\n\n".$vendor_msg;
	?>

	Thank you!
</p>