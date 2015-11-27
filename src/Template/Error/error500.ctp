<?php
$this->layout = 'admin-error'; 	
?>
<div class="alert-wrap">
<div class="alert alert-warning alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	  <h4><i class="fa fa-exclamation-triangle"></i> <?= __('Sorry')?></h4>
	  <p><?= __("An error has occurred. If you continue to experience problems please contact Customer Support, quoting 'Internal Server Error 500'.") ?></p>
</div>
</div>
