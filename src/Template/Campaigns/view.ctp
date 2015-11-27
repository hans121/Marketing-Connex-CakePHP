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
								<div class="bubble"><i class="icon ion-compose"></i></div>
							</div>
							<div class="card--info">
								<h2 class="card--title"><?= h($campaign->name) ?></h2>
								<h3 class="card--subtitle"></h3>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="card--actions">
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
					<!-- content -->



					<div class="Campaigns view">



						<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>



						<div class="row inner">   
							<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
								<?= __('Assigned Financial Quarter'); ?>
							</dt>
							<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
								<?= $campaign->has('financialquarter') ? $this->Html->link($campaign->financialquarter->quartertitle, ['controller' => 'Financialquarters', 'action' => 'view', $campaign->financialquarter->id]) : '' ?>
							</dd>
						</div>

<!--
<div class="row inner">   
<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
<?= __('Campaign Type'); ?>
</dt>
<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
<?php
if($campaign->campaign_type == 'e-mail'){ ?>
<i class="fa fa-at"></i> <?= __('E-mail') ?>
<?php
} else if ($campaign->campaign_type == 'Royal Mail'){ ?>
<i class="fa fa-envelope-o"></i> <?= __('Postal') ?>
<?php
} else if ($campaign->campaign_type == 'leaflet'){ ?>
<i class="fa fa-copy"></i> <?= __('Leaflet') ?>
<?php
} else { ?>
<?= h($campaign->campaign_type) ?>
<?php
}
?>
</dd>
</div>
-->

<div class="row inner">   
	<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
		<?= __('Target Market'); ?>
	</dt>
	<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
		<?php 
		if (h($campaign->target_market) == 'smb') {
			echo('SMB');
		} else {
			echo (h($campaign->target_market));
		} ?>
	</dd>
</div>
<!--
<div class="row inner">   
<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
<?= __('Example Subject line for partners'); ?>
</dt>
<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
<?= h($campaign->subject_line) ?>
</dd>
</div>
//-->
<!--
<div class="row inner">   
<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
<?= __('Available To'); ?>
</dt>
<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">

<?php
if($campaign->available_to == 'password'){ ?>
<i class="fa fa-lock"></i> <?= __('Only those with a password'); ?> <?php
} else if ($campaign->available_to == 'all'){ ?>
<i class="fa fa-unlock"></i></span> <?= __('All'); ?> <?php
} else { ?>
<i class="fa fa-trophy"></i> <?= __('Top 100 only'); ?> <?php
}
?>

</dd>
</div>
-->
<div class="row inner">   
	<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
		<?= __('Expected average deal value'); ?>
	</dt>
	<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
		<?= $this->Number->currency(h($campaign->sales_value),'USD',['places'=>0]) ?>
	</dd>
</div>
<div class="row inner">   
	<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
		<?= __('Maximum e-mail sends per partner'); ?>
	</dt>
	<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
		<?= h($campaign->send_limit) ?>
			<?= $this->Html->link(__('Upgrade'), ['controller' => 'Vendors','action' => 'sendUpgrade'],['class' => 'btn btn-primary pull-right']); ?>
	</dd>
</div>
<div class="row inner">   
	<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
		<?= __('HTML e-mail').' '.'<span class="badge">'.($campaign->email_templates[0]->spam=='N' && isset($campaign->email_templates[0]->spam)?'Spam verified <i class="fa fa-shield"></i>':'Unverified <i class="fa fa-exclamation-triangle"></i>').'</span>' ; ?>
	</dt>
	<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">

		<?php
		if($campaign->include_landing_page == 'Y'){
			echo "<i class=\"fa fa-check\"></i>";
		} else {
			echo "<i class=\"fa fa-times\"></i>";
		}
		?>



		<div class="dropdown pull-right">
			<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				Manage
				<span class="caret"></span>
			</button>


			<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				<li>	<?= $this->Form->postLink('<i class="fa fa-wrench"></i> '.__('Edit'), ['controller' => 'EmailTemplates','action' => 'managemail',$campaign->id], ['escape' => false]); ?></li>
				<?php


				if ($campaign->email_templates[0]) {
					?>

					<li><?= $this->Html->link('<i class="fa fa-shield"></i> '. __('Test Email'), ['controller' => 'Campaigns','action' => 'browserandspamchecker',$campaign->id],['escape' => false, 'onclick'=>'showloader()']); ?>
					</li>				

					<li><?= $this->Html->link('<i class="fa fa-send"></i> '.__('Send test'), ['controller' => 'Campaigns','action' => 'sendtestemail',$campaign->id],['escape' => false]); ?>
					</li>
					<li><?= $this->Html->link('<i class="fa fa-search"></i> '.__('View email online'), ['controller' => 'EmailTemplates','action' => 'view',$email_id],['escape' => false, 'target'=>'_blank']); ?>
					</li>
					<?php
				}
				?>

			</ul>
		</div>






	</dd>
</div>

<!-- <div class="row inner">   
<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
<?= __('Mobile Delivery'); ?>
</dt>
<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
<?php
// if($campaign->mobile_delivery == 'Y'){
// 	echo "<i class=\"fa fa-check\"></i>";
// } else {
// echo "<i class=\"fa fa-times\"></i>";
// }
?>
</dd>
</div> -->

<div class="row inner">   
	<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
		<?= __('Landing Page'); ?>
	</dt>
	<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
		<?php
		if($campaign->include_landing_page == 'Y'){
			echo "<i class=\"fa fa-check\"></i>";
		} else {
			echo "<i class=\"fa fa-times\"></i>";
		}
		?>

		<div class="dropdown pull-right">
			<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				Manage
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				<li><?= $this->Form->postLink('<i class="fa fa-wrench"></i> '.__('Edit'), ['controller' => 'LandingPages','action' => 'managepage',$campaign->id], ['escape' => false]); ?></li>
				<?php
				if ($landingpages) {
					?>
					<li><?= $this->Html->link('<i class="fa fa-search"></i> '.__('Preview'), ['controller' => 'LandingPages','action' => 'view',$landingpages->id],['escape' => false, 'target'=>'_blank']); ?></li>
					<?php
				}
				?>
			</ul>
		</div>



	</dd>
</div>

<div class="row related">
	<div class="col-lg-9 col-md-8 col-sm-6 col-xs-8">
		<h4><?= __('Campaign Resources')?></h4>
	</div>
	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-4">
	</div>	
</div>

<?php if (!empty($campaign->campaign_resources)) { ?>

<div class="row table-th hidden-xs">		
	<div class="col-lg-3 col-md-3 col-sm-3">
		<?= __('Title'); ?>
	</div>		
	<div class="col-lg-2 col-md-2 col-sm-2">
	</div>
	<div class="col-lg-1 col-md-1 col-sm-1">
	</div>
</div>

<?php 
$j=0;
foreach ($campaign->campaign_resources as $resrc): $j++;
?>

<div class="row inner hidden-xs">

	<dt class="col-lg-7 col-md-7 col-sm-7">
		<?= h($resrc->title) ?>
	</dt>	

	<dd class="col-lg-5 col-md-5 col-sm-5">
		<div class="btn-group pull-right">
			<?php echo $this->Form->postLink(__('Delete'), ['controller' => 'CampaignResources', 'action' => 'delete', $resrc->id],['class'=>'btn btn-danger pull-right'], ['confirm' => __('Are you sure you want to remove the resource?', $resrc->id)]);?>
			<?php echo $this->Form->postLink(__('Download'), ['controller' => 'CampaignResources', 'action' => 'downloadfile', $resrc->id],['class'=>'btn pull-right']);?>
		</div>
	</dd>

</div>


<!-- For mobile view only -->
<div class="row inner visible-xs">

	<div class="col-xs-12 text-center">

		<a data-toggle="collapse" data-parent="#accordion" href="#cresources-<?= $j ?>">
			<h3><?= h($resrc->title) ?></h3>
		</a>	

	</div> <!--col-->

	<div id="cresources-<?= $j ?>" class="col-xs-12 panel-collapse collapse">

		<div class="row inner">
			<div class="col-xs-12">
				<div class="btn-group pull-right">
					<?php echo $this->Form->postLink(__('Download'), ['controller' => 'CampaignResources', 'action' => 'downloadfile', $resrc->id],['class'=>'btn pull-right']);?></div>
					<?php echo $this->Form->postLink(__('Remove'), ['controller' => 'CampaignResources', 'action' => 'delete', $resrc->id],['class'=>'btn pull-right'], ['confirm' => __('Are you sure you want to remove the resource?', $resrc->id, $campaign->id)]);?>
				</div>
			</div>
		</div>

	</div> <!-- /.collapse -->				
	<?php

	endforeach;

} else {

	?>

	<div class="row inner withtop">

		<div class="col-sm-12 text-center">
			<?=	 __('No resources found') ?>
		</div>

	</div> <!--/.row.inner-->

	<?php

}

?>

</div> <!-- /.row -->

<div class="modal fade" id="loader" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="text-center">
				<p style="margin-top:10px;">Loading! Please wait... <span class="fa fa-circle-o-notch fa-spin"></span></p>
			</div>
		</div>
	</div>
</div>
<script>
$('.preload').click(function() {
	$("#loader").modal("show");
});
</script>



</div>
<div class="card-footer">
	<div class="row">
		<div class="col-md-6">
			<!-- breadcrumb -->
			<ol class="breadcrumb">
				<li>               
					<?php
					$this->Html->addCrumb('Campaigns', ['controller' => 'Campaigns', 'action' => 'index']);
					$this->Html->addCrumb(h($campaign->name), ['controller' => 'Campaigns', 'action' => 'view', $campaign->id]);
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
				<?= $this->Html->link('Back', ['controller' => 'Campaigns', 'action' => 'index'], ['class' => 'btn btn-primary pull-right']); ?>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
<!-- /Card -->

