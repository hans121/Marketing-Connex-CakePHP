<script type="text/javascript">
function denywithmsg(id) {
      var answer = confirm("Are you sure you want to deny?")
      if(answer)
      {
        var msg = prompt('Please leave a reason:','');
        document.location = '<?php echo $this->Url->build([ "action" => "approveplan"],true);?>/'+id+'/Denied/'+escape(msg);
      }
      return false;
}
</script>
<div class="businesplans view">

	<div class="row table-title">

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<h2><?= __('Campaign plans'); ?><small><?= $this->Html->link(__('See all'), ['controller' => 'VendorBusinessplans','action' => 'index']); ?></small></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Partners', ['controller' => 'vendors', 'action' => 'partners']);
					$this->Html->addCrumb('Manage Campaign Plans', ['controller' => 'VendorBusinessplans', 'action' => 'index']);
					$this->Html->addCrumb('view', ['controller' => 'VendorBusinessplans', 'action' => 'view', $businesplan->id]);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Vendors', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
	  
		</div>
		
	</div> <!--row-table-title-->
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

	<div class="row inner header-row ">
	
		<dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4">
			<strong><?= h($businesplan['partner']->company_name)?></strong>
		</dt>
		
		<dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
			<div class="btn-group pull-right">
        <?php if($businesplan->status == 'Submit'): ?>
          <?= $this->Form->postLink(__('Approve'), ['action' => 'approveplan', $businesplan->id,'Approved'], ['confirm' => __('Are you sure you want to approve?', $businesplan->id),'class' => 'btn btn-success pull-right']); ?>
          <?= $this->Html->link(__('Deny'), ['action' => 'approveplan', $businesplan->id,'Denied'], ['onclick' => 'return denywithmsg('.$businesplan->id.')','class' => 'btn btn-danger pull-right']); ?>
        <?php endif;?>
			</div>
		</dd>
		
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Assigned Financial Quarter'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($businesplan->financialquarter->quartertitle)?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Status') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php if (h($businesplan->status) == 'Approved') { ?>
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
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Required Amount') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $this->Number->currency(round($businesplan->required_amount),$my_currency,['places'=>0]);?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Proposed Email-sends') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $this->Number->format($businesplan->expected_result) ?>
		</dd>
	</div>
  <div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('Expected ROI') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $this->Number->format($businesplan->expected_roi) ?>
		</dd>
	</div>
	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Actual ROI') ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= number_format($actual_roi,2) ?>
		</dd>
	</div>
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
       <?= __('Business Case') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= __(h($businesplan->business_case)); ?>
		</dd>
	</div>
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('Target Customers') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= __(h($businesplan->target_customers)); ?>
		</dd>
	</div>
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Target Geography') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= __(h($businesplan->target_geography)); ?>
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
			
	<div class="row inner hidden-sm hidden-md hidden-lg<?php if ($j==1){?> withtop<?php }; ?>">
	
		<div class="col-sm-12">
			<?= h($businesplanCampaigns['campaign']->name) ?>
		</div>	
			
	</div>

	<div class="row inner hidden-xs">
	
		<div class="col-sm-9">
			<?= h($businesplanCampaigns['campaign']->name) ?>
		</div>
		<div class="col-sm-3">
			<div class="btn-group pull-right">
				<?= $this->Html->link(__('Edit'), ['controller'=>'Campaigns','action' => 'edit', $businesplanCampaigns['campaign']->id],['class'=>'btn pull-right']); ?>
				<?= $this->Html->link(__('View'), ['controller'=>'Campaigns','action' => 'view', $businesplanCampaigns['campaign']->id],['class'=>'btn pull-right']); ?>
			</div>
		</div>

	</div>
	
	<?php endforeach; ?>
	
	<?php endif; ?>
        
</div>