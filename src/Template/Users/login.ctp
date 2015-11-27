<div class="users form col-centered col-lg-5 col-md-5 col-sm-8 col-xs-10">

  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
  
  <?php echo $this->Form->create() ?>
				 
	<fieldset class="login-form">
	
		<h2 class="black"><?php echo __('Please enter your details to sign in') ?></h2>
		
		<label for="username">Username
			<a class="popup" data-toggle="popover" data-content="<?= __('Your username is usually the email address you used when signing up for our service');?>">
			<i class="fa fa-info-circle"></i></a>
		</label>
		<?php echo $this->Form->input('username', ['type' => 'email', 'label' => '']) ?>
    <?php echo $this->Form->input('password', ['type' => 'password','id'=>'login-password']) ?>
    
	</fieldset>
	
  <?php echo $this->Form->button(__('Sign in'),['class'=>'col-lg-3 col-md-3 col-sm-3 col-xs-4 pull-right btn btn-lg']); ?>
  <?php echo $this->Form->end() ?>
					
</div>

</div>	