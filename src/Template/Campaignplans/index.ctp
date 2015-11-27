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
                  <h2 class="card--title"><?= __('Campaign Plans')?></h2>
                  <h3 class="card--subtitle"></h3>
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <div class="card--actions">
<?= $this->Html->link(__('Add new'), ['controller' => 'Campaignplans', 'action' => 'add'],['class'=>'btn btn-primary pull-right']); ?>
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


<div class="Campaignplans vendors">



	<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<div class="row table-th hidden-xs">	
		
		<div class="clearfix"></div>
		<div class="col-lg-2 col-md-3 col-sm-3 col-xs-2"><?= $this->Paginator->sort('financialquarter_id','Financial Quarter') ?></div>
    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-2"><?= $this->Paginator->sort('business_case') ?></div>
    <div class="col-lg-1 hidden-md hidden-sm col-xs-1"><?= $this->Paginator->sort('required_amount') ?></div>
		<div class="col-lg-1 hidden-md hidden-sm col-xs-1"><?= $this->Paginator->sort('expected_result','Proposed Email-sends') ?></div>
		<div class="col-lg-1 hidden-md hidden-sm col-xs-1"><?= $this->Paginator->sort('expected_roi','Expected ROI') ?></div>
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
		<div class="col-lg-1 hidden-md hidden-sm col-xs-1">
      <?= $this->Number->format($businesplan->required_amount) ?>
		</div>
		<div class="col-lg-1 hidden-md hidden-sm col-xs-1">
			<?= $this->Number->format($businesplan->expected_result) ?>
		</div>
		<div class="col-lg-1 hidden-md hidden-sm col-xs-1">
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
<div class="dropdown pull-right">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    manage
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
<?php if($businesplan->status == 'Draft'): ?>
          <li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $businesplan->id], ['confirm' => __('Are you sure you want to delete?', $businesplan->id)]); ?></li>
					<li><?= $this->Html->link(__('Edit'), ['controller'=>'Campaignplans','action' => 'edit', $businesplan->id]); ?></li>
        <?php endif;?>
				<li><?= $this->Html->link(__('View'), ['controller'=>'Campaignplans','action' => 'view', $businesplan->id]); ?></li>
				<?php if($businesplan->status == 'Denied'): ?>
          <li><?= $this->Html->link(__('Copy to new draft'), ['controller'=>'Campaignplans','action' => 'add', $businesplan->id]); ?></li>
				<?php endif;?>
  </ul>
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
								<?= $this->Html->link(__('Edit'), ['controller'=>'Campaignplans','action' => 'edit', $businesplan->id],['class' => 'btn pull-right']); ?>
			        <?php endif;?>
							<?= $this->Html->link(__('View'), ['controller'=>'Campaignplans','action' => 'view', $businesplan->id],['class' => 'btn pull-right']); ?>
							<?php if($businesplan->status == 'Denied'): ?>
			          <?= $this->Html->link(__('Copy to new draft'), ['controller'=>'Campaignplans','action' => 'add', $businesplan->id],['class' => 'btn pull-right']); ?>
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


<!-- content below this line -->
</div>
<div class="card-footer">
  <div class="row">
    <div class="col-md-6">
      <!-- breadcrumb -->
      <ol class="breadcrumb">
        <li>               
<?php
					$this->Html->addCrumb('Campaign Plans', ['controller' => 'Campaignplans', 'action' => 'index']);
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
        <?= $this->Html->link(__('Back'), $last_visited_page,['class' => 'btn btn-primary btn-cancel']); ?>         


      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
<!-- /Card -->

