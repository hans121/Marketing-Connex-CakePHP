<div class="partnerMailinglists index">
			
	<div class="row table-title partner-table-title">
	
		<div class="partner-sub-menu clearfix">
		
			<div class="col-md-5 col-sm-5">
				<h2><?= __('Edit mailing list contact'); ?></h2>
				<div class="breadcrumbs">
					<?php
						$this->Html->addCrumb('Mailing List', ['controller' => 'PartnerMailinglists', 'action' => 'index']);
						$this->Html->addCrumb('edit contact', ['controller' => 'PartnerMailinglists', 'action' => 'edit']);
						echo $this->Html->getCrumbs(' / ', [
						    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
						    'url' => ['controller' => 'Partners', 'action' => 'index'],
						    'escape' => false
						]);
					?>
				</div>
			</div>
			
			<div class="col-md-7 col-sm-5">
				<div class="btn-group pull-right">
		        <?= $this->Html->link(__('Add a new contact'), ['action' => 'add'],['class'=>'btn btn-lg pull-right']) ?>
				</div>
			</div>
			
		</div>
		
	</div> <!--row-table-title-->
	
<div class="partnerManagers form col-centered col-lg-10 col-md-10 col-sm-10">
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
   
	<?= $this->Form->create($partnerMailinglist,['class'=>'validatedForm']); ?>
	
	<fieldset>
	<?php
	    $auth = $this->Session->read('Auth');
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('email',['label'=>'E-mail address']);
		echo $this->Form->input('company');
		echo $this->element('industry-select-list');
		echo $this->Form->input('city');
		echo $this->element('country-select-list');
    ?>

   
    <?php echo $this->element('form-submit-bar'); ?>
    
	</fieldset>
	
  <?= $this->Form->end(); ?>
  
</div>
	
</div> <!-- /#content -->