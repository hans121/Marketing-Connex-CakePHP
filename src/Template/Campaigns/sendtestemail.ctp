<div class="container">
	<div class="row">
		<!-- Card Projects -->
		<div class="col-md-12">
			<div class="card">

				<div class="card--header">

					<div class="row">
						<div class="col-xs-12 col-md-6">
							<div class="card--icon">
								<div class="bubble">
									<i class="icon ion-compose"></i></div>
								</div>
								<div class="card--info">
									<h2 class="card--title"><?= __('Send Test Email')?></h2>
									<h3 class="card--subtitle"></h3>
								</div>
							</div>
							<div class="col-xs-12 col-md-6">
								<div class="card--actions">
									<?= $this->Html->link(__('Add new'), ['controller' => 'Campaigns', 'action' => 'add'], ['class' => 'btn btn-primary pull-right']); ?>
								</div>
							</div>
						</div>   
					</div>




					<div class="card-content">
						<div class="row">
							<div class="col-md-12">
								<h4> Instructions:</h4>
								<p> Please fill out the details below to send out a test email - to include more than 1 recipient, please separate each name / email address with a comma.
								</p>
								<hr>
							</div>
						</div>
						<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
						<?= $this->Form->create($user,['class'=>'validatedForm']); ?>


						<!-- form input content -->
						<div class="row input--field">
							<div class="col-md-3">
								<label>Name</label>
							</div>
							<div class="col-md-6" id="input--field">
								<?php echo $this->Form->input('to_name', array(
								'div'=>false, 'label'=>false, 'placeholder' => 'to name', 'class' => 'form-control')); ?>

							</div>

						</div>
						<!-- form input content -->  
						<!-- form input content -->
						<div class="row input--field">
							<div class="col-md-3">
								<label>Email</label>
							</div>
							<div class="col-md-6" id="input--field">
								<?php echo $this->Form->input('to_email', array(
								'div'=>false, 'label'=>false, 'placeholder' => 'to email', 'class' => 'form-control')); ?>

							</div>

						</div>
						<!-- form input content -->   
						<!-- form input content -->
						<div class="row input--field">
							<div class="col-md-3">
								<label>Subject</label>
							</div>
							<div class="col-md-6" id="input--field">
								<?php echo $this->Form->input('subject', array(
								'div'=>false, 'label'=>false, 'placeholder' => 'your subject', 'class' => 'form-control')); ?>

							</div>

						</div>
						<!-- form input content -->                              

					</div>
					<div class="card-footer">
						<!-- breadcrumb -->
						<ol class="breadcrumb">
							<li>               
								<?php
								$this->Html->addCrumb('Campaigns', ['controller' => 'Campaigns', 'action' => 'index']);
								$this->Html->addCrumb('Send test email', ['controller' => 'Campaigns', 'action' => 'sendtestemail', $campaign->id]);
								echo $this->Html->getCrumbs(' / ', [
									'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
									'url' => ['controller' => 'Vendors', 'action' => 'index'],
									'escape' => false
									]);
									?>
								</li>
							</ol>

							<?= $this->Form->button(__('Submit'),['class'=> 'btn btn-primary pull-right']); ?>
							<?= $this->Html->link(__('Cancel'), $last_visited_page,['class' => 'btn btn-default pull-right']); ?>                  

						</div>
					</div>
				</div>
			</div>
		</div>