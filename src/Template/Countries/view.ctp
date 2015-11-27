<div class="vendors view">

	<div class="row table-title">

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		
			<h2><?= __('Country'); ?></h2>
			
		</div>
		
	</div> <!--row-table-title-->
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

	<div class="row inner header-row ">
	
		<dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4">
		
			<strong><?= h($country->title); ?></strong>
			
		</dt>
		
		<dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
		
			<div class="btn-group pull-right">
				<?= $this->Html->link(__('Edit'), ['action' => 'edit', $country->iso_alpha_code_2],['class' => 'btn pull-right']); ?>
				<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $country->iso_alpha_code_2], ['confirm' => __('Are you sure you want to delete?', $country->iso_alpha_code_2),'class' => 'btn btn-danger pull-right']); ?>
			</div>
			
		</dd>
		
	</div>

  <div class="row inner">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Title'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($country->iso_alpha_code_3); ?>
		</dd>
  </div>
  	
  <div class="row inner">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Iso Alpha Code 2'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($country->iso_alpha_code_2); ?>
		</dd>
  </div>
  
  <div class="row inner">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Iso Numeric'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($country->iso_numeric); ?>
		</dd>
  </div>

</div>

