<div class="Businessplans vendors">

  <div class="index row table-title partner-table-title">

		<div class="col-xs-8">
		
			<h2><?= __('Campaign Plans')?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Campaign Plans', ['controller' => 'Businessplans', 'action' => 'index']);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Partners', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
			
		</div>
		
		<div class="col-xs-4">
			<div class="btn-group pull-right">
	        <?= $this->Html->link(__('Add new'), ['controller' => 'Businessplans', 'action' => 'add'],['class'=>'btn btn-lg pull-right']); ?>
			</div>
		</div>

	</div>
		
</div> <!--row-table-title-->

	<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<div class="row table-th hidden-xs">	
		
		<div class="clearfix"></div>
		<div class="col-lg-2 col-md-3 col-sm-3 col-xs-2"><?= $this->Paginator->sort('financialquarter_id','Financial Quarter') ?></div>
    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-2"><?= $this->Paginator->sort('business_case') ?></div>
    <div class="col-lg-1 hidden-md hidden-sm col-xs-1 text-right"><?= $this->Paginator->sort('required_amount') ?></div>
		<div class="col-lg-1 hidden-md hidden-sm col-xs-1 text-right"><?= $this->Paginator->sort('expected_result','Proposed Email-sends') ?></div>
		<div class="col-lg-1 hidden-md hidden-sm col-xs-1 text-right"><?= $this->Paginator->sort('expected_roi','Expected ROI') ?></div>
    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-2"><?= $this->Paginator->sort('status') ?></div>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
		
	</div> <!--row-table-th-->
		
	<!-- Start loop -->
	
	<?php 
		$j =0;
		foreach ($businesplans as $businesplan):
		$j++;
	?>
	
	<div class="row inner hidden-xs">
	
		<div class="col-lg-2 col-md-3 col-sm-3 col-xs-2">
			<?= h($businesplan->financialquarter->quartertitle)?>
			<?php if(!in_array($businesplan->id,$myviewedbplnsarray)){ ?>
        <span class="badge pull-left"><?=__('New')?></span>&nbsp;
			<?php } ?>
		</div>
    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-2">
      <?= $businesplan->business_case ?>
		</div>
		<div class="col-lg-1 hidden-md hidden-sm col-xs-1 text-right">
      <?= $this->Number->format($businesplan->required_amount) ?>
		</div>
		<div class="col-lg-1 hidden-md hidden-sm col-xs-1 text-right">
			<?= $this->Number->format($businesplan->expected_result) ?>
		</div>
		<div class="col-lg-1 hidden-md hidden-sm col-xs-1 text-right">
      <?= $this->Number->format($businesplan->expected_roi) ?>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
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
    </div>

		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-3">
		
			<div class="btn-group pull-right">
				<?php if($businesplan->status == 'Draft'): ?>
          <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $businesplan->id], ['confirm' => __('Are you sure you want to delete?', $businesplan->id),'class' => 'btn btn-danger pull-right']); ?>
					<?= $this->Html->link(__('Edit'), ['controller'=>'Businessplans','action' => 'edit', $businesplan->id],['class' => 'btn pull-right']); ?>
        <?php endif;?>
				<?= $this->Html->link(__('View'), ['controller'=>'Businessplans','action' => 'view', $businesplan->id],['class' => 'btn pull-right']); ?>
				<?php if($businesplan->status == 'Denied'): ?>
          <?= $this->Html->link(__('Copy to new draft'), ['controller'=>'Businessplans','action' => 'add', $businesplan->id],['class' => 'btn pull-right']); ?>
				<?php endif;?>
			</div>
			
		</div>
		
	</div> <!--row-->
		
		
		<div class="row inner visible-xs">
		
			<div class="col-xs-12 text-center">
				
				<a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
					
					<h3>
						<?= h($businesplan->financialquarter->quartertitle)?>
            <?php if(!in_array($businesplan->id,$myviewedbplnsarray)){ ?>
                <span class="badge"><?=__('New')?></span>
            <?php } ?>
					</h3>
					
				</a>
				
			</div> <!--col-->

				
			<div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">
				
        <div class="row inner">
				
					<div class="col-xs-6">
						<?= __('Business Case')?>
					</div>
					
					<div class="col-xs-6">
						 <?= $businesplan->business_case ?>
					</div>
				
				</div>
				<div class="row inner">
				
					<div class="col-xs-6">
						<?= __('Required amount')?>
					</div>
					
					<div class="col-xs-6">
						 <?= $this->Number->format($businesplan->required_amount) ?>
					</div>
				
				</div>
        <div class="row inner">
				
					<div class="col-xs-6">
						<?= __('Proposed Email-sends')?>
					</div>
					
					<div class="col-xs-6">
						<?= $this->Number->format($businesplan->expected_result) ?>
					</div>
				
				</div>
				
				<div class="row inner">
				
					<div class="col-xs-6">
						<?= __('Expected ROI')?>
					</div>
					
					<div class="col-xs-6">
						 <?= $this->Number->format($businesplan->expected_roi) ?>
					</div>
				
				</div>
        <div class="row inner">
				
					<div class="col-xs-6">
						<?= __('Status')?>
					</div>
					
					<div class="col-xs-6">
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
					</div>
				
				</div>
				
				<div class="row inner">
				
					<div class="col-xs-12">
					
						<div class="btn-group pull-right">
							<?php if($businesplan->status == 'Draft'): ?>
			          <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $businesplan->id], ['confirm' => __('Are you sure you want to delete?', $businesplan->id),'class' => 'btn btn-danger pull-right']); ?>
								<?= $this->Html->link(__('Edit'), ['controller'=>'Businessplans','action' => 'edit', $businesplan->id],['class' => 'btn pull-right']); ?>
			        <?php endif;?>
							<?= $this->Html->link(__('View'), ['controller'=>'Businessplans','action' => 'view', $businesplan->id],['class' => 'btn pull-right']); ?>
							<?php if($businesplan->status == 'Denied'): ?>
			          <?= $this->Html->link(__('Copy to new draft'), ['controller'=>'Businessplans','action' => 'add', $businesplan->id],['class' => 'btn pull-right']); ?>
							<?php endif;?>
						</div>
						
					</div>
					
				</div>
				
			</div>
			
		</div> <!--row-->
	
	
<!-- End loop -->

			
<?php endforeach; ?>


<?php echo $this->element('paginator'); ?>
		
		
</div><!-- /.container -->

	</div> <!-- /#content -->