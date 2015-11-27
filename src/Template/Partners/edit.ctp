<?php 
$this->layout = 'admin--ui';
?>


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
									<i class="icon ion-plus"></i></div>
								</div>
								<div class="card--info">
									<h2 class="card--title"><?= __('Edit Profile'); ?></h2>
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

<div class="partners form">
	<?= $this->Form->create($partner,['type'=>'file','class'=>'validatedForm']); ?>


	<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

	<fieldset>
		<?php
		echo $this->Form->input('id');
		echo $this->Form->hidden('vendor_id');
		?>
		<!-- form input content -->
		<div class="row input--field">
			<div class="col-md-3">
				<label>Company Name</label>
			</div>
			<div class="col-md-6" id="input--field">
				<?php echo $this->Form->input('company_name', array(
				'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
			</div>

		</div>
		<!-- form input content -->

			<!-- form input content -->
			<div class="row input--field">
				<div class="col-md-3">
					<label><?= __('Upload your logo').' '; ?>
								<?php 
			$max_file_size	= $this->CustomForm->fileUploadLimit();
			$allowed = array('image/jpeg', 'image/png', 'image/gif', 'image/JPG', 'image/jpg', 'image/pjpeg');?>
			<a class="popup" data-toggle="popover" data-content="<?= __('The maximum file upload size is').' '.($max_file_size).__('. Supported file types are jpg, jpeg, gif, & png only');?>">
				<i class="fa fa-info-circle"></i></a>
			</label>
				</div>
				<div class="col-md-6" id="input--field">
					<div class="">
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
								<?php if(trim($partner->logo_url) != ''){ ?>	 
								<?= $this->Html->image($partner->logo_url,['class'=>'img-responsive'])?>
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
			<!-- form input content -->





			<!-- form input content -->
			<div class="row input--field">
				<div class="col-md-3">
					<label>Address</label>
				</div>
				<div class="col-md-6" id="input--field">
					<?php echo $this->Form->input('address', array(
					'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
				</div>

			</div>
			<!-- form input content -->
			<!-- form input content -->
			<div class="row input--field">
				<div class="col-md-3">
					<label>City</label>
				</div>
				<div class="col-md-6" id="input--field">
					<?php echo $this->Form->input('city', array(
					'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
				</div>

			</div>
			<!-- form input content -->
			<!-- form input content -->
			<div class="row input--field">
				<div class="col-md-3">
					<label>County/State</label>
				</div>
				<div class="col-md-6" id="input--field">
					<?php echo $this->Form->input('state', array(
					'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
				</div>

			</div>
			<!-- form input content -->
			<!-- form input content -->
			<div class="row input--field">
				<div class="col-md-3">
					<label>Postcode</label>
				</div>
				<div class="col-md-6" id="input--field">
					<?php echo $this->Form->input('postal_code', array(
					'div'=>false, 'label'=>false, 'class' => 'form-control', 'maxLength'=>'10')); ?>
				</div>

			</div>
			<!-- form input content -->
			<!-- form input content -->
			<div class="row input--field">
				<div class="col-md-3">
					<label>Country</label>
				</div>
				<div class="col-md-6" id="input--field">
					<?php echo $this->Form->input('country', array(
					'div'=>false, 'label'=>false, 'class' => 'form-control', 'options' => $country_list,'data-live-search' => true, 'empty' => 'Select a country')); ?>
				</div>

			</div>
			<!-- form input content -->
			<!-- form input content -->
			<div class="row input--field">
				<div class="col-md-3">
					<label>Email</label>
				</div>
				<div class="col-md-6" id="input--field">
					<?php echo $this->Form->input('email', array(
					'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
				</div>

			</div>
			<!-- form input content -->
			<!-- form input content -->
			<div class="row input--field">
				<div class="col-md-3">
					<label>Phone</label>
				</div>
				<div class="col-md-6" id="input--field">
					<?php echo $this->Form->input('phone', array(
					'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
				</div>

			</div>
			<!-- form input content -->
			<!-- form input content -->
			<div class="row input--field">
				<div class="col-md-3">
					<label>Website</label>
				</div>
				<div class="col-md-6" id="input--field">
					<?php echo $this->Form->input('website', array(
					'div'=>false, 'label'=>false, 'class' => 'form-control', 'type'=>'text')); ?>
				</div>

			</div>
			<!-- form input content -->
			<!-- form input content -->
			<div class="row input--field">
				<div class="col-md-3">
					<label>Twitter</label>
				</div>
				<div class="col-md-6" id="input--field">
					<?php echo $this->Form->input('twitter', array(
					'div'=>false, 'label'=>false, 'class' => 'form-control', 'type'=>'text')); ?>
				</div>

			</div>
			<!-- form input content -->
			<!-- form input content -->
			<div class="row input--field">
				<div class="col-md-3">
					<label>Facebook</label>
				</div>
				<div class="col-md-6" id="input--field">
					<?php echo $this->Form->input('facebook', array(
					'div'=>false, 'label'=>false, 'class' => 'form-control', 'type'=>'text')); ?>
				</div>

			</div>
			<!-- form input content -->
			<!-- form input content -->
			<div class="row input--field">
				<div class="col-md-3">
					<label>Linkedin</label>
				</div>
				<div class="col-md-6" id="input--field">
					<?php echo $this->Form->input('linkedin', array(
					'div'=>false, 'label'=>false, 'class' => 'form-control', 'type'=>'text')); ?>
				</div>

			</div>
			<!-- form input content -->


		</fieldset>


	</div>



	<!-- content below this line -->
</div>
<div class="card-footer">
	<div class="row">
		<div class="col-md-6">
			<!-- breadcrumb -->
			<ol class="breadcrumb">
				<li>               
					<?php
					$this->Html->addCrumb('Profile', ['controller' => 'Partners', 'action' => 'view']);
					$this->Html->addCrumb('edit', ['controller' => 'Partners', 'action' => 'edit', $partner->id]);
					echo $this->Html->getCrumbs(' / ', [
						'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
						'url' => ['controller' => 'Partners', 'action' => 'index'],
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

