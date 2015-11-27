<?php 
$this->layout = 'admin--ui';
?>
<script>
function checkurl() {
	var originalvalue = document.getElementById('websitefield').value;
	var value = originalvalue.toLowerCase();
	if (value && value.substr(0, 7) !== 'http://' && value.substr(0, 8) !== 'https://') {
// then prefix with http://
document.getElementById('websitefield').value = 'http://' + value;
}               
}
</script>

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
									<i class="icon ion-person-stalker"></i></div>
								</div>
								<div class="card--info">
									<h2 class="card--title"><?= __('Partner'); ?></h2>
									<h3 class="card--subtitle"></h3>
								</div>
							</div>
							<div class="col-xs-12 col-md-6">
								<div class="card--actions">
									<?= $this->Html->link(__('New Partner'), ['action' => 'addPartner'],['class'=>'btn btn-primary pull-right']); ?>
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
</div>
</div>
-->


<!-- content below this line -->
<div class="partners--view">
	<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

	<div class="row inner header-row ">

		<dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4">
			<?php
			if(trim($partner->logo_url) != '') {
				?><?= h($partner->company_name); ?>
				<a data-toggle="popover" data-html="true" data-content='<?= $this->Html->image($partner->logo_url)?>'>
					<i class="fa fa-info-circle"></i>
				</a>
				<?php
			} else {
				?>
				<?= h($partner->company_name); ?>
				<?php
			}
			?>
		</dt>

		<dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
			<?= $this->Html->link(__('Edit'), ['controller'=>'Vendors','action' => 'editPartner/'.$partner->id],['class'=>'btn btn-default pull-right']); ?>
		</dd>

	</div>

	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Website'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php 
			if (h($partner->website)!='') {
				?>
				<?= $this->Html->link(h($partner->website), h($partner->website),['target' => '_blank']); ?> <i class="fa fa-external-link"></i>
				<?php
			}
			?>
		</dd>
	</div>

	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Email'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partner->email); ?>
		</dd>
	</div>

	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Address'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partner->address); ?>
		</dd>
	</div>

	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('City'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partner->city); ?>
		</dd>
	</div>

	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('County/State'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partner->state); ?>
		</dd>
	</div>

	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Postal Code'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partner->postal_code); ?>
		</dd>
	</div>

	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Country'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partner->country); ?>
		</dd>
	</div>

	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Phone'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partner->phone); ?>
		</dd>
	</div>

	<div class="row">
		<div class="col-md-12">
			<h4><?= __('Statistics'); ?></h4>

			<hr>
		</div>
	</div>

	<?php
	$admn = $this->Session->read('Auth');
	$my_currency    =   $admn['User']['currency'];
	?>
	<div class="row table-th">   
		<dt class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

		</dt>
	</div>
	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Campaigns Completed'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($stats['campaigns_completed']); ?>
		</dd>
	</div>
	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Deals Closed'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($stats['deals_closed']); ?>
		</dd>
	</div>
	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Value of closed deals'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $this->Number->currency(round($stats['total_closed_deals']),$my_currency,['places'=>0]) ?>
		</dd>
	</div>
	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('ROI'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $this->Number->currency(round($stats['roi']),$my_currency,['places'=>0]) ?>
		</dd>
	</div>
	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Campaigns Active'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($stats['campaigns_active']); ?>
		</dd>
	</div>
	<div class="row inner">   
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Est. Revenue'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $this->Number->currency(round($stats['expected_revenue']),$my_currency,['places'=>0]) ?>
		</dd>
	</div>


	<div class="row">
		<div class="col-md-12">
			<h4><?= __('Campaign History'); ?></h4>

			<hr>
		</div>
	</div>




	<?php 
	if($campaignHistory->count()>0) {
		?>

		<div class="row table-th hidden-xs">	

			<div class="col-lg-4 col-md-4 col-sm-5 col-xs-2">
				<?= __('Campaign name'); ?>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-3 col-xs-2">
				<?= __('Financial Quarter'); ?>
			</div>				
			<div class="col-lg-2 col-md-1 hidden-sm text-right">
				<?= __('Deals Closed'); ?>
			</div>				
			<div class="col-lg-2 col-md-2 hidden-sm text-right">
				<?= __('Deals Value'); ?>
			</div>
			<div class="col-lg-1 col-md-2 col-sm-2 col-xs-2">
				<?= __('Status'); ?>
			</div>
			<div class="col-lg-1 col-md-1 col-sm-2 col-xs-3">
			</div>
		</div>

		<?php
		$j=0;
foreach($campaignHistory as $row): //print_r($row);
$j++;

// Get Total Deals and Value
$deals_closed = 0;
$deals_value = 0;
foreach($row->campaign_partner_mailinglists as $ml) {
	$deals_closed = count($ml->campaign_partner_mailinglist_deals);
	foreach($ml->campaign_partner_mailinglist_deals as $deal)
		$deals_value += $deal->deal_value;
}

?>

<div class="row inner hidden-xs">
	<div class="col-lg-4 col-md-4 col-sm-5 col-xs-2">
		<?=$row->campaign->name?>
	</div>
	<div class="col-lg-2 col-md-2 col-sm-3 col-xs-2">
		<?=$row->campaign->financialquarter->quartertitle?>
	</div>
	<div class="col-lg-2 col-md-1 hidden-sm text-right">
		<?=$deals_closed?>
	</div>
	<div class="col-lg-2 col-md-2 hidden-sm text-right">
		<?= $this->Number->currency(round($deals_value),$my_currency,['places'=>0]);?>
	</div>
	<div class="col-lg-1 col-md-2 col-sm-2 col-xs-2">
		<?=($row->campaign->status=='Y'?'<i class="fa fa-check"></i> '.__('Sent'):'<i class="fa fa-square-o"></i> '.__('Not started'))?>
	</div>
	<div class="col-lg-1 col-md-1 col-sm-2 col-xs-3">
		<div class="btn-group pull-right">
			<?= $this->Html->link(__('View'), ['action' => 'viewPartnerCampaign', $row->id],['class'=>'btn btn-default pull-right']); ?>
		</div>
	</div>
</div>

<!-- For mobile view only -->
<div class="row inner visible-xs">

	<div class="col-xs-12 text-center">
		<a data-toggle="collapse" data-parent="#accordion" href="#campaigns-<?= $j ?>">

			<h3><?=$row->campaign->name?></h3>

		</a>						
	</div>

	<div id="campaigns-<?= $j ?>" class="col-xs-12 panel-collapse collapse">

		<div class="row inner">
			<div class="col-xs-5">
				<?= __('Subject line'); ?>
			</div>
			<div class="col-xs-7">
				<?=$row->campaign->subject_line?>
			</div>
		</div>

		<div class="row inner">
			<div class="col-xs-5">
				<?= __('Deals Closed'); ?>
			</div>
			<div class="col-xs-7">
				<?=$deals_closed?>
			</div>
		</div>

		<div class="row inner">
			<div class="col-xs-5">
				<?= __('Deals Value'); ?>
			</div>
			<div class="col-xs-7">
				<?=number_format($deals_value)?>
			</div>
		</div>

		<div class="row inner">
			<div class="col-xs-5">
				<?= __('Status'); ?>
			</div>
			<div class="col-xs-7">
				<?=($row->campaign->status=='Y'?'<i class="fa fa-check"></i> '.__('Sent'):'<i class="fa fa-square-o"></i> '.__('Not started'))?>
			</div>
		</div>

		<div class="row inner">
			<div class="col-xs-12">
				<div class="btn-group pull-right">
					<?= $this->Html->link(__('View'), ['action' => 'viewPartnerCampaign', $row->id],['class'=>'btn btn-default pull-right']); ?>
				</div>
			</div>
		</div>	

	</div> <!-- /.collapse -->				

</div> <!-- /.row -->

<?php endforeach;?>

<?php echo $this->element('paginator'); ?>

<?php
} else {
	?>

	<div class="row inner withtop">

		<div class="col-sm-12 text-center">
			<?=	 __('No campaigns found') ?>
		</div>

	</div> <!--/.row.inner-->

	<?php	
}
?>




<div class="row">
	<div class="col-md-12">
		<h4><?= __('Related Managers'); ?></h4>
	</div>
</div>



<div class="row related">
	<div class="col-lg-9 col-md-8 col-sm-6 col-xs-8">
		<h4></h4>
	</div>
	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-4">
		<?= $this->Html->link(__('Add new'), ['controller' => 'Vendors', 'action' => 'addPartnerManager',$partner->id],['class'=>'btn btn-primary pull-right']); ?>
	</div>	
</div>
<hr>


<?php 
if($partner->partner_managers!='') {
	?>

	<div class="row table-th hidden-xs">	

		<div class="col-lg-4 col-md-4 col-sm-3">
			<?= __('Name'); ?>
		</div>		
		<div class="col-lg-2 col-md-2 col-sm-2">
			<?= __('Status'); ?>
		</div>
		<div class="col-lg-2 col-md-1 col-sm-1 text-center">
			<?= __('Primary Manager'); ?>
		</div>
		<div class="col-lg-4 col-md-5 col-sm-6">
		</div>
	</div>

	<?php
	$j=0;
	foreach ($partner->partner_managers as $partnerManagers): $j++
		?>

	<div class="row inner hidden-xs">
		<div class="col-lg-4 col-md-4 col-sm-3">
			<?= h($partnerManagers['user']->full_name) ?>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2">
			<?php
			if($partnerManagers->status == 'Y'){ ?>
			<i class="fa fa-check"></i> <?= __('Active'); ?> <?php
		} else if ($partnerManagers->status == 'S'){ ?>
		<i class="fa fa-exclamation-triangle"> <?= __('Suspended'); ?> <?php
	} else if ($partnerManagers->status == 'B'){ ?>
	<i class="fa fa-times"></i> <?= __('Blocked'); ?> <?php
} else if ($partnerManagers->status == 'P'){ ?>
<i class="fa fa-circle-o-notch fa-spin"></i> <?= __('Pending'); ?> <?php
} else { ?>
<i class="fa fa-circle-o"></i> <?= __('Inactive'); ?> <?php
}
?>
</div>
<div class="col-lg-2 col-md-1 col-sm-1 text-center">
	<?php if($partnerManagers->primary_contact == 'Y'){?>
	<i class="fa fa-check"></i> <?php
} ?>
</div>
<div class="col-lg-4 col-md-5 col-sm-6">
	<div class="dropdown pull-right">
		<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
			Manage
			<span class="caret"></span>
		</button>
		<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
			<li><?= $this->Html->link('<i class="icon ion-eye"></i> '.__('View'), ['action' => 'viewPartnerManager', $partnerManagers->id], ['escape' => false]); ?></li>
			<li><?= $this->Html->link('<i class="icon ion-edit"></i> '.__('Edit'), ['action' => 'editPartnerManager', $partnerManagers->id], ['escape' => false]); ?></li>
			<li><?= $this->Form->postLink('<i class="icon ion-trash-a"></i> '.__('Delete'), ['action' => 'deletePartnerManager', $partnerManagers->id], ['escape' => false],['confirm' => __('Are you sure you want to delete?', $partnerManagers->id)]); ?></li>


			<li><?php 
			if($partnerManagers->primary_contact != 'Y'){
				echo $this->Form->postLink(__('Make Primary'), ['action' => 'changePrimaryPmanager', $partnerManagers->id]);
			} ?></li>
		</ul>
	</div>



</div>
</div>

<!-- For mobile view only -->
<div class="row inner visible-xs">

	<div class="col-xs-12 text-center">
		<a data-toggle="collapse" data-parent="#accordion" href="#coupons-<?= $j ?>">

			<h3><?= h($partnerManagers['user']->full_name) ?></h3>

		</a>						
	</div>

	<div id="coupons-<?= $j ?>" class="col-xs-12 panel-collapse collapse">

		<div class="row inner">
			<div class="col-xs-5">
				<?= __('Status'); ?>
			</div>
			<div class="col-xs-7">
				<?php
				if($partnerManagers->status == 'Y'){ ?>
				<i class="fa fa-check"></i> <?= __('Active'); ?> <?php
			} else if ($partnerManagers->status == 'S'){ ?>
			<i class="fa fa-exclamation-triangle"> <?= __('Suspended'); ?> <?php
		} else if ($partnerManagers->status == 'B'){ ?>
		<i class="fa fa-times"></i> <?= __('Blocked'); ?> <?php
	} else if ($partnerManagers->status == 'P'){ ?>
	<i class="fa fa-circle-o-notch fa-spin"></i> <?= __('Pending'); ?> <?php
} else { ?>
<i class="fa fa-circle-o"></i> <?= __('Inactive'); ?> <?php
}
?>
</div>
</div>
<?php
if($partnerManagers->primary_contact == 'Y'){
	?>
	<div class="row inner">
		<div class="col-xs-5">
			<?= __('Primary Manager'); ?>
		</div>
		<div class="col-xs-7">
			<i class="fa fa-check"></i>
		</div>
	</div>
	<?php
}
?>
<div class="row inner">
	<div class="col-xs-12">
		<div class="btn-group pull-right">
			<?= $this->Form->postLink(__('Delete'), ['action' => 'deletePartnerManager', $partnerManagers->id],['class'=>'btn btn-danger pull-right'],['confirm' => __('Are you sure you want to delete?', $partnerManagers->id)]); ?>
			<?= $this->Html->link(__('Edit'), ['action' => 'editPartnerManager', $partnerManagers->id],['class'=>'btn pull-right']); ?>
			<?= $this->Html->link(__('View'), ['action' => 'viewPartnerManager', $partnerManagers->id],['class'=>'btn pull-right']); ?>
			<?php 
			if($partnerManagers->primary_contact != 'Y'){
				echo $this->Form->postLink(__('Make Primary'), ['action' => 'changePrimaryPmanager', $partnerManagers->id],['class'=>'btn pull-right']);
			} ?>
		</div>
	</div>
</div>	

</div> <!-- /.collapse -->				

</div> <!-- /.row -->


<?php endforeach; ?>

<?php
} else {
	?>

	<div class="row inner withtop">

		<div class="col-sm-12 text-center">
			<?=	 __('No related managers found') ?>
		</div>

	</div> <!--/.row.inner-->

	<?php	
}
?>


<!-- content below this line -->
</div>
</div>
<div class="card-footer">
	<div class="row">
		<div class="col-md-6">
			<!-- breadcrumb -->
			<ol class="breadcrumb">
				<li>               
					<?php
					$this->Html->addCrumb('Partners', ['controller' => 'vendors', 'action' => 'partners']);
					$this->Html->addCrumb('view', ['controller' => 'vendors', 'action' => 'viewPartner', $partner->id]);
					echo $this->Html->getCrumbs(' / ', [
						'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
						'url' => ['controller' => 'Vendors', 'action' => 'index'],
						'escape' => false
						]);
						?>
					</li>
				</ol>
			</div>
			<div class="col-md-6">
				<?= $this->Html->link(__('Back'), ['action' => 'partners'],['class'=>'btn btn-primary pull-right']); ?>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
<!-- /Card -->

