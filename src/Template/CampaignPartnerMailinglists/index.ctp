<script>
	
  function updateparticipation(val,id){
    if(val.checked){
      chkval  =   'Y';
    }else{
     chkval  =   'N'; 
    }
    var dataString = 'id='+id+'&participate_campaign='+chkval+'&campaign_id=<?=$campaign->id;?>';
    $.ajax ({
      type: "POST",
      url: "<?php echo $this->Url->build([ "controller" => "CampaignPartnerMailinglists","action" => "updateparticipation"],true);?>",
      data: dataString,
      cache: false,
      success: function(html)
      {
        $('#totparticipants').html(html);
        
      }
    });
  }
  
  function updatesubscription(val,id){
    if(val.checked){
      chkval  =   'Y';
    }else{
     chkval  =   'N'; 
    }
    var dataString = 'id='+id+'&subscribe='+chkval+'&campaign_id=<?=$campaign->id;?>';
    $.ajax ({
      type: "POST",
      url: "<?php echo $this->Url->build([ "controller" => "CampaignPartnerMailinglists","action" => "updatesubscription"],true);?>",
      data: dataString,
      cache: false,
      success: function(html)
      {
        $('#totparticipants').html(html);
      }
    });
  }
  
  function bulkparticipation(){
    var test = {};           // Object
    test['id'] = [];          // Array
    $.each($("input[name='bulkid[]']:checked"), function() {
      test['id'].push($(this).val());
      
    // or you can do something to the actual checked checkboxes by working directly with 'this'
    // something like $(this).hide() (only something useful, probably) :P
    });
    $.ajax({
      url: "<?php echo $this->Url->build([ "controller" => "CampaignPartnerMailinglists","action" => "bulkupdateparticipation"],true);?>",
      type: "POST",
      data: 'ids='+test['id']+'&campaign_id=<?=$campaign->id?>',
      async: false,
      success: function (msg) {
       //alert(msg);
       window.location.replace("<?php echo $this->Url->build([ "controller" => "CampaignPartnerMailinglists","action" => "index",$campaign->id],true);?>");
      }
    });
  }
  
  function bulksubscription(){
    var test = {};           // Object
    test['id'] = [];          // Array
    $.each($("input[name='bulkid[]']:checked"), function() {
      test['id'].push($(this).val());
      
    // or you can do something to the actual checked checkboxes by working directly with 'this'
    // something like $(this).hide() (only something useful, probably) :P
    });
    $.ajax({
      url: "<?php echo $this->Url->build([ "controller" => "CampaignPartnerMailinglists","action" => "bulkupdatesubscription"],true);?>",
      type: "POST",
      data: 'ids='+test['id'],
      async: false,
      success: function (msg) {
       //alert(msg);
       window.location.replace("<?php echo $this->Url->build([ "controller" => "CampaignPartnerMailinglists","action" => "index",$campaign->id],true);?>");
      }
    });
  }
  
  function bulkdelete(){
    var test = {};           // Object
    test['id'] = [];          // Array
    $.each($("input[name='bulkid[]']:checked"), function() {
      test['id'].push($(this).val());
      
    // or you can do something to the actual checked checkboxes by working directly with 'this'
    // something like $(this).hide() (only something useful, probably) :P
    });
    $.ajax({
      url: "<?php echo $this->Url->build([ "controller" => "CampaignPartnerMailinglists","action" => "bulkdelete"],true);?>",
      type: "POST",
      data: 'ids='+test['id'],
      async: false,
      success: function (msg) {
       //alert(msg);
       window.location.replace("<?php echo $this->Url->build([ "controller" => "CampaignPartnerMailinglists","action" => "index",$campaign->id],true);?>");
      }
    });
  }
  
</script>

<div class="row table-title partner-table-title">

	<div class="partner-sub-menu clearfix">
	
		<div class="col-md-5 col-sm-4 col-xs-6">
			<h2><?= __('Mailing list'); ?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Email Management', ['controller' => 'PartnerCampaignEmailSettings', 'action' => 'index']);
					$this->Html->addCrumb('Mailing List', ['controller' => 'CampaignPartnerMailinglists', 'action' => 'index',$partnerCampaignEmailSetting->campaign->id]);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Partners', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
		
		<div class="col-md-7 col-sm-8 col-xs-6">
			<div class="btn-group pull-right">
	      <?= $this->Html->link(__('Add Contact'), ['action' => 'add',$campaign->id],['class'=>'btn btn-lg pull-right']) ?>
				<?//= $this->Html->link(__('Upload Contacts').' <i class="fa fa-cloud-upload"></i>', ['action' => 'addcsv',$campaign->id],['title' => 'Upload contacts in CSV format', 'escape' => false, 'class'=>'hidden-xs btn btn-lg pull-right']) ?>
				<?= $this->Html->link(__('CSV Template').' <i class="fa fa-cloud-download"></i>', ['action' => 'gettemplate'],['title' => 'Download CSV template', 'escape' => false, 'class'=>'btn btn-lg pull-right']) ?>	
			</div>
		</div>
	
	</div>
	
</div> <!--row-table-title-->

<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
<?= $this->Form->create('',['id'=>'frmbulkupt']); ?>

<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 filter-form">

	<h4><?= h($campaign->name); ?></h4>
	
</div>

<div class="col-lg-6 col-md-6 col-sm-6 hidden-xs filter-form">
	
	<div class="input-group input text">
	
		<?=$this->Form->input('keyword',['value' => $keyword,'placeholder' => 'Filter','class' => 'form-control','label' => '','type'=> 'text']);?>
		
		<span class="input-group-btn">
			<?= $this->Form->button('<span class="glyphicon glyphicon-search"></span>',['class'=> 'btn btn-search btn-primary']); ?>   
		</span>
		
	</div>
	
</div>


<div class="row">
	
	<div class="col-xs-12">
	
		<div class="alert-wrap">
		<div class="alert alert-warning alert-dismissible" role="alert">
		  	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		    <h4><i class="fa fa-info-circle"></i> <?= __('Information')?></h4>
		    <p><?= __("* If a person is 'opted out' they will be unsubscribed from ALL future mailings for ALL campaigns.  Please note that it is not possible to override this and opt a person back in again.")?></p>
		</div>
		</div>
	
	</div>

</div>


<div class="row table-th hidden-xs">
		
	<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<div class="clearfix"></div>
  <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
	</div>
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?= $this->Paginator->sort('email','E-mail address'); ?></div>
	<div class="col-lg-1 hidden-md hidden-sm col-xs-1"><?= $this->Paginator->sort('first_name','First') ?></div>
	<div class="col-lg-1 hidden-md hidden-sm  col-xs-1"> <?= $this->Paginator->sort('last_name','Last') ?></div>
	<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><?= __('Participate'); ?></div>
	<div class="col-lg-1 col-md-3 col-sm-4 col-xs-1 text-center"><?= __('Opted out'); ?></div>
	<div class="col-lg-4 col-md-4 col-sm-3 col-xs-4"></div>

</div> <!-- /.row .table-th -->


<div class="row inner header-row hidden-xs">
	
	<div class="col-md-1 col-sm-1">
	  <?= $this->Form->checkbox('chk[]',['class'=>'css-checkbox','label'=>false,'id'=>'bulk-selector-master-top','name'=>'bulk-selector-master-top'])?>
	  <label for="bulk-selector-master-top" class="css-checkbox-label"></label>
	</div>
	
	<div class="col-md-2 col-sm-3">
		<?= __('Bulk actions')?>
	</div>

	<div class="col-md-9 col-sm-8 btn-group">
    <?= $this->Html->link(__('Delete'), '#',['class' => 'btn btn-danger pull-right','onclick'=>'bulkdelete()', 'title' => 'Delete selection']); ?>
    <?= $this->Html->link(__('Opt out').'* <i class="fa fa-refresh"></i>', '#',['escape' => false, 'class' => 'btn btn-danger pull-right', 'onclick'=>'bulksubscription()', 'title' => 'Toggle selection']); ?>
    <?= $this->Html->link(__('Participate').' <i class="fa fa-refresh"></i>', '#',['escape' => false, 'class' => 'btn pull-right','onclick'=>'bulkparticipation()', 'title' => 'Toggle selection']); ?>
	</div>
	
</div>

<!-- Start loop -->

<?php
	$j =0;
  foreach ($campaignPartnerMailinglists as $campaignPartnerMailinglist):
 $j++;
?>
    
<div class="row inner hidden-xs">

	<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
    <?= $this->Form->checkbox('bulkid[]',['class'=>'css-checkbox bulk-selector','value'=>$campaignPartnerMailinglist->id,'label'=>false,'id'=>'bulkid-'.$campaignPartnerMailinglist->id])?>
    <label for="bulkid-<?=$campaignPartnerMailinglist->id?>" name="" class="css-checkbox-label"></label>
  </div>
	
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
		<?= h($campaignPartnerMailinglist->email); ?>
	</div>
	
	<div class="col-lg-1 hidden-md hidden-sm col-xs-1">
		<?= h($campaignPartnerMailinglist->first_name); ?>
	</div>
	
	<div class="col-lg-1 hidden-md hidden-sm col-xs-1">
		<?= h($campaignPartnerMailinglist->last_name); ?>
	</div>
	
	<div class="col-lg-1 col-md-2 col-sm-2 col-xs-1 checkbox_group checkboxes-inline-list">
		
    <?php if($campaignPartnerMailinglist->participate_campaign == 'Y') {
      $checked = true;
    } else {
      $checked = false;
    } ?>
    
    	<div class="onoffswitch">
    	<?php if($campaignPartnerMailinglist->subscribe == 'Y') {?>			
				<?=	$this->Form->checkbox('participate_campaign['.$campaignPartnerMailinglist->id.']' ,['value'=>'Y','class'=>'onoffswitch-checkbox','checked'=>$checked,'id'=>'participate-campaign-'.$campaignPartnerMailinglist->id,'onchange'=>'updateparticipation(this,'.$campaignPartnerMailinglist->id.')'])?>
		<?php }	else { ?>
				<?=	$this->Form->checkbox('participate_campaign['.$campaignPartnerMailinglist->id.']' ,['value'=>'Y','class'=>'onoffswitch-checkbox','checked'=>false,'id'=>'participate-campaign-'.$campaignPartnerMailinglist->id,'disabled'=>true])?>
		<?php } ?>

			<label class="onoffswitch-label" for="participate-campaign-<?=$campaignPartnerMailinglist->id?>">
				<span class="onoffswitch-inner"></span>
				<span class="onoffswitch-switch"></span>
			</label>
		</div>

	</div>
	
	<div class="col-lg-1 col-md-1 col-sm-2 col-xs-1 text-center">

	    <?php if($campaignPartnerMailinglist->subscribe == 'Y') {
	      echo ('<i class="fa fa-times"></i>');
	    } else {
	      echo ('<i class="fa fa-check"></i>');
	    } ?>

	</div>

	<div class="col-lg-4 col-md-5 col-sm-4 col-xs-4">

		<div class="btn-group pull-right">
			
			<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $campaignPartnerMailinglist->id,$campaign->id], ['confirm' => __('Are you sure you want to delete?', $campaignPartnerMailinglist->id,$campaign->id),'class' => 'btn btn-danger pull-right']); ?>
			<?= $this->Html->link(__('Edit'), ['action' => 'edit', $campaignPartnerMailinglist->id],['class' => 'btn pull-right']); ?>
			<?= $this->Html->link(__('View'), ['action' => 'view', $campaignPartnerMailinglist->id],['class' => 'btn pull-right']); ?>
      <?= $this->Html->link(__('Register a deal'), ['action' => 'registerdeal', $campaignPartnerMailinglist->id],['class' => 'btn btn-success pull-right']); ?>
			
		</div>
	
	</div>
	
</div> <!--row-->
		
		
<div class="row inner visible-xs">

	<div class="col-xs-12 text-center">
		
		<a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
			<h3><?= h($campaignPartnerMailinglist->email); ?></h3>
		</a>
		
	</div> <!-- /.col -->

	<div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">

		<div class="row inner">
		
		  <div class="col-xs-12">
		    <?= h($campaignPartnerMailinglist->first_name.' '.$campaignPartnerMailinglist->last_name); ?>
		  </div>
		  
    <?php
	    if($campaignPartnerMailinglist->subscribe == 'Y') {
		?>
		  
		  <div class="col-xs-8">
			  <?= __('Participate in this campaign')?>
		  </div>
		  
      <div class="col-xs-4 checkbox_group checkboxes-inline-list">
	      
		    <?php if($campaignPartnerMailinglist->subscribe == 'Y') {?>
					<div class="onoffswitch pull-right">
						<?=	$this->Form->checkbox('participate_campaign['.$campaignPartnerMailinglist->id.']' ,['value'=>'Y','class'=>'onoffswitch-checkbox','checked'=>$checked,'id'=>'participate-campaign-2-'.$campaignPartnerMailinglist->id,'onchange'=>'updateparticipation(this,'.$campaignPartnerMailinglist->id.')'])?>
						<label class="onoffswitch-label" for="participate-campaign-2-<?=$campaignPartnerMailinglist->id?>">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
		    <?php } ?>
	      
	    </div>
	  
	  <?php  
	    }
	  ?>
	    
      <div class="col-xs-12">
	      
		    <?php if($campaignPartnerMailinglist->subscribe != 'Y') {
		      echo ('The contact has opted out from all mailings');
		    } ?>
	    
	    </div>
      
		</div>
		
		<div class="row inner">
			
			<div class="col-xs-12">
			
				<div class="btn-group pull-right">
					<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $campaignPartnerMailinglist->id], ['confirm' => __('Are you sure you want to delete?', $campaignPartnerMailinglist->id),'class' => 'btn btn-danger pull-right']); ?>
					<?= $this->Html->link(__('Edit'), ['action' => 'edit', $campaignPartnerMailinglist->id],['class' => 'btn pull-right']); ?>
					<?= $this->Html->link(__('View'), ['action' => 'view', $campaignPartnerMailinglist->id],['class' => 'btn pull-right']); ?>
		      		<?= $this->Html->link(__('Register a deal'), ['action' => 'registerdeal', $campaignPartnerMailinglist->id],['class' => 'btn btn-success pull-right']); ?>
				</div>
				
			</div>
			
		</div>
				
	</div> <!--collapseOne-->
			
</div> <!--row-->


<?php endforeach; ?>

<div class="row inner header-row hidden-xs">
	
	<div class="col-md-1 col-sm-1">
	  <?= $this->Form->checkbox('chk[]',['class'=>'css-checkbox','label'=>false,'id'=>'bulk-selector-master','name'=>'bulk-selector-master'])?>
	  <label for="bulk-selector-master" class="css-checkbox-label"></label>
	</div>
	
	<div class="col-md-2 col-sm-3">
		<?= __('Bulk actions')?>
	</div>

	<div class="col-md-9 col-sm-8 btn-group">
    <?= $this->Html->link(__('Delete'), '#',['class' => 'btn btn-danger pull-right','onclick'=>'bulkdelete()', 'title' => 'Delete selection']); ?>
    <?= $this->Html->link(__('Opt out').'* <i class="fa fa-refresh"></i>', '#',['escape' => false, 'class' => 'btn btn-danger pull-right', 'onclick'=>'bulksubscription()', 'title' => 'Toggle selection']); ?>
    <?= $this->Html->link(__('Participate').' <i class="fa fa-refresh"></i>', '#',['escape' => false, 'class' => 'btn pull-right','onclick'=>'bulkparticipation()', 'title' => 'Toggle selection']); ?>
	</div>
	
</div>

<div class="row">
	
  <div class="col-md-12 text-center">
    <p class="participants text-grey"><span id="totparticipants"><?= $totcurrentparticipants?></span><?= ' '.__('participating from your remaining allowance of').' '.$campaign->send_limit?></p>
	</div>
	
</div>

<!-- End loop -->

<?= $this->Form->end(); ?>
			
<?php echo $this->element('paginator'); ?>

<script type="text/javascript">

	$('#bulk-selector-master').click(function() {
	  if ($(this).is(':checked') == true) {
	      $('.bulk-selector').prop('checked', true);
	      $('#bulk-selector-master-top').prop('checked', true);
	  }else{
	      $('.bulk-selector').prop('checked', false);
	      $('#bulk-selector-master-top').prop('checked', false);
	  }
	});
	$('#bulk-selector-master-top').click(function() {
	  if ($(this).is(':checked') == true) {
	      $('.bulk-selector').prop('checked', true);
	      $('#bulk-selector-master').prop('checked', true);
	  }else{
	      $('.bulk-selector').prop('checked', false);
	      $('#bulk-selector-master').prop('checked', false);
	  }
	});
	
</script>