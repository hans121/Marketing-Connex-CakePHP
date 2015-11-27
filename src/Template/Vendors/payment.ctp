<?php
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
			<div class="progress-bar" role="progressbar" aria-valuenow="88.5" aria-valuemin="0" aria-valuemax="100" style="width: 88.5%;">
				<span class="sr-only"><?= __('75% Complete');?></span>
		
			</div>
		</div>
		
		<div class="vendors form col-centered col-lg-8 col-md-8 col-sm-8">
			
    <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
		<?php echo $this->Form->create($ver,['class'=>'validatedForm']) ?>
		
			<h2><?= __('Step 4: Enter your payment details')?></h2>
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
							<label><strong><?php echo $currency_symbol. $vendor['amount'];?></strong></label>
			  		</div>
						<?php 
							if(isset($vendor['discount_amount'])) {
						?>
			  		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label><?php echo __('Discount Price') ?></label>
			  		</div>
			  		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label><strong><?php echo $currency_symbol. $vendor['discount_amount'];?></strong></label>
			  		</div>
						<?php
						} else {
							$vendor['discount_amount'] = 0;
						} 
							$final_amount =   round($vendor['amount'] - $vendor['discount_amount'],2);
						?>
			  		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label><?php echo __('Subscription Price') ?></label>
			  		</div>
			  		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label><strong><?php echo $currency_symbol.$final_amount;?>
			  		</div>
			  		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label><?php echo __('One-time Signup Fee') ?></label>
			  		</div>
			  		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label><strong><?php echo $currency_symbol. $vendor['signup_fee'];?>
			  		</div>
			  		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label><strong><?php echo __('Checkout Sub-Total') ?></strong></label>
			  		</div>
			  		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label><strong><?php echo $currency_symbol . round($final_amount + $vendor['signup_fee'], 2);?>
			  		</div>
			  		<?php
				  	if ($vendor['vat'] > 0) {	
				  	?>
			  		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label><?php echo __('+ VAT ('.round($vendor['vat_perc'],2).'%)') ?></label>
			  		</div>
			  		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label><?php echo $currency_symbol. $vendor['vat'];?>
			  		</div>			  		
			  		<?php
				  	};	
				  	?>
			  		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label><strong><?php echo __('Total Checkout Price') ?></strong></label>
			  		</div>
			  		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label><strong><?php echo $currency_symbol. round($final_amount + $vendor['signup_fee'] + $vendor['vat'], 2);?>
			  		</div>
				</fieldset>
		
						
		<div class="panel-group row" id="accordion">
		  <div>
		      <h4 class="panel-title">
		        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
							<div class="col-md-10 col-xs-8"><p><?= __('Cardholder\'s name & address (defaults to Primary Manager)')?></p></div>
							<div class="col-md-2 col-xs-4"><div class="btn-group pull-right">
								<div class="btn">Edit</div>
							</div>
							</div>
		        </a>
		      </h4>
		        	<div class="clearfix"></div>
		    <div id="collapseOne" class="panel-collapse collapse">
		      <div class="panel-body">
				    <fieldset>
							<h4><?= __('Cardholder\'s name & address')?></h4>
				        <?php
				        echo $this->Form->hidden('vendor_id',['value' => $vendor['id']]);
				        echo $this->Form->hidden('totalOccurrences',['value' => $vendor['occlength']]);
				        echo $this->Form->hidden('trialOccurrences',['valsignuue' => ($vendor['signup_fee']>0?'1':'0')]);
				        echo $this->Form->hidden('trialAmount',['value' => $vendor['s']['signup_fee']]);
				        echo $this->Form->hidden('name',['value' => $vendor['s']['name']]);
				        echo $this->Form->hidden('length',['value' => $vendor['length']]);
				        echo $this->Form->hidden('unit',['value' => $vendor['unit']]);
				        echo $this->Form->hidden('startDate',['value' => date('Y-m-d')]);
				        echo $this->Form->hidden('amount',['value'=>$final_amount]);
				        echo $this->Form->hidden('refId',['value'=>$vendor['refId']]);
				        echo $this->Form->input('firstName',['value' => $vendor['u']['first_name'],'label' => 'First Name(s)']);
				        echo $this->Form->input('lastName',['value' => $vendor['u']['last_name'],'label' => 'Last Name']);
				        echo $this->Form->input('company',['value' => $vendor['company_name'],'label' => 'Company Name']);
				        echo $this->Form->input('address',['value' => $vendor['address'],'label' => 'Address']);
				        echo $this->Form->input('city',['value' => $vendor['city'],'label' => 'City']);
				        echo $this->Form->input('state',['value' => $vendor['state'],'label' => 'State / County']);
				        echo $this->Form->input('zip',['value' => $vendor['postalcode'],'label' => 'Zip / Post Code']);
				        echo $this->Form->input('country', ['options' => $vendor['country_list'],'type'=>'select','value'=>$vendor['country'],'data-live-search' => true]);
				        echo $this->Form->input('email',['value' => $vendor['u']['email'],'label' => 'E-mail']);
				        echo $this->Form->input('phone',['value' => $vendor['phone'],'label' => 'Phone']);
								echo $this->Form->input('fax',['value' => $vendor['fax'],'label' => 'Fax']);
				        ?>
				    </fieldset>
		      </div>
		    </div>
		  </div>			
		</div>
			
		    <fieldset>
					<h4><?= __('Card details')?></h4>
						<?php
		
							echo $this->Form->input('cardNumber',['label'=>'Card Number', 'maxlength' => 16, 'max' => 9999999999999999, 'min' => 0, 'class' => 'quantity']);
						?>
						<div class="inline-twothirds">
						<?php
							echo $this->Form->input('expirationDate', [
								'label' => 'Expiry Date',
								'minYear' => date('Y'),
								'maxYear' => date('Y')+10,
								'day' => false,
								'label'=> 'Expiration Date',
								'type'=> 'date',
		            'monthNames'=>['01' => '01', '02' => '02','03' => '03','04' => '04','05' => '05','06' => '06','07' => '07','08' => '08','09' => '09','10' => '10','11' => '11','12' => '12',]
					]);
						?>
						</div>
						<div class="inline-onethird">
			        <?php
			        	echo $this->Form->input('cardCode',['label'=>'CVV/CVC code', 'maxlength' => 4, 'max' => 9999, 'min' => 0, 'class' => 'quantity']);
			        ?>
							<?= __('<a class="popup" data-toggle="popover" data-content="For Mastercard or Visa, it\'s the last three digits in the signature area on the back of your card. For American Express, it\'s the four digits on the front of the card"><i class="fa fa-info-circle"></i> What\'s this?</a>')?>
						</div>
		    </fieldset>

		    <fieldset >
		    	<h4><?= __('Terms and Condition')?></h4>
		    	<div class="row">
		    	<div class="col-xs-11">
		    	<label style="padding-top:8px;">By signing up, I agree to the marketingconneX <a href="/pages/conditions/">Terms and Conditions</a></label>
				</div>
		    	<div class="col-xs-1">
		    	<?php
					echo $this->Form->input(
					'agree', 
					[
					'type' => 'checkbox',
					'checked'=>true,
					'value'=>'yes',
					'label' => false
					]);
		    	?>
		    	</div>
		    	</div>
		    </fieldset>
		
		<!--// Form Submit Bar //-->
		<div class="row submit-bar">
			<div class="col-md-12">
				<?= $this->Html->link(__('Cancel'), $last_visited_page,['class' => 'pull-left btn btn-lg btn-cancel']); ?>					
				<?= $this->Form->button(__('Submit'),['class'=> 'pull-right btn btn-lg', 'id'=>'submit-btn' , 'disabled'=>true]); ?>
			</div>
		</div>
		
		<?php echo $this->Form->end() ?>
		
		</div>
		
	</div>
</div>
<script>
	$(document).ready(function () {
		if($('#agree').val('yes')) {

			$('#submit-btn').prop('disabled',false);
		};
		
		$('#agree').change(function () {
			if(this.checked)
				$('#submit-btn').prop('disabled',false);
			else
				$('#submit-btn').prop('disabled',true);
		});
	});
</script>
