<div class="partners form">
  
  <?= $this->Form->create($partner,['class'=>'validatedForm']); ?>
  
  	<fieldset>
    	
  		<legend><?= __('Add Partner'); ?></legend>
  		
  		<div class="breadcrumbs">
  			<?php
  				$this->Html->addCrumb('Profile', ['controller' => 'Partners', 'action' => 'view']);
  				$this->Html->addCrumb('add', ['controller' => 'Partners', 'action' => 'add']);
  				echo $this->Html->getCrumbs(' / ', [
  				    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
  				    'url' => ['controller' => 'Partners', 'action' => 'index'],
  				    'escape' => false
  				]);
  			?>
  		</div>
  		
      <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
  		
  		<?php
  			echo $this->Form->input('vendor_id', ['options' => $vendors]);
  			echo $this->Form->input('company_name');
  			echo $this->Form->input('logo_url');
  			echo $this->Form->input('email_domain');
  			echo $this->Form->input('phone');
  			echo $this->Form->input('fax');
  			echo $this->Form->input('website');
  			echo $this->Form->input('twitter');
  			echo $this->Form->input('facebook');
  			echo $this->Form->input('linkedin');
  			echo $this->Form->input('no_employees');
  			echo $this->Form->input('no_offices');
  			echo $this->Form->input('total_a_revenue');
  			echo $this->Form->input('address');
  		  echo $this->element('country-select-list'); 
  			echo $this->Form->input('city');
  			echo $this->Form->input('state',['label'=>'County/State']);
  			echo $this->Form->input('postal_code');
  			echo $this->Form->input('vendor_manager_id');
  		?>
  		
  	</fieldset>
  	
  <?= $this->Form->button(__('Submit')); ?>
  
  <?= $this->Form->end(); ?>

</div>

<div class="actions">
	<h3><?= __('Actions'); ?></h3>
	<ul>
		<li><?= $this->Html->link(__('List Partners'), ['action' => 'index']); ?></li>
		<li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add']); ?> </li>
		<li><?= $this->Html->link(__('List PartnerManagers'), ['controller' => 'PartnerManagers', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Partner Manager'), ['controller' => 'PartnerManagers', 'action' => 'add']); ?> </li>
	</ul>
</div>
