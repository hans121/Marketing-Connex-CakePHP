<?php
$this->layout = 'admin-error'; 	
?>
<div class="alert-wrap">
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <h4><i class="fa fa-check-circle"></i> <?= __('Error 404 - Page not found')?></h4>
  <p><?= __('The requested address was not found on this server.') ?></p>
</div>
</div>
