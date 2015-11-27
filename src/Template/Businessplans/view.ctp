<div class="Businessplans vendors">

  <div class="row table-title">

		<div class="col-sm-8">
		
			<h2><?= __('Campaign Plans')?><small><?= $this->Html->link(__('See all'), ['controller' => 'Businessplans','action' => 'index']); ?></small></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Campaign Plans', ['controller' => 'Businessplans', 'action' => 'index']);
					$this->Html->addCrumb('view', ['controller' => 'Businessplans', 'action' => 'view', $businesplan->id]);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Partners', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
			
		</div>
		
		<div class="col-sm-4">
			<div class="btn-group pull-right">
	        <?= $this->Html->link(__('Add new'), ['controller' => 'Businessplans', 'action' => 'add'],['class'=>'btn btn-lg pull-right']); ?>
			</div>
		</div>

	</div>
		
</div> <!--row-table-title-->

  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

	<div class="row inner header-row ">
	
		<dt class="col-lg-9 col-md-8 col-sm-6 col-xs-8">
			<strong>Your campaign plan submission for <?= h($businesplan->financialquarter->quartertitle) ?></strong>
		</dt>
		
		<dd class="col-lg-3 col-md-4 col-sm-6 col-xs-4">
			<div class="btn-group pull-right">
	      <?php if($businesplan->status == 'Draft'):
					echo $this->Html->link(__('Edit'), ['controller' => 'Businessplans','action' => 'edit', $businesplan->id],['class' => 'btn pull-right']);
	      endif;
	      ?>
			</div>
		</dd>
		
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Status') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php if (h($businesplan->status) == 'Draft') { ?>
				<i class="fa fa-pencil"></i> <?= __('Draft')?>
			<?php } else if (h($businesplan->status) == 'Approved') { ?>
				<i class="fa fa-check"></i> <?= __('Approved')?>
			<?php } else if (h($businesplan->status) == 'Denied') { ?>
				<i class="fa fa-times"></i> <?= __('Declined')?>
			<?php } else if (h($businesplan->status) == 'Submit') { ?>
				<i class="fa fa-refresh fa-spin"></i> <?= __('Awaiting decision')?>
			<?php } else { ?>
				<?= h($businesplan->status) ?>
			<?php } ?>
		</dd>
	</div>

<?php
if($businesplan->note) :
?>
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Note') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $businesplan->note ?>
		</dd>
	</div>
<?php 
endif;
?>
	<!--<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Required Amount') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $this->Number->format($businesplan->required_amount) ?>
		</dd>
	</div>-->
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Proposed Email-sends') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $this->Number->format($businesplan->expected_result) ?>
		</dd>
	</div>
  <!--<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('Expected ROI') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $this->Number->format($businesplan->expected_roi) ?>
		</dd>
	</div>-->
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
       <?= __('Business Case') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($businesplan->business_case); ?>
		</dd>
	</div>
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('Target Customers') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($businesplan->target_customers); ?>
		</dd>
	</div>
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Target Geography') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($businesplan->target_geography); ?>
		</dd>
	</div>
	
	
  <div class="row related">
		<div class="col-lg-9 col-md-8 col-sm-6 col-xs-8">
			<h3><?= __('Campaigns Selected')?></h3>
		</div>
	
		<div class="col-lg-3 col-md-4 col-sm-6 col-xs-4">
		</div>
	</div>
	
  <?php if (!empty($businesplan->businesplan_campaigns)): ?>
  
	<div class="partners view">
		
		<div class="row table-th hidden-xs">		
			<div class="col-lg-3 col-md-3 col-sm-3">
				<?= __('Title'); ?>
			</div>		
		</div>
		
		<?php 
	    $j=0;
	    foreach ($businesplan->businesplan_campaigns as $businesplanCampaigns): 
	    $j++;
		 ?>
				
		<div class="row inner hidden-xs">
		
			<div class="col-lg-12 col-md-12 col-sm-12">
				<?= h($businesplanCampaigns['campaign']->name) ?>
			</div>	
				
		</div>
		
		<!-- For mobile view only -->
		<div class="row inner visible-xs">
			
			<div class="col-xs-12 text-center">
			
				<a data-toggle="collapse" data-parent="#accordion" href="#cresources-<?= $j ?>">
				
					<h3><?= h($businesplanCampaigns['campaign']->name) ?></h3>
					
				</a>	
									
			</div> <!--col-->
						
			<div id="cresources-<?= $j ?>" class="col-xs-12 panel-collapse collapse">
			
				<div class="row inner">
					<div class="col-xs-5"><?= __('Title')?></div>
					<div class="col-xs-7"><?= h($businesplanCampaigns['campaign']->name) ?></div>
				</div>
				
			</div> <!-- /.collapse -->				
		
		</div> <!-- /.row -->
		
		<?php endforeach; ?>
		
		<?php endif; ?>
	 	
		<?php echo $this->element('form-cancel-bar'); ?>
		
	</div>
       
	</div>
	
</div>
