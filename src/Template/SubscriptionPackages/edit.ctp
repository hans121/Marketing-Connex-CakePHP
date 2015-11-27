<div class="subscriptionPackages form col-centered col-lg-10 col-md-10 col-sm-10">

	<?= $this->Form->create($subscriptionPackage,['class'=>'validatedForm']); ?>
	
	<h2><?= __('Edit Subscription Package')?></h2>
	<div class="breadcrumbs">
		<?php
			$this->Html->addCrumb('Subscription packages', '/subscription_packages');
					$this->Html->addCrumb('Edit subscription package', ['controller' => 'subscription_packages', 'action' => 'edit/'.h($subscriptionPackage->id)]);
			echo $this->Html->getCrumbs(' / ', [
			    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
			    'url' => ['controller' => 'Admins', 'action' => 'index'],
			    'escape' => false
			]);
		?>
	</div>

	<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
  <fieldset>
  
    <?php
			echo $this->Form->input('id');
			echo $this->Form->input('name');
			echo $this->Form->input('annual_price',['label'=>'Annual Price (USD $)', 'maxlength' => 9999,  'min' => 0, 'step' => 0.01, 'class' => 'quantity places']);
			echo $this->Form->input('monthly_price',['label'=>'Monthly Price (USD $)', 'maxlength' => 9999, 'min' => 0, 'step' => 0.01, 'class' => 'quantity places']);
			echo $this->Form->input('signup_fee',['label'=>'Signup Fee (USD $)', 'maxlength' => 9999, 'min' => 0, 'step' => 0.01, 'class' => 'quantity places']);
			echo $this->Form->input('no_partners',['label'=>'Max. Number of Partners', 'maxlength' => 9999, 'min' => 0, 'class' => 'quantity']);
			echo $this->Form->input('storage',['label'=>'Max. Storage Capacity (GB)', 'maxlength' => 9999,  'min' => 0, 'class' => 'quantity']);
			echo $this->Form->input('no_emails',['label'=>'Max. Number of Emails per partner', 'maxlength' => 9999,  'min' => 0, 'class' => 'quantity']);
			echo $this->element('checkbox-switches-modules');
			echo $this->Form->input('status',['options'=>['A'=>'Active (Public)','C'=>'Cancelled','P'=>'Private'],'class'=>'selectpicker']);
		?>

		<?php echo $this->element('form-submit-bar'); ?>
	
  </fieldset>
  
  <?= $this->Form->end(); ?>
    
</div>