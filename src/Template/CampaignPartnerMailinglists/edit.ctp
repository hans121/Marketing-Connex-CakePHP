<div class="campaignPartnerMailinglists index">
			
	<div class="row table-title partner-table-title">
	
		<div class="partner-sub-menu clearfix">
		
			<div class="col-md-5 col-sm-5">
				<h2><?= __('Edit mailing list contact'); ?></h2>
				<div class="breadcrumbs">
					<?php
						$this->Html->addCrumb('Email Management', ['controller' => 'PartnerCampaignEmailSettings', 'action' => 'index']);
						$this->Html->addCrumb('Mailing List', ['controller' => 'CampaignPartnerMailinglists', 'action' => 'index',$partnerCampaignEmailSetting->campaign->id]);
						$this->Html->addCrumb('edit contact', ['controller' => 'CampaignPartnerMailinglists', 'action' => 'edit']);
						echo $this->Html->getCrumbs(' / ', [
						    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
						    'url' => ['controller' => 'Partners', 'action' => 'index'],
						    'escape' => false
						]);
					?>
				</div>
			</div>
			
			<div class="col-md-7 col-sm-5">
				<div class="btn-group pull-right">
		        <?= $this->Html->link(__('Add a new contact'), ['action' => 'add',$campaign->id],['class'=>'btn btn-lg pull-right']) ?>
				</div>
			</div>
			
		</div>
		
	</div> <!--row-table-title-->
	
<div class="partnerManagers form col-centered col-lg-10 col-md-10 col-sm-10">
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
   
	<?= $this->Form->create($campaignPartnerMailinglist,['class'=>'validatedForm']); ?>
	
	<fieldset>
        
		<p><?= __('Mailing list'); ?></p>
		<div class="row inner withtop disabled">   
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
				<?= h($campaign->name); ?>
			</div>
		</div>
        
		<?php
	    $auth = $this->Session->read('Auth');
			echo $this->Form->input('first_name');
			echo $this->Form->input('last_name');
			echo $this->Form->input('email',['label'=>'E-mail address']);
			echo $this->Form->input('company');
			echo $this->element('industry-select-list');
			echo $this->Form->input('city');
			echo $this->element('country-select-list');
    ?>
    
  <?php
		if($campaignPartnerMailinglist->participate_campaign == 'Y') {
      $pchecked = true;
    } else {
      $pchecked = false;
    }
    if($campaignPartnerMailinglist->subscribe == 'Y') {
      $schecked = false;
    } else {
      $schecked = true;
    }
  ?>
  
	<?php
    if($campaignPartnerMailinglist->subscribe == 'Y') {
	?>
	
	<div class="row checkbox_group">

		<label class="col-md-4 col-xs-6 control-label">
			<?= __('Participate in this campaign')?>
		</label>
		
	  <div class="col-md-2 col-xs-6">
			<div class="onoffswitch">
				<?=	$this->Form->checkbox('participate_campaign' ,['value'=>'Y','class'=>'onoffswitch-checkbox','checked'=>$pchecked,'id'=>'participate-campaign-'.$campaignPartnerMailinglist->id])?>
				<label class="onoffswitch-label" for="participate-campaign-<?=$campaignPartnerMailinglist->id?>">
					<span class="onoffswitch-inner"></span>
					<span class="onoffswitch-switch"></span>
				</label>
			</div>
	  </div>
  
	</div>
	
	<?php
    }
	?>
	
	<div class="alert-wrap">
	<div class="alert alert-warning alert-dismissible" role="alert">
	  	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	    <h4><i class="fa fa-info-circle"></i> <?= __('Information')?></h4>
	    <p><?= __("* If a person is opted out they will be unsubscribed from ALL future mailings for ALL campaigns.  Please note that it is not possible to override this and opt a person back in again.")?></p>
	</div>
	</div>

	
	<div class="row checkbox_group">

		<label class="col-md-4 col-xs-6 control-label">
			<?= __('Opted out *')?>
		</label>
		
	  <div class="col-md-2 col-xs-6">
			<div class="onoffswitch">
				<?=	$this->Form->checkbox('subscribe' ,['value'=>'N','class'=>'onoffswitch-checkbox','checked'=>$schecked,'id'=>'subscribe-'.$campaignPartnerMailinglist->id,'disabled'=>$schecked])?>
				<label class="onoffswitch-label" for="subscribe-<?=$campaignPartnerMailinglist->id?>">
					<span class="onoffswitch-inner"></span>
					<span class="onoffswitch-switch"></span>
				</label>
			</div>
	  </div>
  
	</div>
   
    <?php echo $this->element('form-submit-bar'); ?>
    
	</fieldset>
	
  <?= $this->Form->end(); ?>
  
</div>
	
</div> <!-- /#content -->