<div class="row submit-bar">
	<div class="col-md-12">
		<?= $this->Html->link(__('<< Back'), $last_visited_page,['class' => 'pull-left btn btn-lg btn-cancel']); ?>					
		<?php echo $this->Form->button(__('Next >>'),['class'=> 'pull-right btn btn-lg']); ?>
	</div>	
</div>
