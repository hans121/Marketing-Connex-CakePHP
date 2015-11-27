<script>

	function ajaxpreviewload(poston){
    var dataString = 'mtemplate_id='+$('#master-template-id').val()+'&poston='+poston;
      $.ajax ({
      type: "POST",
      url: "<?php echo $this->Url->build([ "controller" => "EmailTemplates","action" => "ajaxpreviewimage"],true);?>",
      data: dataString,
      cache: false,
      success: function(html)
      {
        $('#ajaxpreviewimg').html(html);
      }
    });
	}

	function newajaxprvemail() {		
		var formData = {campaign_id: $('#campaign-id').val()};
		document.getElementById('previewbrowser').contentWindow.location = 'about:blank';
		  $.ajax({
		    url: "<?php echo $this->Url->build([ "controller" => "PartnerCampaignEmailSettings","action" => "ajaxpreviewemail"],true);?>",
		    type: "POST",
		    data: formData,
		    success: function (msg) {
		    	var ifrm = document.getElementById('previewbrowser');
				ifrm = (ifrm.contentWindow) ? ifrm.contentWindow : (ifrm.contentDocument.document) ? ifrm.contentDocument.document : ifrm.contentDocument;
				ifrm.document.open();
				ifrm.document.write(msg);
				ifrm.document.close();
		    },
		  });
	 } 
	  

  function newajaxprvlpg(){
		var formData = {campaign_id: $('#campaign-id').val()};
		
		$.ajax({
		    url: "<?php echo $this->Url->build([ "controller" => "PartnerCampaignEmailSettings","action" => "ajaxpreviewlpg"],true);?>",
		    type: "POST",
		    data: formData,
		    success: function (msg) {
		         $('#previewbrowser').html(msg);
		    },
		});
  }
</script>

<div class="partnerCampaignEmailSettings view">
			
	<?= $this->Form->create($partnerCampaignEmailSetting,['class'=>'validatedForm','id'=>'frmemailtmplt']); ?>
		
	<div class="row table-title">
	
		<div class="col-sm-6">
			<h2><?= __('Email')?><small><?= $this->Html->link(__('See all'), ['controller' => 'PartnerCampaignEmailSettings','action' => 'index']); ?></small></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Email Management', ['controller' => 'PartnerCampaignEmailSettings', 'action' => 'index']);
					$this->Html->addCrumb($partnerCampaignEmailSetting['campaign']->name, ['controller' => 'PartnerCampaignEmailSettings', 'action' => 'view', $partnerCampaignEmailSetting->id]);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Partners', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
		
		<div class="col-sm-6">
			<div class="btn-group pull-right hidden-xs">
        <a class="btn btn-lg pull-right" href="#" data-toggle="modal" data-target="#EMpreviewModal" onclick="newajaxprvemail();"><?=('Preview email')?></a>
			</div>
		</div>
		
		<?php echo $this->Form->input('campaign_id', ['value' => $partnerCampaignEmailSetting->campaign_id,'type' => 'hidden']);?>
                   
	</div> <!--row-table-title-->
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<div class="row inner header-row ">
		
		<dt class="col-lg-9 col-md-8 col-sm-6 col-xs-8">
			<strong><?= $partnerCampaignEmailSetting['campaign']->name?></strong>
		</dt>
		
		<dd class="col-lg-3 col-md-4 col-sm-6 col-xs-4ß">
			<div class="btn-group pull-right">
	      <?php
		      if($partnerCampaignEmailSetting->status == 'draft'):
				echo $this->Html->link(__('Edit'), ['action' => 'edit', $partnerCampaignEmailSetting->id],['class' => 'btn pull-right']); 
						      endif;
	      ?>
			</div>
		</dd>
		
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __("'From' name"); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partnerCampaignEmailSetting->from_name) ?>
		</dd>
	</div>
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __("'From' email address"); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partnerCampaignEmailSetting->from_email) ?>
		</dd>
	</div>
  <div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __("'Reply to' email address"); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partnerCampaignEmailSetting->reply_to_email) ?>
		</dd>
	</div>
  <div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __("Campaign email send limit"); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $partnerCampaignEmailSetting['campaign']->send_limit?>
		</dd>
	</div>
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __("Status"); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <?php
	      switch($partnerCampaignEmailSetting->status):
	        case 'sent':
	          echo '<i class="fa fa-inbox"></i> '.__('Sent');
	          break;
	        case 'draft':
	          echo '<i class="fa fa-pencil"></i> '.__('Draft');
	          break;
	        default:
	          echo '<i class="fa fa-clock-o"></i> '.__('Scheduled');
	          break;
	      endswitch;
	     ?>
		</dd>
	</div>
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?php
	      switch($partnerCampaignEmailSetting->status):
	        case 'sent':
	          echo __('This email was sent on');
	          break;
	        case 'draft':
	          echo __('This email was saved as a draft on');
	          break;
	        default:
	          echo __('This email is scheduled to be sent on');
	          break;
	      endswitch;
	     ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= date("d/m/Y H:i:s",strtotime($partnerCampaignEmailSetting->sent_date)); ?>
		</dd>
	</div>
	
	<?php echo $this->element('form-cancel-bar'); ?>
	
	<?= $this->Form->end(); ?>

</div> <!-- /#content -->

<script>
	 ajaxpreviewload(0);
</script>


<!-- Modal -->
<div class="modal fade" id="EMpreviewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">E-mail preview</h4>
      </div>
      <div class="modal-body">
	      <div class="intrinsic-container intrinsic-container-4x3">
		      <iframe src="#" id="previewbrowser" allowfullscreen>
						<!-- Dynamically populate this area with the email or landing page content, via the ID -->
		      </iframe>
	      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>