<?php 
$this->layout = 'admin--ui';
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

<!-- Card -->

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">

                <div class="card--header">

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="card--icon">
                                <div class="bubble">
                                    <i class="icon ion-person-stalker"></i></div>
                                </div>
                                <div class="card--info">
                                    <h2 class="card--title"><?= __('New Partner'); ?></h2>
                                    <h3 class="card--subtitle"></h3>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="card--actions">
                                </div>
                            </div>
                        </div>   
                    </div>


				<div class="card-content">
<!--
<div class="row">
<div class="col-md-12">
<h4>Campaign Options</h4>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
</p>
<hr>
</div>
</div>
-->
<!-- content below this line -->



<?= $this->Form->create($partner,['type'=>'file','class'=>'validatedForm','onsubmit'=>'checkurl()']); ?>

<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

<fieldset>

	<?php
	echo $this->Form->input('partner.vendor_id', ['value' => $vendor_id,'type'=> 'hidden']);
	?>
	<!-- form input content -->
	<div class="row input--field">
		<div class="col-md-3">
			<label>Partner Company Name</label>
		</div>
		<div class="col-md-6" id="input--field">
			<?php echo $this->Form->input('partner.company_name', array(
			'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
		</div>

	</div>
	<!-- form input content -->

		<!-- form input content -->
	<div class="row input--field">
		<div class="col-md-3">
			<label><?= __('Upload partner logo').' '; ?></label>
			<?php 
		$max_file_size	= $this->CustomForm->fileUploadLimit();
		$allowed = array('image/jpeg', 'image/png', 'image/gif', 'image/JPG', 'image/jpg', 'image/pjpeg');?>
		<a class="popup" data-toggle="popover" data-content="<?= __('The maximum file upload size is').' '.($max_file_size).__('. Supported file types are jpg, jpeg, gif, & png only');?>">
			<i class="fa fa-info-circle"></i></a>
		</div>
		<div class="col-md-6 withtop" id="input--field">
			<div class="">
					<div class="fileinput fileinput-new" data-provides="fileinput">
						<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
							<?php if(trim($partner->logo_url) != ''){ ?>	 
							<?= $this->Html->image('logos/'.$partner->logo_url,['class'=>'img-responsive'])?>
							<?php } ?>
						</div>
						<div>
							<span class="btn btn-default btn-file">
								<span class="fileinput-new">Select file</span>
								<span class="fileinput-exists">Change</span>
								<?php echo $this->Form->input('partner.logo_url',['type' =>'file','id' =>'logo_url', 'label'=>FALSE]); ?>
							</span>
							<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
						</div>
					</div>
				</div>
		</div>

	</div>
	<!-- form input content -->




<!-- Our previous input[type='file'] styling 
<div class="row table-th">	
<div class="col-lg-4 col-md-4 col-sm-4">
<?= __('Logo'); ?>
<?php $max_file_size	= $this->CustomForm->fileUploadLimit(); ?>
<?= __('<a class="popup" data-toggle="popover" data-content="The maximum file upload size is {0}. Supported file types are jpg, jpeg, gif, & png only',[($max_file_size)] )?>
<?= __('"><i class="fa fa-info-circle"></i></a>')?>
</div>		
</div>

<div class="row inner">
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
<?php if(trim($partner->logo_url) != ''){ ?>	 

<a data-toggle="popover" data-html="true" data-content='<?= $this->Html->image('logos/'.$partner->logo_url)?>'>
<?= $this->Html->image('logos/'.$partner->logo_url)?>
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

<!-- form input content -->
<div class="row input--field">
	<div class="col-md-3">
		<label>Partner Address</label>
	</div>
	<div class="col-md-6" id="input--field">
		<?php echo $this->Form->input('partner.address', array(
		'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
	</div>

</div>
<!-- form input content -->

<!-- form input content -->
<div class="row input--field">
	<div class="col-md-3">
		<label>Partner city</label>
	</div>
	<div class="col-md-6" id="input--field">
		<?php echo $this->Form->input('partner.city', array(
		'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
	</div>

</div>
<!-- form input content -->
<!-- form input content -->
<div class="row input--field">
	<div class="col-md-3">
		<label>Partner State</label>
	</div>
	<div class="col-md-6" id="input--field">
		<?php echo $this->Form->input('partner.state', array(
		'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
	</div>

</div>
<!-- form input content -->

<!-- form input content -->
<div class="row input--field">
	<div class="col-md-3">
		<label>Partner Country</label>
	</div>
	<div class="col-md-6" id="input--field">
		<?php echo $this->Form->input('partner.country', array(
		'div'=>false, 'label'=>false, 'class' => 'form-control', 'options' =>$country_list,'data-live-search' => true, 'empty' => 'Select a country')); ?>
	</div>

</div>
<!-- form input content -->
<!-- form input content -->
<div class="row input--field">
	<div class="col-md-3">
		<label>Partner Postal Code</label>
	</div>
	<div class="col-md-6" id="input--field">
		<?php echo $this->Form->input('partner.postal_code', array(
		'div'=>false, 'label'=>false, 'class' => 'form-control', 'label'=>'Zip / Post Code','maxLength'=>'10')); ?>
	</div>

</div>
<!-- form input content -->
<!-- form input content -->
<div class="row input--field">
	<div class="col-md-3">
		<label>Partner Email</label>
	</div>
	<div class="col-md-6" id="input--field">
		<?php echo $this->Form->input('partner.email', array(
		'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
	</div>

</div>
<!-- form input content -->
<!-- form input content -->
<div class="row input--field">
	<div class="col-md-3">
		<label>Partner Phone</label>
	</div>
	<div class="col-md-6" id="input--field">
		<?php echo $this->Form->input('partner.phone', array(
		'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
	</div>

</div>
<!-- form input content -->
<!-- form input content -->
<div class="row input--field">
	<div class="col-md-3">
		<label>Partner Website</label>
	</div>
	<div class="col-md-6" id="input--field">
		<?php echo $this->Form->input('partner.website', array(
		'div'=>false, 'label'=>false, 'class' => 'form-control', 'type'=>'text', 'id'=>'websitefield')); ?>
	</div>

</div>
<!-- form input content -->
<!-- form input content -->
<div class="row input--field">
	<div class="col-md-3">
		<label>Partner Twitter</label>
	</div>
	<div class="col-md-6" id="input--field">
		<?php echo $this->Form->input('partner.twitter', array(
		'div'=>false, 'label'=>false, 'class' => 'form-control', 'type'=>'text')); ?>
	</div>

</div>
<!-- form input content -->
<!-- form input content -->
<div class="row input--field">
	<div class="col-md-3">
		<label>Partner Facebook</label>
	</div>
	<div class="col-md-6" id="input--field">
		<?php echo $this->Form->input('partner.facebook', array(
		'div'=>false, 'label'=>false, 'class' => 'form-control', 'type'=>'text')); ?>
	</div>

</div>
<!-- form input content -->
<!-- form input content -->
<div class="row input--field">
	<div class="col-md-3">
		<label>Partner Linkedin</label>
	</div>
	<div class="col-md-6" id="input--field">
		<?php echo $this->Form->input('partner.linkedin', array(
		'div'=>false, 'label'=>false, 'class' => 'form-control', 'type'=>'text')); ?>
	</div>

</div>
<!-- form input content -->
<!-- form input content -->
<div class="row input--field">
	<div class="col-md-3">
		<label>Partner Groups</label>
	</div>
	<div class="col-md-6" id="input--field">
		<?php echo $this->Form->input('partner_groups', array(
		'div'=>false, 'label'=>false, 'class' => 'form-control', 'options' =>$partnergroups,'data-live-search' => true,'multiple'=>true)); ?>
	</div>

</div>
<!-- form input content -->
<!-- form input content -->
<div class="row input--field">
	<div class="col-md-3">
		<label>Vendor Manager</label>
	</div>
	<div class="col-md-6" id="input--field">
		<?php echo $this->Form->input('partner.vendor_manager_id', array(
		'div'=>false, 'label'=>false, 'class' => 'form-control', 'options' =>$vmanagers,'data-live-search' => true)); ?>
	</div>

</div>
<!-- form input content -->



</fieldset>


<div class="row">
	<div class="col-md-12">
		<h4><?= __('Primary Contact Details'); ?></h4>

		<hr>
	</div>
</div>


<fieldset>




	<?php
	echo $this->Form->input('user.password',['type' => 'hidden','value'=>time()]); ?>



	<?php 
	$titoptions=array('Mr'=>'Mr','Ms'=>'Ms','Mrs'=>'Mrs','Miss'=>'Miss','Dr'=>'Dr');
	?>               
	<!-- form input content -->
	<div class="row input--field">
		<div class="col-md-3">
			<label>Title</label>
		</div>
		<div class="col-md-6" id="input--field">
			<?php echo $this->Form->input('title', array(
			'div'=>false, 'label'=>false, 'class' => 'form-control', 'options'=>$titoptions)); ?>
		</div>

	</div>
	<!-- form input content -->

	<!-- form input content -->
	<div class="row input--field">
		<div class="col-md-3">
			<label>First Name</label>
		</div>
		<div class="col-md-6" id="input--field">
			<?php echo $this->Form->input('user.first_name', array(
			'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
		</div>

	</div>
	<!-- form input content -->
	<!-- form input content -->
	<div class="row input--field">
		<div class="col-md-3">
			<label>Last Name</label>
		</div>
		<div class="col-md-6" id="input--field">
			<?php echo $this->Form->input('user.last_name', array(
			'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
		</div>

	</div>
	<!-- form input content -->
	<!-- form input content -->
	<div class="row input--field">
		<div class="col-md-3">
			<label>Job Title</label>
		</div>
		<div class="col-md-6" id="input--field">
			<?php echo $this->Form->input('user.job_title', array(
			'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
		</div>

	</div>
	<!-- form input content -->
	<?php
	echo $this->Form->hidden('primary_contact',['value' => 'Y']);
	echo $this->Form->hidden('user.status',['value' => 'Y']);
	echo $this->Form->hidden('user.role',['value' => 'partner']);
	echo $this->Form->hidden('status',['value' => 'Y']);
	?>
</fieldset>



<!-- content below this line -->
</div>
<div class="card-footer">
	<div class="row">
		<div class="col-md-6">
			<!-- breadcrumb -->
			<ol class="breadcrumb">
				<li>               
					<?php
					$this->Html->addCrumb('Partners', ['controller' => 'vendors', 'action' => 'partners']);
					$this->Html->addCrumb('add', ['controller' => 'vendors', 'action' => 'addPartner']);
					echo $this->Html->getCrumbs(' / ', [
						'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
						'url' => ['controller' => 'Vendors', 'action' => 'index'],
						'escape' => false
						]);
						?>
					</li>
				</ol>
			</div>
			<div class="col-md-6 text-right">
		<?= $this->Html->link(__('Cancel'), $last_visited_page,['class' => 'btn btn-default btn-cancel']); ?>					
		<?= $this->Form->button(__('Submit'),['class'=> 'btn btn-primary']); ?>
<?= $this->Form->end(); ?>

			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
<!-- /Card -->

