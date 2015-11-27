<div class="vendorManagers form">
  
  <?= $this->Form->create($vendorManager,['class'=>'validatedForm']); ?>
  
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

	<fieldset>
  	
		<legend><?= __('Add Vendor Manager'); ?></legend>
		
  	<?php
  		echo $this->Form->input('vendor_id', ['options' => $vendors]);
  		echo $this->Form->input('user_id', ['options' => $users]);
  		echo $this->Form->input('primary_manager');
  		echo $this->Form->input('created_on');
  		echo $this->Form->input('modified_on');
  		echo $this->Form->input('status');
  	?>
  	
	</fieldset>
	
  <?= $this->Form->button(__('Submit')); ?>
  <?= $this->Form->end(); ?>

</div>

<div class="actions">
  
	<h3><?= __('Actions'); ?></h3>
	
	<ul>
		<li><?= $this->Html->link(__('List Vendor Managers'), ['action' => 'index']); ?></li>
		<li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add']); ?> </li>
		<li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']); ?> </li>
	</ul>
	
</div>
