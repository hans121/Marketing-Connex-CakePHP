<div class="campaignPartnerMailinglists index">
			
	<div class="row table-title partner-table-title">
	
		<div class="partner-sub-menu clearfix">
		
			<div class="col-md-6 col-sm-4">
				<h2><?= __('Add mailing list contact')?></h2>
				<div class="breadcrumbs">
					<?php
						$this->Html->addCrumb('Email Management', ['controller' => 'PartnerCampaignEmailSettings', 'action' => 'index']);
						$this->Html->addCrumb('Mailing List', ['controller' => 'CampaignPartnerMailinglists', 'action' => 'index',$partnerCampaignEmailSetting->campaign->id]);
						$this->Html->addCrumb('add contact', ['controller' => 'CampaignPartnerMailinglists', 'action' => 'add']);
						echo $this->Html->getCrumbs(' / ', [
						    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
						    'url' => ['controller' => 'Partners', 'action' => 'index'],
						    'escape' => false
						]);
					?>
				</div>
			</div>
			
			<div class="col-md-6 col-sm-8">
			</div>
		
		</div>
		
	</div> <!--row-table-title-->
	
<div class="partnerManagers form col-centered col-lg-10 col-md-10 col-sm-10">
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
   
		<div class="row table-title">
		
			<div class="alert-wrap">
			<div class="alert alert-warning alert-dismissible" role="alert">
			  	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			    <h4><i class="fa fa-exclamation-triangle"></i> <?= __('Warning')?></h4>
			    <p><?= __("You must ensure that the person you add has given permission to be 'opted in' to your mailing list, and that you have evidence of this on file.  * Setting 'opted out' to 'Yes' will unsubscribe the contact from all future mailings for all campaigns. Please note that it is not possible to override this and opt the contact back in again.")?></p>
			</div>
			</div>
		
		</div> <!-- /.row.table-title -->
   
	<?= $this->Form->create($campaignPartnerMailinglist,['class'=>'validatedForm']); ?>
    
		<p><?= __('Mailing list'); ?></p>
		<div class="row inner withtop">   
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
				<?= h($campaign->name); ?>
			</div>
		</div>
		
	<fieldset>
        
		<?php
	    $auth = $this->Session->read('Auth');
	    echo $this->Form->hidden('partner_id',['value'=>$auth['User']['partner_id']]);
	    echo $this->Form->hidden('vendor_id',['value'=>$auth['User']['vendor_id']]);
	    echo $this->Form->hidden('campaign_id',['value'=>$campaign->id]);
	    echo $this->Form->input('partner_campaign_email_setting_id',['type'=>'hidden','value'=>$partnerCampaignEmailSetting->id]);
	    echo $this->Form->input('partner_campaign_id',['type'=>'hidden','value'=>$pcmp_id]);
			echo $this->Form->input('first_name');
			echo $this->Form->input('last_name');
			echo $this->Form->input('email',['label'=>'E-mail address']);
			echo $this->Form->input('company');
			echo $this->element('industry-select-list');
			echo $this->Form->input('city');
			echo $this->element('country-select-list');
		?>
		
	<div class="row checkbox_group">

		<label class="col-md-4 col-xs-6 control-label">
			<?=__('Participate in this campaign')?>
		</label>
    <div class="col-md-2 col-xs-6">
			<div class="onoffswitch">
				<?= $this->Form->checkbox('participate_campaign' ,['value'=>'Y', 'hiddenField' => 'Y', 'checked'=>'checked', 'class'=>'onoffswitch-checkbox', 'id'=>'participate_campaign']) ?>
				<label class="onoffswitch-label" for="participate_campaign">
					<span class="onoffswitch-inner"></span>
					<span class="onoffswitch-switch"></span>
				</label>
			</div>
		</div>
		
	</div>
	
	<div class="row checkbox_group">

		<label class="col-md-4 col-xs-6 control-label">
			<?= __('Opted out *')?>
		</label>
		
	  <div class="col-md-2 col-xs-6">
			<div class="onoffswitch">
				<?=	$this->Form->checkbox('subscribe' ,['value'=>'Y', 'hiddenField' => 'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'subscribe'])?>
				<label class="onoffswitch-label" for="subscribe">
					<span class="onoffswitch-inner"></span>
					<span class="onoffswitch-switch"></span>
				</label>
			</div>
	  </div>
	  
	</div>
		
		<?php	
			// echo $this->Form->input('status',['type'=>'hidden','value'=>'N']);
    ?>
    
   
    <?php echo $this->element('form-submit-bar'); ?>
    
	</fieldset>
	
  <?= $this->Form->end(); ?>
  
</div>


	
</div> <!-- /#content -->