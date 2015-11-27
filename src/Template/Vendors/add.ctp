<div class="vendors form">
  <?= $this->Form->create($vendor,['class'=>'validatedForm']); ?>

    <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
    
  	<fieldset>
  		<legend><?= __('Add Vendor'); ?></legend>
  		
    	<?php
    		echo $this->Form->input('company_name');
    		echo $this->Form->input('logo_url');
    		echo $this->Form->input('phone');
    		echo $this->Form->input('fax');
    		echo $this->Form->input('website');
    		echo $this->Form->input('address');
    	  echo $this->element('country-select-list'); 
    		echo $this->Form->input('city');
    		echo $this->Form->input('state',['label'=>'County/State']);
    		echo $this->Form->input('postalcode');
    		echo $this->Form->input('subscription_package');
    		echo $this->Form->input('status');
    		echo $this->Form->input('no_emails');
    		echo $this->Form->input('no_partners');
    		echo $this->Form->input('coupon_id');
    		echo $this->Form->input('language');
    		echo $this->Form->input('subscription_type');
    	?>
    	
  	</fieldset>
  	
    <?= $this->Form->button(__('Submit')); ?>
    
  <?= $this->Form->end(); ?>
  
</div>

<div class="actions">
  
	<h3><?= __('Actions'); ?></h3>
	
	<ul>
		<li><?= $this->Html->link(__('List Vendors'), ['action' => 'index']); ?></li>
		<li><?= $this->Html->link(__('List Coupons'), ['controller' => 'Coupons', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Coupon'), ['controller' => 'Coupons', 'action' => 'add']); ?> </li>
		<li><?= $this->Html->link(__('List Partners'), ['controller' => 'Partners', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Partner'), ['controller' => 'Partners', 'action' => 'add']); ?> </li>
		<li><?= $this->Html->link(__('List VendorManagers'), ['controller' => 'VendorManagers', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Vendor Manager'), ['controller' => 'VendorManagers', 'action' => 'add']); ?> </li>
	</ul>
	
</div>
