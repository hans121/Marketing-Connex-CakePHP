<div class="subscriptionPackages form col-centered col-lg-10 col-md-10 col-sm-10">
		<?= $this->Form->create($subscriptionPackage,['class'=>'validatedForm']); ?>

		<h2><?= __('Add Subscription Package')?></h2>
		<div class="breadcrumbs">
			<?php
				$this->Html->addCrumb('Subscription packages', '/subscription_packages');
				$this->Html->addCrumb('Add subscription package', ['controller' => 'subscription_packages', 'action' => 'add']);
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
				echo $this->Form->input('name',['label' => 'Package name']);
				echo $this->Form->input('annual_price',['label' => 'Annual Price : USD$']);
				echo $this->Form->input('monthly_price',['label' => 'Monthly Price : USD$']);
				echo $this->Form->input('signup_fee',['label' => 'Signup Fee : USD$']);
				echo $this->Form->input('duration',['type'=>'hidden','value'=> '12']);
				echo $this->Form->input('no_partners',['label' => 'Maximum number of partners']);
				echo $this->Form->input('storage',['label' => 'Maximum storage capacity (Gb)']);
				echo $this->Form->input('no_emails',['label' => 'Email send limit']);
				echo $this->element('checkbox-switches-modules');
				echo $this->Form->input('status',['options'=>['A'=>'Active (Public)','C'=>'Cancelled','P'=>'Private'],'class'=>'selectpicker']);
			?>
			
			<?php
				echo $this->element('form-submit-bar');
			?>
			
		</fieldset>
		
    <?= $this->Form->end(); ?>
    
</div>