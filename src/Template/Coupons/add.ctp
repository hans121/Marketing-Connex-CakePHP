<div class="coupons form col-centered col-lg-10 col-md-10 col-sm-10">

  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
    
	<?= $this->Form->create($coupon,['class'=>'validatedForm']); ?>
	
	<h2><?= __('Add Coupon')?></h2>
	<div class="breadcrumbs">
		<?php
			$this->Html->addCrumb('Coupons', '/coupons');
			$this->Html->addCrumb('Add coupon', ['controller' => 'coupons', 'action' => 'add']);
			echo $this->Html->getCrumbs(' / ', [
			    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
			    'url' => ['controller' => 'Admins', 'action' => 'index'],
			    'escape' => false
			]);
		?>
	</div>
	
	<fieldset>
	
		<?php
		echo $this->Form->input('title');
		$options = ['Cash' => 'Cash', 'Perc' => 'Percentage'];
		echo $this->Form->input('type', ['options' => $options,'label'=>'Discount Type','class' => 'selectpicker']);
		echo $this->Form->hidden('coupon_code',['Value' => time()]);
		echo $this->Form->input('discount');
		echo $this->CustomForm->datetime('expiry_date',date(),'Expiry Date');
		// echo $this->Form->input('expiry_date', [
		//	'label' => 'Expiry Date',
		//	'minYear' => date('Y'),
		//	'maxYear' => date('Y')+10,
		//	'type'=> 'date',
		//	'class' => 'form-control'
		// ]);
		/*
		echo $this->Form->input('expiry_date', [
		'label' => 'Expiry Date',
		'type'=> 'datetime',
		'id'=> 'datepicker'
		]);*/

		//echo $this->Form->input('expiry_date',['data-live-search' => true]);
		echo $this->Form->hidden('status',['value' =>'Y']);
		?>
		
		<?php echo $this->element('form-submit-bar'); ?>
	</fieldset>
	
  <?= $this->Form->end(); ?>
  
</div>