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

<div class="vendors form col-centered col-lg-10 col-md-10 col-sm-10">
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	<?= $this->Form->create($vendor,['type'=> 'file','class'=>'validatedForm', 'onsubmit'=>'checkurl()']); ?>
	
	<h2><?= __('Edit Vendor')?></h2>
	<div class="breadcrumbs">
		<?php
			$this->Html->addCrumb('Vendors', ['controller'=>'Admins','action' => 'vendors']);
			$this->Html->addCrumb('edit', ['controller'=>'Admins','action' => 'editVendor', $vendor->id]);
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
								<?= $this->Html->image($vendor->logo_url,['class'=>'img-responsive'])?>
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
		
		<div class="row inner">
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
					<span class="btn pull-right button ">Change</span>
				</span>
			</div>	
		</div>
		-->
		
		
		<?php		
	  	//echo $this->Form->input('logo_url',['type' =>'file','label' => 'Change Logo']);
			echo $this->Form->input('phone');
			//echo $this->Form->input('fax');
                         echo $this->element('fquarter-select-list');
		  echo $this->Form->input('website',['type'=>'text','placeholder'=>'Please enter the URL in the format http://www.website.com', 'id' => 'websitefield']);
			echo $this->Form->input('address');
		  echo $this->element('country-select-list'); 
			echo $this->Form->input('city');
			echo $this->Form->input('state',['label'=>'County/State']);
			echo $this->Form->input('postalcode');
	    echo $this->Form->input('subscription_package_id', ['options' => $package_list,'data-live-search' => true,]);
	    echo $this->Form->input('coupon_id',['options' => $coupon_list,'empty' =>'Select Coupon','data-live-search' => true,]);
			echo $this->Form->input('vat_no',['label'=>'VAT ID']);
			echo $this->Form->input('language', ['options' => ['en'=>'English'],'data-live-search' => true]);
			echo $this->Form->hidden('subscription_type');
			echo $this->element('form-submit-bar');
		?>
  </fieldset>
  <?= $this->Form->end(); ?>
</div>