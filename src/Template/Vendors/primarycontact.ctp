<div id="content" class="section-grey">
	<div class="container">
		
<?php
		  if ($subscription_package!=4) {
?>	
		<div class="row payments clearfix">
			<div class="col-md-12">
				<h1><?=__('Checkout');?></h1>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 hidden-xs">
				<div class="text-center"><?=__('Enter company details');?></div>
				<div class="text-center">|</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 hidden-xs">
				<div class="text-center"><?=__('Set up primary manager');?></div>
				<div class="text-center">|</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 hidden-xs">
				<div class="text-center"><?=__('Enter coupon code');?></div>
				<div class="text-center">|</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 hidden-xs">
				<div class="text-center"><?=__('Enter payment details');?></div>
				<div class="text-center">|</div>
			</div>
		</div>
		<div class="progress">
			<div class="progress-bar" role="progressbar" aria-valuenow="37" aria-valuemin="0" aria-valuemax="100" style="width: 37%;">
				<span class="sr-only"><?= __('25% Complete');?></span>
		
			</div>
		</div>
<?php
		 } else {
?>	
		<div class="row payments clearfix">
			<div class="col-md-12">
				<h1><?=__('Checkout');?></h1>
			</div>
			<div class="col-sm-6 hidden-xs">
				<div class="text-center"><?=__('Enter company details');?></div>
				<div class="text-center">|</div>
			</div>
			<div class="col-sm-6 hidden-xs">
				<div class="text-center"><?=__('Set up primary manager');?></div>
				<div class="text-center">|</div>
			</div>
		</div>
		<div class="progress">
			<div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
				<span class="sr-only"><?= __('100% Complete');?></span>
		
			</div>
		</div>
<?php
		 }
?>			
		
		
		<div class="vendors form col-centered col-lg-8 col-md-8 col-sm-8">
      <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
			<?php echo $this->Form->create($user,['class'=>'validatedForm']) ?>
			<h2><?= __('Step 2: Enter the details for the primary contact')?></h2>
			<fieldset>
		    <?php
					echo $this->element('title-form');
					echo $this->Form->input('first_name',['label'=>'First Name(s)']);
					echo $this->Form->input('last_name');
          echo $this->Form->input('job_title');
					echo $this->Form->input('phone');
					echo $this->Form->input('email');
				?>
          <hr/>
        <?php
					echo $this->Form->input('password');
					echo $this->Form->input('conf_password',['label'=>'Confirm Password', 'type' => 'password']);
					echo $this->Form->hidden('status',['value' =>'P']);
					echo $this->Form->hidden('role',['value' =>'vendor']);
					
					echo $this->Form->hidden('vendor_manager.vendor_id',['value'=>$vendor_id]);
					echo $this->Form->hidden('vendor_manager.primary_manager',['value' => 'Y']);
		    ?>
			</fieldset>
		<?php echo $this->element('form-next-prev-submit-bar'); ?>
		
		<?php echo $this->Form->end() ?>
		
		</div>
		
  </div>
</div>

