	<div class="vendorManagers form col-centered col-lg-10 col-md-10 col-sm-10">
	  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	  <?= $this->Form->create($user,['class'=>'validatedForm']); ?>
		<h2><?= __('Vendor Manager Details')?></h2>
		<div class="breadcrumbs">
			<?php
				$this->Html->addCrumb('Vendors', ['controller'=>'Admins','action' => 'vendors']);
				$this->Html->addCrumb('edit vendor manager', ['controller'=>'Admins','action' => 'editVendorManager', $vendor->id]);
				echo $this->Html->getCrumbs(' / ', [
				    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
				    'url' => ['controller' => 'Admins', 'action' => 'index'],
				    'escape' => false
				]);
			?>
	</div>
	

  <fieldset>
		
		<?php
			echo $this->Form->input('id');
			echo $this->Form->input('username',['readOnly' => true]);
			echo $this->Form->input('email');
			$stoptions = ['A' => 'Active', 'P' => 'Pending','S' => 'Suspended','B' => 'Blocked'];
			echo $this->Form->input('status',['options' => $stoptions,]);
			echo $this->Form->hidden('role');
	    echo $this->element('title-form');
			echo $this->Form->input('first_name');
			echo $this->Form->input('last_name');
			echo $this->Form->input('job_title');
			echo $this->Form->input('phone');
	    echo $this->element('form-submit-bar');
	  ?>
	  
  </fieldset>

    <?= $this->Form->end(); ?>

</div>