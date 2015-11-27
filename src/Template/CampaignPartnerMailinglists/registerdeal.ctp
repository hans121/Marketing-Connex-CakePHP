<script>
	
	$(document).ready(function() {

	  $('#dealclosed').change(function() {
		  
	    var chck = false;
	    $.each($("input[id='dealclosed']:checked"), function() {
	      chck = true;
	    });

	    if(chck == true) {
					$('#closuredate').slideUp("slow", function(){
					    $(this).slideDown("slow");
					});
						
        } else {
					$('#closuredate').slideUp("slow", function(){
					    $(this).slideUp("slow");
					});
					
        }
					    
    });

	});
	
</script>
	
	
<div class="businesplans view">

<div class="row table-title partner-table-title">

	<div class="partner-sub-menu clearfix">
	
		<div class="col-md-5 col-sm-5">
			<h2><?= __('Deal registration'); ?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Deals', ['controller' => 'CampaignPartnerMailinglists', 'action' => 'listdeals']);
					$this->Html->addCrumb('view', ['controller' => 'PartnerCampaignEmailSettings', 'action' => 'view']);
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

	<div class="partnerManagers form col-centered col-lg-10 col-md-10 col-sm-10">
		
		<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
		
		<p><?= __('Mailing list'); ?></p>
		<div class="row inner withtop">   
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
				<?= h($campaignPartnerMailinglist['campaign']->name); ?>
			</div>
		</div>
		
		<p><?= __('Mailing list contact'); ?></p>
		<div class="row inner withtop">   
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
				<?= $campaignPartnerMailinglist->first_name.' '.$campaignPartnerMailinglist->last_name?>
			</div>
		</div>
		
		<?= $this->Form->create($campaignPartnerMailinglistDeal,['class'=>'validatedForm']); ?>
		
		<fieldset>
		<?php 

		$partnerlist = array();
		foreach($partnerManagerUsers as $row)
		{
			$partnerlist[$row->id] = $row->user->first_name . ' ' . $row->user->last_name;
		}
	
		echo $this->Form->input('partner_manager_id',['type'=>'select','label'=>'Manager','options'=>$partnerlist]);
		echo $this->Form->input('product_sold',['label'=>'Product description']);
		echo $this->Form->input('quantity_sold');
		echo $this->Form->input('deal_value');
		echo $this->Form->input('status', ['type'=>'select','label'=>'Deal Status','options'=>[ 'Y' => 'Closed', 'N' => 'Pending' ]]);
		?>
		
		<div class="row checkbox_group">
		
			<label class="col-md-4 col-xs-6 control-label">
				<?= __('Has this deal closed?')?>
			</label>
			
		    <div class="col-md-2 col-xs-6">
				<div class="onoffswitch">
					<?= $this->Form->checkbox('dealclosed' ,['checked'=>'', 'class'=>'onoffswitch-checkbox', 'id'=>'dealclosed', 'name'=>'dealclosed']) ?>
					<label class="onoffswitch-label" for="dealclosed">
						<span class="onoffswitch-inner"></span>
						<span class="onoffswitch-switch"></span>
					</label>
				</div>
			</div>
			
		</div>
	  
	  <div id="closuredate" style="display: none;">
	  	<?php echo $this->CustomForm->date('closure_date',date(),'Closure Date'); ?>
	  </div>

		<?php
				echo $this->Form->hidden('campaign_partner_mailinglist_id',['value'=>$mailinglist_id]);
		?>

		<?php echo $this->element('form-submit-bar'); ?>
		
		</fieldset>
		
		<?= $this->Form->end(); ?>
		
	</div>

</div>