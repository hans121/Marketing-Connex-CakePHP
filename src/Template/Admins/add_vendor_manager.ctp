
	<div class="vendorManagers form col-centered col-lg-10 col-md-10 col-sm-10">
	  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	  <?= $this->Form->create($user,['class'=>'validatedForm']); ?>
		<h2><?= __('Vendor Manager Details')?></h2>
		<div class="breadcrumbs">
			<?php
				$this->Html->addCrumb('Vendors', ['controller'=>'Admins','action' => 'vendors']);
				$this->Html->addCrumb('add vendor manager', ['controller'=>'Admins','action' => 'addVendorManager', $vendor->id]);
				echo $this->Html->getCrumbs(' / ', [
				    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
				    'url' => ['controller' => 'Admins', 'action' => 'index'],
				    'escape' => false
				]);
			?>
	</div>
		
		
	<fieldset>
		
		<?php
			echo $this->Form->input('email');
			echo $this->Form->input('password');
			echo $this->Form->input('conf_password',['label'=>'Confirm Password', 'type' => 'password']);
			echo $this->Form->hidden('status',['value' =>'Y']);
			echo $this->Form->hidden('role',['value' =>'vendor']);
			echo $this->element('title-form');
			echo $this->Form->input('first_name',['label'=>'First Name(s)']);
			echo $this->Form->input('last_name');
			echo $this->Form->input('job_title');
			echo $this->Form->input('phone');
			echo $this->Form->hidden('vendor_manager.vendor_id',['value'=>$vendor_id]);
			echo $this->Form->hidden('vendor_manager.primary_manager',['value' => 'N']);
			echo $this->element('form-submit-bar');
		?>
	
	</fieldset>
	        
	<?= $this->Form->end(); ?>

</div>