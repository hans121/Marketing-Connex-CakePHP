<div class="businesplans view">

<div class="row table-title partner-table-title">

	<div class="partner-sub-menu clearfix">
	
		<div class="col-md-5 col-xs-7">
			<h2><?= __('Mailing list contact')?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Mailing List', ['controller' => 'PartnerMailinglists', 'action' => 'index']);
					$this->Html->addCrumb('view contact', ['controller' => 'PartnerMailinglists', 'action' => 'view']);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Partners', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
		
		<div class="col-md-7 col-xs-5">
			<div class="btn-group pull-right">
				<?= $this->Html->link(__('Add a new'), ['action' => 'add'],['class'=>'btn btn-lg pull-right']) ?>
			</div>
		</div>
	
	</div>
	
</div> <!--row-table-title-->

  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

	<div class="row inner header-row ">
	
		<dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4">
			<strong>
				<?= h($partnerMailinglist->first_name) ?> <?= h($partnerMailinglist->last_name) .' ('. h($partnerMailinglist->email).')' ?>
			</strong>
		</dt>
		
		<dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
			<div class="btn-group pull-right">
	      <?= $this->Html->link(__('Edit'), ['action' => 'edit', $partnerMailinglist->id],['class'=>'btn']) ?>
			</div>
		</dd>
		
	</div>

	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Email address'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partnerMailinglist->email) ?>
		</dd>
	</div>
	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Company'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partnerMailinglist->company) ?>
		</dd>
	</div>
	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Industry'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partnerMailinglist->industry) ?>
		</dd>
	</div>
	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('City'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partnerMailinglist->city) ?>
		</dd>
	</div>
	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Country'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partnerMailinglist->country) ?>
		</dd>
	</div>
	
</div>


	
	<div class="row">
		<div class="col-md-12">
			<?php echo $this->element('form-cancel-bar'); ?><br />
		</div>
	</div>
	
