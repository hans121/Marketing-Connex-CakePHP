<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error;
use Cake\Utility\Debugger;
use Cake\Validation\Validation;

if (!Configure::read('debug')):
	//throw new Error\NotFoundException();
endif;
?>
<?php // marks up radio buttons in the right way for styling: http://book.cakephp.org/3.0/en/views/helpers/form.html#list-of-templates
	$this->Form->templates([
    'nestingLabel' => '{{radio}}<label{{attrs}}>{{text}}</label>',
    'radioWrapper' => '{{input}}{{label}}',
	]);
?>

<script>
		function checkurl() {
			var originalvalue = document.getElementById('websitefield').value;
			var value = originalvalue.toLowerCase();
			if (value && value.substr(0, 7) !== 'http://' && value.substr(0, 8) !== 'https://') {
                                // then prefix with http://
                                document.getElementById('websitefield').value = 'http://' + value;
                            }               
		}
	</script>


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
			<div class="progress-bar" role="progressbar" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100" style="width: 11%;">
				<span class="sr-only"><?= __('0% Complete');?></span>
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
			<div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
				<span class="sr-only"><?= __('50% Complete');?></span>
			</div>
		</div>
<?php
		 }
?>	

		
		
		
		<div class="vendors form col-centered col-lg-8 col-md-8 col-sm-8">
      <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
			<?php echo $this->Form->create($vendor,['type' => 'file','class'=>'validatedForm', 'onsubmit' => 'checkurl()']) ?>
			<h2><?= __('Step 1: Enter your company details')?></h2>
			<fieldset>
  			
				<?php
				  echo $this->Form->input('company_name');
				?>
				
		    <!-- Jasny Bootstrap input[type='file'] styling -->  
				<label for="description">
					<?= __('Upload your logo').' '; ?>
					<?php 
						$max_file_size	= $this->CustomForm->fileUploadLimit();
						$allowed = array('image/jpeg', 'image/png', 'image/gif', 'image/JPG', 'image/jpg', 'image/pjpeg');?>
						<a class="popup" data-toggle="popover" data-content="<?= __('The maximum file upload size is').' '.($max_file_size).__('. Supported file types are jpg, jpeg, gif, & png only');?>">
						<i class="fa fa-info-circle"></i></a>
				</label>
				<div class="row inner withtop">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="">
							<div class="fileinput fileinput-new" data-provides="fileinput">
							  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
							    <?php if(trim($vendor->logo_url) != ''){ ?>	 
										<?= $this->Html->image('logos/'.$vendor->logo_url,['class'=>'img-responsive'])?>
							    <?php } ?>
							  </div>
							  <div>
							    <span class="btn btn-default btn-file">
							    	<span class="fileinput-new">Select file</span>
							    	<span class="fileinput-exists">Change</span>
							    	<?php echo $this->Form->input('logo_url',['type' =>'file','id' =>'logo_url', 'label'=>FALSE]); ?>
							    </span>
							    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
							  </div>
							</div>
						</div>
					</div>
				</div>
				
				
		    <!-- Our previous input[type='file'] styling 
				<div class="row table-th">	
					<div class="col-lg-4 col-md-4 col-sm-4">
						<?= __('Logo '); 
						$max_file_size	= $this->CustomForm->fileUploadLimit();
						$allowed = array('image/jpeg', 'image/png', 'image/gif', 'image/JPG', 'image/jpg', 'image/pjpeg');?>
						<?= __('<a class="popup" data-toggle="popover" data-content="The maximum file upload size is {0}. Supported file types are jpg, jpeg, gif, & png only',[($max_file_size)] )?>
						<?= __('"><i class="fa fa-info-circle"></i></a>')?>
					</div>		
				</div>
				
				<div class="row inner file-input-bg">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
				    <?php if(trim($vendor->logo_url) != ''){ ?>	 
				       
							<a data-toggle="popover" data-html="true" data-content='<?= $this->Html->image('logos/'.$vendor->logo_url)?>'>
								<?= $this->Html->image('logos/'.$vendor->logo_url)?>
							</a>
							
				    <?php } ?>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
						<span class="file-wrapper ">
						    <?php echo $this->Form->input('logo_url',['type' =>'file','id' =>'logo_url', 'label'=>FALSE]); ?>
							<span class="btn pull-right button ">Choose</span>
						</span>
					</div>	
				</div>
				-->
				
				<?php
				 
				  echo $this->Form->input('address');
				  echo $this->Form->input('city');
				  echo $this->Form->input('state',['label'=>'County/State']);
				  echo $this->Form->input('postalcode',['label'=>'Zip / Postcode','maxLength'=>'10']);
				echo $this->element('country-select-list'); 
				echo $this->Form->input('phone');
				//echo $this->Form->input('fax',['type'=>'hidden','value'=> '']);
				echo $this->element('fquarter-select-list');
				echo $this->Form->input('currency',['label'=>'Reporting Currency','options' => $currency_list,'data-live-search' => true,]);
				  echo $this->Form->input('website',['type'=>'text','placeholder'=>'Please enter the URL in the format http://www.website.com', 'id' => 'websitefield']);
				  echo $this->Form->hidden('status',['value' =>'P']);
				  echo $this->Form->hidden('subscription_package_id',['value' => $subscription_package]);
				  if ($subscription_package!=4) {
					$option=array('monthly'=>'Monthly','yearly'=>'Yearly');
					echo $this->Form->input('subscription_type',['options' => $option]);
				  } else {
					echo $this->Form->hidden('subscription_type',['value' => 'monthly']);
				  }
		          echo $this->Form->hidden('language',['value' =>'en']);
				?>
			</fieldset>

<?php
		  if ($subscription_package!=4) {
?>	
			    <fieldset class="well">
			  	<div class="row">
				  	<?php
					 ?>
			  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<h4><?= __('What currency do you wish to pay with?')?></h4>
			  		</div>
			  		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<?php
							$this->Form->templates([
							    'radioContainer' => '<div class="form-radio">{{content}}</div>'
							]);
							
							$options = array(
							    'USD' => 'USD $',
							    'GBP' => 'GBP £',
							    'EUR' => 'EUR €'
							);
							
							$attributes = array(
							    'legend' => false,
							    'type' => 'radio'
							);
							
							echo $this->Form->radio('currency_choice', $options, $attributes);
					          echo $this->Form->input('vat_no',['label'=>'VAT Number']);

						?>	
			  		</div>
			  	</div>
		    </fieldset>  		
<?php
		};
?>	
	
		
		<?php echo $this->element('form-next-prev-submit-bar'); ?>
		
		<?php echo $this->Form->end() ?>
		
		</div>

  </div>
</div>

