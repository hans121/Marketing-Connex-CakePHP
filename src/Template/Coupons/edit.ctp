<div class="coupons form col-centered col-lg-10 col-md-10 col-sm-10">

  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	<?= $this->Form->create($coupon,['class'=>'validatedForm']); ?>
	
	<h2><?= __('Edit Coupon')?></h2>
	<div class="breadcrumbs">
		<?php
			$this->Html->addCrumb('Coupons', '/coupons');
			$this->Html->addCrumb('Edit coupon', ['controller' => 'coupons', 'action' => 'edit/'.h($coupon->id)]);
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
			echo $this->Form->input('title');
	   		echo $this->Form->input('coupon_code',['readonly' => true]);
			$options = ['Cash' => 'Cash', 'Perc' => 'Percentage'];
	    	echo $this->Form->input('type', ['label'=>'Discount Type','options' => $options,]);
			echo $this->Form->input('discount', ['label'=>'Discount Value']);
			echo $this->CustomForm->datetime('expiry_date',$coupon->expiry_date,'Expiry Date');
			//echo $this->Form->input('expiry_date', [
	    //  'label' => 'Expiry Date',
	    //  'minYear' => date('Y')-10,
	    //  'maxYear' => date('Y')+10,
			//	'type'=> 'date', 'class' =>'col-xs-4'
	    //]);
	    /*
			echo $this->Form->input('expiry_date', [
			'label' => 'Expiry Date',
			'type'=> 'datetime',
			'id'=> 'datepicker'
			]);*/
			
	    $stoptions = ['Y' => 'New', 'E' => 'Expired','U' => 'Used','C' => 'Cancelled'];
	    echo $this->Form->input('status', ['options' => $stoptions,]);
		?>      
		<?php echo $this->element('form-submit-bar'); ?>
  </fieldset>
  
    <?= $this->Form->end(); ?>
    
</div>