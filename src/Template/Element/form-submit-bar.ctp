<div class="row submit-bar">
	<div class="col-md-12">
		<?= $this->Html->link(__('Cancel'), $last_visited_page,['class' => 'pull-left btn btn-default btn-cancel']); ?>					
		<?= $this->Form->button(__('Submit'),['class'=> 'pull-right btn btn-primary']); ?>
	</div>
</div>