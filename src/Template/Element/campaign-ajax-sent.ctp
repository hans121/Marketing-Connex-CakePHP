<div class="row input--field">
	<div class="col-md-3">
		<label for="exampleInput">Available sends</label>
	</div>
	<div class="col-md-9" id="input--field">
		<?php echo $this->Form->input('send_limit', ['div'=>false, 'label'=>false, 'class' => 'form-control required', 'value'=>$current_send_limit]); ?>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<p class="info--text"><small>your balance remaining for the selected quarter is, <?php echo $max_send_limit ?></small></p>
	</div>
</div>