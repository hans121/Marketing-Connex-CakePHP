<?php
$class = 'message';
if (!empty($params['class'])) {
	$class .= ' ' . $params['class'];
}
?>
<!-- <div class="<?= h($class) ?>"><?= h($message) ?></div> -->

<div class="alert-wrap">
<div class="alert alert-<?= h($class) ?> alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	  <h4><i class="fa fa-info-circle"></i> <?= __('Information')?></h4>
	  <p><?= h($message) ?></p>
</div>
</div>
