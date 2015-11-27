<div class="users form col-centered col-lg-5 col-md-5 col-sm-8 col-xs-10">
	
	<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<?php echo $this->Form->create() ?>
					
	<fieldset>
		
		<h2 class="black"><?php echo __('Please enter your username') ?></h2>
		
	  <?php echo $this->Form->input('username') ?>
	  
	</fieldset>
	
	<?php echo $this->Form->button(__('Reset Password'),['class'=>'col-lg-5 col-md-5 col-sm-6 col-xs-7 pull-right btn btn-lg']); ?>
	<?php echo $this->Form->end() ?>
				
</div>

</div>	
