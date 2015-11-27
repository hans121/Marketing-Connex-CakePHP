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
									<i class="icon ion-person-stalker"></i></div>
								</div>
								<div class="card--info">
									<h2 class="card--title"><?= __('Partner Manager'); ?></h2>
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


<!-- content below this line -->
<div class="vendors--view">


	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
    
	<div class="row inner header-row ">
	
		<dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4">
			<?= h($partnerManager->user->title. ' '.$partnerManager->user->full_name); ?>
		</dt>
		
		<dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
			<div class="btn-group pull-right">
				<?= $this->Html->link(__('Edit'), ['controller' => 'Vendors','action' => 'editPartnerManager', $partnerManager->id],['class' => 'btn btn-default pull-right']); ?>
			</div>
		</dd>
		
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Partner'); ?>
    </dt>
		<dd class="col-lg-5 col-md-5 col-sm-5 col-xs-8">
			<?= h($partnerManager->partner->company_name); ?>
		</dd>
		<dd class="col-lg-3 col-md-3 col-sm-3 col-xs-8">
<div class="dropdown pull-right">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Manage
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
  	    <li><?= $this->Html->link('<i class="icon ion-eye"></i> '.__('View'), ['controller' => 'Vendors','action' => 'viewPartner', $partnerManager->partner->id], ['escape' => false]); ?></li>
    <li><?= $this->Html->link('<i class="icon ion-edit"></i> '.__('Edit'), ['controller' => 'Vendors','action' => 'editPartner', $partnerManager->partner->id], ['escape' => false]); ?></li>

  </ul>
</div>



		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Job Title'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partnerManager->user->job_title); ?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Phone'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partnerManager->user->phone); ?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('E-mail'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partnerManager->user->email); ?>
		</dd>
	</div>
	
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Primary Manager'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php if($partnerManager->primary_manager == 'Y'){?>
	      <span class="glyphicon glyphicon-ok"></span> <?php
	      } ?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Username'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partnerManager->user->username); ?>
		</dd>
	</div>
	

<div class="row">
<div class="col-md-12">
<h4><?= __('Deals registered')?></h4>
<hr>
</div>
</div>



	
	<?php if (!empty($partnerManager->campaign_partner_mailinglist_deals)): ?>
	
	<div class="row table-th hidden-xs">		
		<div class="col-lg-3 col-md-3 col-sm-4">
			<?= __('Campaign name'); ?>
		</div>		
		<div class="col-lg-2 col-md-2 col-sm-2 text-right">
			<?= __('Deal value'); ?>
		</div>		
		<div class="col-lg-2 col-md-2 hidden-sm">
			<?= __('Product sold'); ?>
		</div>		
		<div class="col-lg-1 col-md-1 hidden-sm text-center">
			<?= __('Quantity'); ?>
		</div>		
		<div class="col-lg-2 col-md-2 col-sm-3 text-center">
			<?= __('Date'); ?>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-3">
			<?= __('Status'); ?>
		</div>
	</div>
	
	<?php 
	  $j=0;
	  foreach ($partnerManager->campaign_partner_mailinglist_deals as $deal): $j++;
	 ?>
			
	<div class="row inner hidden-xs">
	
		<div class="col-lg-3 col-md-3 col-sm-4">
			<?= h($deal->campaign_partner_mailinglist->campaign->name) ?>
		</div>	
			
		<div class="col-lg-2 col-md-2 col-sm-2 text-right">
			<?= $this->Number->currency(round($deal->deal_value),$my_currency,['places'=>0]) ?>
		</div>
		
		<div class="col-lg-2 col-md-2 hidden-sm">
			<?= h($deal->product_sold) ?>
		</div>		
		<div class="col-lg-1 col-md-1 hidden-sm text-center">
			<?= h($deal->quantity_sold) ?>
		</div>		
		<div class="col-lg-2 col-md-2 col-sm-3 text-center">
			<?= date('d/m/Y',strtotime($deal->closure_date)) ?>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-3">
	    <?php
		    if($deal->status == 'Y') {
				  echo ('<i class="fa fa-gavel"></i>'.' '.__('Closed'));
				} else {
				  echo ('<i class="fa fa-bookmark"></i>'.' '.__('Registered'));
				}
			?>
		</div>
		
	</div>
	
	
	<!-- For mobile view only -->
	<div class="row inner visible-xs">
		
		<div class="col-xs-12 text-center">
			<a data-toggle="collapse" data-parent="#accordion" href="#vmanagers-<?= $j ?>">
			
				<h3><?= date('d/m/Y',strtotime($deal->closure_date)) ?></h3>
				
			</a>	
		</div> <!--col-->
					
		<div id="vmanagers-<?= $j ?>" class="col-xs-12 panel-collapse collapse">
		
			<div class="row inner">
				<div class="col-xs-6"><?= __('Campaign name'); ?></div>
				<div class="col-xs-6"><?=h($deal->campaign_partner_mailinglist->campaign->name)?></div>
			</div>
			<div class="row inner">
				<div class="col-xs-6"><?= __('Deal value'); ?></div>
				<div class="col-xs-6"><?=$this->Number->currency(round($deal->deal_value),$my_currency,['places'=>0])?></div>
			</div>
			<div class="row inner">
				<div class="col-xs-6"><?= __('Product sold'); ?></div>
				<div class="col-xs-6"><?=h($deal->product_sold)?></div>
			</div>
			<div class="row inner">						
				<div class="col-xs-6"><?= __('Quantity'); ?></div>
				<div class="col-xs-6"><?=h($deal->quantity_sold)?></div>
			</div>
			<div class="row inner">						
				<div class="col-xs-6"><?= __('Status'); ?></div>
				<div class="col-xs-6">
    	    <?php
    		    if($deal->status == 'Y') {
    				  echo ('<i class="fa fa-gavel"></i>'.' '.__('Closed'));
    				} else {
    				  echo ('<i class="fa fa-bookmark"></i>'.' '.__('Registered'));
    				}
    			?>
				</div>
			</div>
		
		</div> <!-- /.collapse -->				
	
	</div> <!-- /.row -->

	<?php endforeach; ?>
	
	<?php endif; ?>


</div> <!-- /.vendors.view -->		

<!-- content below this line -->
</div>
<div class="card-footer">
	<div class="row">
		<div class="col-md-6">
			<!-- breadcrumb -->
			<ol class="breadcrumb">
				<li> 
					</li>
				</ol>
			</div>
			<div class="col-md-6">
				<?= $this->Html->link(__('Back'), $last_visited_page,['class' => 'btn btn-primary pull-right']); ?>		
			

			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
<!-- /Card -->

