<div class="vendorManagers view">

	<div class="row table-title">

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2><?= __('Campaign'); ?></h2>
		</div>
		
	</div> <!--row-table-title-->

  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
    
	<div class="row inner header-row ">
	
		<dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4">
			<strong><?= h($campaignHistory->campaign->name); ?></strong>
		</dt>
		
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Subject Line'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($campaignHistory->campaign->subject_line); ?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Sales Value'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $this->Number->currency(round($campaignHistory->campaign->sales_value),$my_currency,['places'=>0]);?>
		</dd>
	</div>
	
	<?php
		$tot_cnt = 0;
		$tot_sent = 0;
		$tot_open = 0;
		$tot_click = 0;
	
		foreach($campaignHistory->campaign_partner_mailinglists as $row)
		{
			$tot_cnt++;
			
			if($row->status=='Y')
				$tot_sent ++;
			
			if($row->opens>0)
				$tot_open += $row->opens;
			
			if($row->clicks>0)
				$tot_click += $row->clicks;
		}
	?>
	
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Number of contacts on mailing list'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($tot_cnt); ?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Number emails sent'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($tot_sent); ?>
		</dd>
	</div>
	
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Emails opened'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($tot_open); ?>
		</dd>
	</div>	

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Emails clicked'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($tot_click); ?>
		</dd>
	</div>
	
</div>