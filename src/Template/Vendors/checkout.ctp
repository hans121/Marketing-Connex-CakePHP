<?php
	//print_r( $vendor); exit;
switch($vendor['currency_choice']) {
	case 'USD':
		$currency_symbol = '&dollar;';
		break;
	case 'GBP':
		$currency_symbol = '&pound;';
		break;
	case 'EUR':
		$currency_symbol = '&euro;';
		break;
}
?>
<div id="content" class="section-grey">
	<div class="container">
		
		
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
			<div class="progress-bar" role="progressbar" aria-valuenow="63" aria-valuemin="0" aria-valuemax="100" style="width: 63%;">
				<span class="sr-only"><?= __('50% Complete');?></span>
		
			</div>
		</div>

		<div class="vendors form col-centered col-lg-8 col-md-8 col-sm-8">
      <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
  		<?php echo $this->Form->create() ?>
			<h2><?= __('Step 3: Enter any coupon code')?></h2>
		    <fieldset class="well">
			  	<div class="row">
			  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h4><?= __('Package details')?></h4>
			  		</div>
			  		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label><?php echo __('Package Name') ?></label>
			  		</div>
			  		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label><strong><?php echo $vendor['s']['name'] ?></strong></label>
			  		</div>
			  		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label><?php echo __('Package Type') ?></label>
			  		</div>
			  		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label><strong><?php echo ucwords($vendor['subscription_type']). __(' Subscription') ?></strong></label>
			  		</div>
			  		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label><?php echo __('Package Price') ?></label>
			  		</div>
			  		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label><strong><?php echo $currency_symbol . round($vendor['amount'],2);?></strong></label>
			  		</div>
				</fieldset>
				<fieldset>
					<h4><?= __('If you have a coupon code, enter it here')?></h4>
					<?php echo $this->Form->input('discount_coupon_code');?>
				</fieldset>
		    
		<?php echo $this->element('form-next-prev-submit-bar'); ?>
		
		<?php echo $this->Form->end() ?>
		
		</div>
	
  </div>
</div>
