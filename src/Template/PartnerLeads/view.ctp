<div class="folders view">

	<div class="row table-title">

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<h2><?= __('View Lead'); ?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Leads', ['controller' => 'PartnerLeads', 'action' => 'index']);
					$this->Html->addCrumb('view', ['action' => 'view',$lead->id]);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Partners', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
	    <?= $this->Html->link(__('Go Back'), 'javascript:history.back()',['class'=>'btn btn-lg pull-right']); ?>
		</div>
		
	</div> <!--row-table-title-->

	<div class="row inner header-row ">
		<?php
		$expiry_time = strtotime($lead->expire_on);
		$expiry = date('d/m/Y',$expiry_time);
		$days_before_expiry = round(($expiry_time - time()) / 86400);
		if($days_before_expiry >= 15)
			$color = 'green'; //new
		elseif($days_before_expiry >= 5)
			$color = 'orange'; //middle
		else
			$color = 'red'; //old
		?>
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<h3><?= h($lead->first_name . ' ' . $lead->last_name) ?></h3>
		</dt>
		
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<div class="pull-left expiryLabel">
				Expires: <span style="color:<?=$color?>"><?=$expiry?></span>
			</div>
			<div class="btn-group pull-right">
				<?= $lead->response_status=='converted'?'':$this->Html->link(__('Edit'), ['controller' => 'PartnerLeads','action' => 'edit', $lead->id],['class' => 'btn pull-right']); ?>
			</div>
		</dd>
		
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Company'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $lead->company; ?>
		</dd>
	</div>
	
	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Position'); ?>
	    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $lead->position; ?>
		</dd>
	</div>
	
	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Phone'); ?>
	    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $lead->phone; ?>
		</dd>
	</div>
	
	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Email'); ?>
	    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $lead->email; ?>
		</dd>
	</div>
	
	<div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Partner Response'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?php
			    if($lead->response)
			        echo $lead->response;
			    else
			        echo 'unresponded';
			        
			    if($lead->response=='accepted')
			    {
			    	if($lead->response_status)
			    		echo ' | '.$lead->response_status;
			    }    
		    ?>
        </dd>
    </div>

	<div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Response Note'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
       		<?=($lead->response_note?date('d-m-Y',strtotime($lead->modified_on)).'<br />':'')?>
            <?=$lead->response_note?>
        </dd>
    </div>

    <div class="row">
        <div class="col-md-12">
        	<br />
        	<button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
			  Show Response Note History
			</button>
			<br /><br />
			<div class="collapse" id="collapseExample">
			  <div class="well">
			      <div class="row table-th hidden-xs">
					    <div class="col-md-2">
					      <?= __('Date'); ?>
					    </div>  
					    <div class="col-md-2">
					      <?= __('Response'); ?>
					    </div>
					    <div class="col-md-8">
					      <?= __('Response Note'); ?>
					    </div>
				  </div> <!-- /.row -->
				  <?php
				  foreach($lead->lead_response_notes as $leadnote):
				  ?>
				    <!-- Start loop -->
				    <div class="row inner hidden-xs">
				      <div class="col-lg-2">
				        <?= $leadnote->created_on; ?>
				      </div>  
				      <div class="col-lg-2">
				        <?= $leadnote->response.($leadnote->response_status?' | '.$leadnote->response_status:''); ?>
				      </div>
				      <div class="col-lg-8">
				        <?= $leadnote->response_note; ?>
				      </div>
				    </div> <!--row-->
				   <?php
				   endforeach;
				   ?>
			  </div>
			</div>
        </div>
    </div>
	
	<br /><br />
	<div class="pull-left"><h4><?= __('Lead Instructions')?></h4></div><div class="pull-right expiryLabel">Lead Expires: <?=$expiry?></div>
	<div class="clearfix"><br /><hr /></div>
	<p>Standard SLA terms: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	<div class="clearfix"><br /></div>
	<h4><?= __('Instructions / Notes from '.$lead->vendor->company_name)?></h4>
	<hr />
	<p><?=nl2br($lead->note)?></p>
	<div class="clearfix"><br /></div>
	
	<h4><?= __('Outcome of Lead')?></h4>
	<hr />
	<p>
	<?php
		switch($lead->response_status)
		{
			case 'converted':
				echo 'Converted to Deal';
				break;
			case 'nurturing':
				echo 'Nurturing: '.$lead->response_note;
				break;
			case 'qualifiedout':
				echo 'Qualified Out: '.$lead->response_note;
				break;
		}
	?>
	</p>
	<div class="clearfix"><br /></div>
	
	<!-- Assigned to: -->
	
	<div class="row inner header-row ">
	
		<dt class="col-lg-12">
			<strong><?= h('Registered Deal'); ?></strong>
		</dt>
		
	</div>
	
	<?php if($partner_lead_deal->id): ?>

	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Partner Manager'); ?>
	    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php
			$user = $partner_lead_deal->partner_manager->user;
			echo $user['first_name'].' '.$user['last_name'];
			?>
		</dd>
	</div>
	
	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Product Description'); ?>
	    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $partner_lead_deal->product_description; ?>
		</dd>
	</div>
	
	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Quantity Sold'); ?>
	    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $partner_lead_deal->quantity_sold; ?>
		</dd>
	</div>
	
	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Deal Value'); ?>
	    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $partner_lead_deal->deal_value; ?>
		</dd>
	</div>
	
	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Deal Closed'); ?>
	    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $partner_lead_deal->status=='Y'?date('d/m/Y',strtotime($partner_lead_deal->closure_date)):'No'; ?>
		</dd>
	</div>
	
	<?php else: ?>
	
	<div class="row inner text-center">   
	    <h4>No Registered Deal</h4>
	</div>
	
	<?php endif; ?>
	
</div>
<script>
$(document).ready(function(){
	function clearAllFields() {
		$('.expiryLabel').hide();
	}
	
	<?php if($lead->response!=''): ?>
	clearAllFields();
	<?php endif; ?>
});
</script>