<div class="businesplans view">

<div class="row table-title partner-table-title">

	<div class="partner-sub-menu clearfix">
	
		<div class="col-md-5 col-xs-7">
			<h2><?= __('Mailing list contact')?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Email Management', ['controller' => 'PartnerCampaignEmailSettings', 'action' => 'index']);
					$this->Html->addCrumb('Mailing List', ['controller' => 'CampaignPartnerMailinglists', 'action' => 'index',$partnerCampaignEmailSetting->campaign->id]);
					$this->Html->addCrumb('view contact', ['controller' => 'CampaignPartnerMailinglists', 'action' => 'view']);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Partners', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
		
		<div class="col-md-7 col-xs-5">
			<div class="btn-group pull-right">
				<?= $this->Html->link(__('Add a new'), ['action' => 'add',$campaignPartnerMailinglist['campaign']->id],['class'=>'btn btn-lg pull-right']) ?>
			</div>
		</div>
	
	</div>
	
</div> <!--row-table-title-->

  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

	<div class="row inner header-row ">
	
		<dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4">
			<strong>
				<?= h($campaignPartnerMailinglist->first_name) ?> <?= h($campaignPartnerMailinglist->last_name) .' ('. h($campaignPartnerMailinglist->email).')' ?>
			</strong>
		</dt>
		
		<dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
			<div class="btn-group pull-right">
	      <?= $this->Html->link(__('Edit'), ['action' => 'edit', $campaignPartnerMailinglist->id],['class'=>'btn']) ?>
			</div>
		</dd>
		
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Mailing list for campaign'); ?>
    </dt>
		<dd class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
			<?= h($campaignPartnerMailinglist['campaign']->name); ?>
		</dd>
		<dd class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			<div class="btn-group pull-right">
	      <?= $this->Html->link(__('View'), ['action' => 'index', $campaignPartnerMailinglist->id],['class'=>'btn']) ?>
			</div>
		</dd>
	</div>
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Email address'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($campaignPartnerMailinglist->email) ?>
		</dd>
	</div>
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Company'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($campaignPartnerMailinglist->company) ?>
		</dd>
	</div>
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Industry'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($campaignPartnerMailinglist->industry) ?>
		</dd>
	</div>
	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('City'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($campaignPartnerMailinglist->city) ?>
		</dd>
	</div>
	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Country'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($campaignPartnerMailinglist->country) ?>
		</dd>
	</div>
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Participating in this campaign?'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
	    <?php if($campaignPartnerMailinglist->participate_campaign == 'Y') {
	      echo ('<i class="fa fa-check"></i>');
	    } else {
	      echo ('<i class="fa fa-times"></i>');
	    } ?>
		</dd>
	</div>
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Opted out?'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
	    <?php if($campaignPartnerMailinglist->subscribe == 'Y') {
	      echo __('No');
	    } else {
	      echo __('Yes');
	    } ?>
		</dd>
	</div>
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Email opened?'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
	    <?php if($campaignPartnerMailinglist->opens >0) {
	      echo ('<i class="fa fa-check"></i>');
	    } else {
	      echo ('<i class="fa fa-times"></i>');
	    } ?>
		</dd>
	</div>
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Email clicks'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
	    <?=$campaignPartnerMailinglist->clicks ?>
		</dd>
	</div>

</div>


	<div class="row related">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<h3><?= __('Deals'); ?></h3>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<btn class="pull-right btn btn-lg">
				<?=$this->Html->link('Register a deal',['controller'=>'CampaignPartnerMailinglists','action'=>'registerdeal',$campaignPartnerMailinglist['campaign']->id])?>
	    </btn>
		</div>
	</div>
	
	<?php
		if($campaignPartnerMailinglistDeal->count()>0){
	?>
	
	<div class="row table-th hidden-xs">	
	                            
		<div class="col-lg-3 col-md-3 col-sm-3">
			<?= __('Campaign'); ?>
		</div>		
		<div class="col-lg-2 col-md-2 col-sm-3">
			<?= __('Deal made by'); ?>
		</div>
		<div class="col-lg-1 hidden-md hidden-sm">
			<?= __('Deal date'); ?>
		</div>
		<div class="col-lg-2 col-md-2 hidden-sm text-right">
			<?= __('Deal value'); ?>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2">
			<?= __('Deal status'); ?>
		</div>
		<div class="col-lg-1 col-md-1 col-sm-4">
		</div>
	</div>
	
	<?php
		$j=0;
		foreach($campaignPartnerMailinglistDeal as $row):
		$j++;
	?>
	
	<div class="row inner hidden-xs">
		<div class="col-lg-3 col-md-3 col-sm-3">
			<?=$row->campaign_partner_mailinglist->campaign->name?>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-3">
			<?=$row->partner_manager->user->first_name.' '.$row->partner_manager->user->last_name?>
		</div>
		<div class="col-lg-1 hidden-md hidden-sm">
			<?=date('d/m/Y',strtotime($row->closure_date));?>
		</div>
		<div class="col-lg-2 col-md-2 hidden-sm text-right">
			<?=$this->Number->currency($row->deal_value, 'USD');?>		
		</div>
		<div class="col-lg-1 col-md-2 col-sm-2">
			<?=($row->status=='Y'?'<i class="fa fa-gavel"></i> '.__('Closed'):'<i class="fa fa-bookmark"></i> '.__('Registered'))?>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-4">
			<div class="btn-group pull-right">
				<?=$this->Html->link('Delete',['controller'=>'CampaignPartnerMailinglists','action'=>'deletedeal',$campaignPartnerMailinglist->id,$row->id],['class'=>'btn btn-danger pull-right','confirm'=>'Are you sure you want to delete this deal?'])?>
				<?=$this->Html->link('Edit',['controller'=>'CampaignPartnerMailinglists','action'=>'editdeal',$campaignPartnerMailinglist->id,$row->id],['class'=>'btn pull-right'])?>
				<?=$this->Html->link('View',['controller'=>'CampaignPartnerMailinglists','action'=>'viewdeal',$campaignPartnerMailinglist->id,$row->id],['class'=>'btn pull-right'])?>
			</div>
		</div>
	</div>
	
	<!-- For mobile view only -->
	<div class="row inner visible-xs">
	
		<div class="col-xs-12 text-center">
			<a data-toggle="collapse" data-parent="#accordion" href="#coupons-<?= $j ?>">
				
				<h3><?=$row->campaign_partner_mailinglist->campaign->name?></h3>
				
			</a>						
		</div>
					
		<div id="coupons-<?= $j ?>" class="col-xs-12 panel-collapse collapse">
		
			<div class="row inner">
				<div class="col-xs-5">
					<?= __('Deal made by'); ?>
				</div>
				<div class="col-xs-7">
					<?=$row->partner_manager->user->first_name.' '.$row->partner_manager->user->last_name?>
				</div>
			</div>

			<div class="row inner">
				<div class="col-xs-5">
					<?= __('Deal date'); ?>
				</div>
				<div class="col-xs-7">
					<?=date('d/m/Y',strtotime($row->closure_date));?>
				</div>
			</div>
			
			<div class="row inner">
				<div class="col-xs-5">
					<?= __('Deal value'); ?>
				</div>
				<div class="col-xs-7">
					<?=$this->Number->currency($row->deal_value, 'USD');?>
				</div>
			</div>

			<div class="row inner">
				<div class="col-xs-5">
					<?= __('Status'); ?>
				</div>
				<div class="col-xs-7">
					<?=($row->status=='Y'?'<i class="fa fa-gavel"></i>'.' '.__('Closed'):'<i class="fa fa-bookmark"></i>'.' '.__('Registered'))?>
				</div>
			</div>
			
			<div class="row inner">
				<div class="col-xs-12">
					<div class="btn-group pull-right">
						<?=$this->Html->link('View',['controller'=>'CampaignPartnerMailinglists','action'=>'viewdeal',$campaignPartnerMailinglist->id,$row->id],['class'=>'btn btn-default'])?>
						<?=$this->Html->link('Edit',['controller'=>'CampaignPartnerMailinglists','action'=>'editdeal',$campaignPartnerMailinglist->id,$row->id],['class'=>'btn btn-default'])?>
						<?=$this->Html->link('Delete',['controller'=>'CampaignPartnerMailinglists','action'=>'deletedeal',$campaignPartnerMailinglist->id,$row->id],['class'=>'btn btn-default','confirm'=>'Are you sure you want to delete this deal?'])?>
					</div>
				</div>
			</div>	
		
		</div> <!-- /.collapse -->				
				
	</div> <!-- /.row -->
	
	<?php
		
		endforeach;
	
		} else {
									
	?>
								
	<div class="row">
			
		<div class="col-xs-12 text-center">
			<?=	 __('No deals registered for this contact') ?>
		</div>
		
	</div> <!--/.row.inner-->
							
	<?php
	
		}
	
	?>
	
	<!-- End loop -->
	
	<?php echo $this->element('paginator'); ?>
	
	<div class="row">
		<div class="col-md-12">
			<?php echo $this->element('form-cancel-bar'); ?><br />
		</div>
	</div>
	
