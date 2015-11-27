<?php 
$admn = $this->Session->read('Auth');
$my_currency    =   $admn['User']['currency'];
$this->set(compact('my_currency'));
?>
<div class="businesplans view">

<div class="row table-title partner-table-title">

	<div class="partner-sub-menu clearfix">
	
		<div class="col-md-5 col-sm-5">
			<h2>Deal Registration</h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Deals', ['controller' => 'CampaignPartnerMailinglists', 'action' => 'listdeals']);
					$this->Html->addCrumb('view', ['controller' => 'CampaignPartnerMailinglists', 'action' => 'view']);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Partners', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
		
		<div class="col-md-7 col-sm-5">
			<div class=" btn btn-lg pull-right">
				<?=$this->Html->link('My Campaigns',['controller'=>'PartnerCampaigns','action'=>'mycampaignslist',$campaignPartnerMailinglist['campaign']->id])?>
			</div>
		</div>
	
	</div>
	
</div> <!--row-table-title-->
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<?php 
		$row = $campaignPartnerMailinglistDeal;
	?>
	
	<div class="row inner header-row ">
	
		<dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4">
			<strong><?= __('Deal registered for').' '.h($row->campaign_partner_mailinglist['first_name'].' '.$row->campaign_partner_mailinglist['last_name']) ?></strong>
		</dt>
		
		<dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
			<div class="btn-group pull-right">	      
	      <?= $this->Html->link('Edit',['action'=>'editdeal',$campaignPartnerMailinglist->id,$row->id],['class'=>'btn']) ?>
			</div>
		</dd>
		
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Mailing list'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= "'".h($campaignPartnerMailinglist['campaign']->name)."' ".__('campaign'); ?>
		</dd>
	</div>
	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Partner'); ?>
	    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
	    <?= h($row->partner_manager['partner']['company_name']) ?>
		</dd>
	</div>
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Registered by'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
	    <?= h($row->partner_manager['user']['first_name'] . ' ' . $row->partner_manager['user']['last_name']) ?>
		</dd>
	</div>
	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Registered on'); ?>
	    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
	    <?= h(date('d/m/Y',strtotime($row->closure_date))) ?>
		</dd>
	</div>
	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Product description'); ?>
	    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
	    <?= h($row->product_sold) ?>
		</dd>
	</div>
	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Quantity sold'); ?>
	    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
	    <?= h($row->quantity_sold) ?>
		</dd>
	</div>
	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Deal value'); ?>
	    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
		<?=$this->Number->currency($row->deal_value, $my_currency);?>
		</dd>
	</div>
	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Status'); ?>
	    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
	    <?php if($row->status == 'Y') {
	      echo ('<i class="fa fa-gavel"></i>'.' '.__('Closed'));
	    } else {
	      echo ('<i class="fa fa-bookmark"></i>'.' '.__('Registered'));
	    } ?>
		</dd>
	</div>

</div>


