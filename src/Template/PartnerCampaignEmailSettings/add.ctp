<script>
	
	function newajaxprvbrowsr() {
		var formData = new FormData($('#frmemailtmplt')[0]);
		document.getElementById('previewbrowser').contentWindow.location = 'about:blank';
		  $.ajax({
		    url: "<?php echo $this->Url->build([ "controller" => "PartnerCampaignEmailSettings","action" => "ajaxpreviewemail"],true);?>",
		    type: "POST",
		    data: formData,
		    async: false,
		    success: function (msg) {
	 			var ifrm = document.getElementById('previewbrowser');
				ifrm = (ifrm.contentWindow) ? ifrm.contentWindow : (ifrm.contentDocument.document) ? ifrm.contentDocument.document : ifrm.contentDocument;
				ifrm.document.open();
				ifrm.document.write(msg);
				ifrm.document.close();
 				//iframe = document.getElementById('previewbrowser');
				//iframe.contentWindow.document.write(msg);
		    },
		    cache: false,
		    contentType: false,
		    processData: false
		  });
	 } 
	    
	function savedraft(){
	  $('#status').val('draft');
	  $( "#frmemailtmplt" )[0].submit();
	  //document.frmemailtmplt.submit();
	}
	    
	function schedule(){
	  $('#status').val('schedule');
	  $( "#frmemailtmplt" )[0].submit();
	  //document.frmemailtmplt.submit();
	}
	
	function sentnow(){
	  $('#status').val('sent');
	  $( "#frmemailtmplt" )[0].submit();
	  //document.frmemailtmplt.submit();
	}
	    
	function sendtestmail(){	  
	  bootbox.prompt('Enter Test Email recipients (Comma Separated)',function(result){
		if(result)
		{
			bootbox.alert('<span class="text-info">Please wait while we are sending your test email...</span>',function(){
			
			  	var formData = new FormData($('#frmemailtmplt')[0]);
			  
				$.ajax({
					url: "<?php echo $this->Url->build([ "controller" => "PartnerCampaignEmailSettings","action" => "ajaxsenttestemail"],true);?>/"+encodeURIComponent(result),
					type: "POST",
					data: formData,
					async: false,
					success: function (msg) {
						bootbox.alert('<span class="text-info">'+msg+'</span>');
					},
					cache: false,
					contentType: false,
					processData: false
				});
			
			});
		}
	  })
	}
	
	$(document).ready(function() {

	  $('#sntlater').change(function() {
		  
	    var chck = false;
	    $.each($("input[id='sntlater']:checked"), function() {
	      chck = true;
	    });

	    if(chck == true) {
					$('#scheduletime').slideUp("slow", function(){
					    $(this).slideDown("slow");
			        var newElementTwo= $('<a class="pull-right btn btn-lg btn-pad-left" onclick="schedule();" href="#">Schedule</a>');
			        $('#sentschedulebtn').html(newElementTwo);
					});
						
        } else {
					$('#scheduletime').slideUp("slow", function(){
					    $(this).slideUp("slow");
			        var newElementTwo= $('<a class="pull-right btn btn-lg btn-pad-left" onclick="sentnow();" href="#">Send now</a>');
			        $('#sentschedulebtn').html(newElementTwo);
					});
					
        }
					    
    });
    
    $('#auto-tweet').change(function() {
		  
	    var tweetchck = false;
	    $.each($("input[id='auto-tweet']:checked"), function() {
	      tweetchck = true;
	    });

	    if(tweetchck == true) {
					$('#tweetbox').slideUp("slow", function(){
					    $(this).slideDown("slow");
					});
						
        } else {
					$('#tweetbox').slideUp("slow", function(){
					    $(this).slideUp("slow");
					});
					
        }
					    
    });
    
    $('#post-facebook').change(function() {
		  
	    var fbchck = false;
	    $.each($("input[id='post-facebook']:checked"), function() {
	      fbchck = true;
	    });

	    if(fbchck == true) {
					$('#facebookbox').slideUp("slow", function(){
					    $(this).slideDown("slow");
					});
						
        } else {
					$('#facebookbox').slideUp("slow", function(){
					    $(this).slideUp("slow");
					});
					
        }
					    
    });
    
    $('#post-linkedin').change(function() {
		  
	    var lichck = false;
	    $.each($("input[id='post-linkedin']:checked"), function() {
	      lichck = true;
	    });

	    if(lichck == true) {
					$('#linkedinbox').slideUp("slow", function(){
					    $(this).slideDown("slow");
					});
						
        } else {
					$('#linkedinbox').slideUp("slow", function(){
					    $(this).slideUp("slow");
					});
					
        }
					    
    });
    
	var max = 140;
	$('#tweet-text').keyup(function() {	
		updateCounter(this,'#tweet_text_counter')		
	});
	
	$('#linkedin-text').keyup(function() {	
		updateCounter(this,'#linkedin_text_counter')
		 //limitText(this,'#linkedin_text_counter',max);
	});
	/* 
	$('#facebook-text').keyup(function() {	
		updateCounter(this,'#facebook_text_counter')
	});
	*/
	function updateCounter(obj,field) {
		var emailurltag = '[*!EMAILURL!*]';
		var txtlen = $(obj).val().length;
		if($(obj).val().match(/(.*?)\[\*\!EMAILURL\!\*\](.*?)/))
		{
			txtlen = txtlen - (emailurltag.length) + <?=strlen($email_url)?>;
		}
		
		if(txtlen > max) {
			$(obj).val($(obj).val().substr(0, max));
		}else {
			$(field).html((max - txtlen) + ' characters remaining');
		}
	}
	
	$('#post-linkedin').change();
    
    $('#post-facebook').change();
    
    $('#auto-tweet').change();
});
	
</script>


<?= $this->Form->create($partnerCampaignEmailSetting,['class'=>'validatedForm','id'=>'frmemailtmplt']); ?>

<script>
	$(document).ready(function() {

	  $('#campaign-id').change(function() {
	  	var cmpid = this.value;
	  	showsubjectoptions(cmpid);
	  });

	  function showsubjectoptions(cmpid)
	  {
	  	var menus = [];
	  	<?php
	  	foreach($option_campaigns as $cmp)
	  	{
	  		$options = [];
	  		if($cmp->email_templates[0]->subject_option1)
	  			$options['subject_option1']=$cmp->email_templates[0]->subject_option1;
	  		if($cmp->email_templates[0]->subject_option2)
	  			$options['subject_option2']=$cmp->email_templates[0]->subject_option2;
	  		if($cmp->email_templates[0]->subject_option3)
	  			$options['subject_option3']=$cmp->email_templates[0]->subject_option3;
	  		if(count($options)==0)
	  			$options['subject_option1']='[default]';
	  		echo "menus[{$cmp->id}]='".$this->Form->input('subject_option', ['label'=>'Preferred Subject Line', 'options'=>$options,'class'=>'form-control'])."';\r\n\t\t";
	  	}
	  	?>
	  	$('#subject_line').html(menus[cmpid]);
	  }

	  showsubjectoptions(<?=$option_campaigns->first()->id?>);

	});
</script>

<fieldset>

	<div class="row table-title partner-table-title">
	
		<div class="partner-sub-menu clearfix">
		
			<div class="col-md-12 col-sm-12">
				<h2><?= __('New Email')?></h2>
				<div class="breadcrumbs">
					<?php
						$this->Html->addCrumb('Email Management', ['controller' => 'PartnerCampaignEmailSettings', 'action' => 'index']);
						$this->Html->addCrumb('add', ['controller' => 'PartnerCampaignEmailSettings', 'action' => 'add']);
						echo $this->Html->getCrumbs(' / ', [
						    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
						    'url' => ['controller' => 'Partners', 'action' => 'index'],
						    'escape' => false
						]);
					?>
				</div>
			</div>
		
		</div>
		
	</div> <!--row-table-title-->
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

	<div class="partnerCampaignEmailSettings form col-centered col-lg-10 col-md-10 col-sm-10">

	  <?php
	    $admn = $this->Session->read('Auth');
	  ?>
	
		<?php
		echo $this->Form->input('campaign_id', ['data-live-search'=>true]);
	    echo $this->Form->input('partner_id', ['type'=>'hidden','value'=> $admn['User']['partner_id']]);
	    echo $this->Form->input('email_template_id', ['type'=>'hidden','value'=>0]);
	    echo $this->Form->input('partner_campaign_id', ['type'=>'hidden','value'=>0]);
	    echo $this->Form->input('from_name',['label'=>"'From' name"]);
	    echo $this->Form->input('from_email',['type'=>'email','label'=>"'From' email address","value"=>$admn['User']['email']]);
	    echo $this->Form->input('reply_to_email',['type'=>'email','label'=>"'Reply to' email address (if different)"]);
	    //echo $this->Form->input('start_date', [
		  //    'label' => 'Start Date',
		  //    'minYear' => date('Y')-2,
		  //    'maxYear' => date('Y')+2,
		  //    'type'=> 'date', 'class' =>'col-xs-4'
		  //  ]);
			// echo $this->Form->input('start_date', [
			//		'label' => 'Start Date',
			//		'type'=> 'text',
			//		'id'=> 'datepicker'
			//		]);
	   ?>
	   <span id="subject_line"></span>
			<?php
			  if($partnerCampaignEmailSetting->status != 'sent') {
			?>
	  
		<div class="row checkbox_group">
		
			<label class="col-md-4 col-xs-6 control-label">
				<?= __('Schedule this email for a future date')?>
			</label>
			
		    <div class="col-md-2 col-xs-6">
				<div class="onoffswitch">
						<?= $this->Form->checkbox('sntlater' ,['checked'=>'checked', 'class'=>'onoffswitch-checkbox', 'id'=>'sntlater', 'data-toggle'=>'collapse', 'data-target'=>'#scheduletime']) ?>
					<label class="onoffswitch-label" for="sntlater">
						<span class="onoffswitch-inner"></span>
						<span class="onoffswitch-switch"></span>
					</label>
				</div>
			</div>
			
		</div>
	  
	  <div id="scheduletime" class="collapse in">
	  	<?php // echo $this->Form->input('sent_date', ['label' => '','interval'=>15,'type'=> 'datetime']); ?>
	  	<?php echo $this->CustomForm->datetime('sent_date',$partnerCampaignEmailSetting->sent_date,'Send date'); ?>
	  </div>
	  
	  <div class="row checkbox_group">
		
			<label class="col-md-4 col-xs-6 control-label">
				<?= __('Auto-tweet campaign')?>
			</label>
			
		    <div class="col-md-2 col-xs-6">
			<?php if($twitter_isauth) { ?>
				<div class="onoffswitch">
					<?= $this->Form->checkbox('post_tweet' ,['class'=>'onoffswitch-checkbox','value'=>'1' , 'id'=>'auto-tweet', 'checked'=>true, 'disabled'=>$twitter_isauth?false:true]) ?>
					<label class="onoffswitch-label" for="auto-tweet">
						<span class="onoffswitch-inner"></span>
						<span class="onoffswitch-switch"></span>
					</label>
				</div>
			<?php } else { ?>
				<?=$this->Form->hidden('post_tweet', ['value' => '0'])?>
				<?=$this->HTML->link(__('Connect Twitter'), ['controller' => 'SocialApps', 'action' => 'twitterInitialize'], ['class'=>'btn btn-sm'])?>
			<?php } ?>
			</div>
			
		</div>
		
	  <div id="tweetbox" class="row">
	  	<div class="col-md-12"><?php echo $this->Form->input('tweet_text', ['type'=>'textarea']); ?></div>
	  	<div class="col-md-9">Merge Tag: <span title="Copy this in your text box"><b>[*!EMAILURL!*]</b></span> <span class="text-muted"><small>This will be replaced with the url of the online version of the email</small></span></div>
		<div id='tweet_text_counter' class="col-md-3 text-right">140 characters remaining</div>
	  </div>
	  
	  <div class="row checkbox_group">
		
			<label class="col-md-4 col-xs-6 control-label">
				<?= __('Auto-post to Facebook')?>
			</label>
			
		     <div class="col-md-2 col-xs-6">
			<?php if($facebook_isauth) { ?>
				<div class="onoffswitch">
					<?= $this->Form->checkbox('post_facebook' ,['class'=>'onoffswitch-checkbox','value'=>'1' , 'id'=>'post-facebook', 'checked'=>true, 'disabled'=>$facebook_isauth?false:true]) ?>
					<label class="onoffswitch-label" for="post-facebook">
						<span class="onoffswitch-inner"></span>
						<span class="onoffswitch-switch"></span>
					</label>
				</div>
			<?php } else { ?>
				<?=$this->Form->hidden('post_facebook', ['value' => '0'])?>
				<?=$this->HTML->link(__('Connect Facebook'), ['controller' => 'SocialApps', 'action' => 'facebookInitialize'], ['class'=>'btn btn-sm'])?>
			<?php } ?>
			</div>
			
		</div>
		
	  <div id="facebookbox" class="row">
	  	<div class="col-md-12"><?php echo $this->Form->input('facebook_text', ['type'=>'textarea']); ?></div>
	  	<div class="col-md-9">Merge Tag: <span title="Copy this in your text box"><b>[*!EMAILURL!*]</b></span> <span class="text-muted"><small>This will be replaced with the url of the online version of the email</small></span></div>
		<!--<div id='facebook_text_counter' class="col-md-3 text-right">140 characters remaining</div>-->
	
		<div class="clearfix">&nbsp;</div>
		<label class="col-md-4 col-xs-6 control-label">
			<?= __('Post to your Facebook personal page')?>
		</label>
		<div class="col-md-8 col-xs-6">
		<?=$this->Form->input('facebook_personal', ['type'=>'checkbox','value'=>'1','label'=>'Personal Profile','hiddenField' => false]);?>
		</div>
		
		<?php
			$countFbPage = array();
			foreach($facebook_pages as $cnt) {
				foreach($cnt as $count){
					if($count->id){
						array_push($countFbPage, $cnt);
					}
				}
			}
			$cntFbPages = count($countFbPage);
		?>
	  	<label class="col-md-4 col-xs-6 control-label">
				<?= __(($cntFbPages>0?'Post to your ':'').'Facebook pages ('.$cntFbPages.')')?>
		</label>
		<?php if($facebook_pages): ?>
		<div class="col-md-4 col-xs-6">
		<?php
			foreach($facebook_pages as $pages){
				foreach($pages as $page) {
					if($page->id) {
						echo $this->Form->input('facebook_pages[]', ['type'=>'checkbox','value'=>$page->id.':'.$page->access_token,'label'=>$page->name,'hiddenField' => false]);
					}
				}
			}
		?>
		</div>
		<?php endif; ?>
	
  </div>
	  
	  <div class="row checkbox_group">
		
			<label class="col-md-4 col-xs-6 control-label">
				<?= __('Auto-post to LinkedIn')?>
			</label>
			
		    <div class="col-md-2 col-xs-6">
		    <?php if($linkedin_isauth): ?>
				<div class="onoffswitch">
					<?= $this->Form->checkbox('post_linkedin' ,['class'=>'onoffswitch-checkbox','value'=>'1' , 'id'=>'post-linkedin', 'checked'=>true, 'disabled'=>$linkedin_isauth?false:true]) ?>
					<label class="onoffswitch-label" for="post-linkedin">
						<span class="onoffswitch-inner"></span>
						<span class="onoffswitch-switch"></span>
					</label>
				</div>
			<?php else: ?>
				<?=$this->Form->hidden('post_linkedin', ['value' => '0'])?>
				<?=$this->HTML->link(__('Connect Linkedin'), ['controller' => 'SocialApps', 'action' => 'linkedinInitialize'], ['class'=>'btn btn-sm'])?>
			<?php endif; ?>
			</div>
			
		</div>
		
	  <div id="linkedinbox" class="row">
	  	<div class="col-md-12"><?php echo $this->Form->input('linkedin_text', ['type'=>'textarea']); ?></div>
	  	<div class="col-md-9">Merge Tag: <span title="Copy this in your text box"><b>[*!EMAILURL!*]</b></span> <span class="text-muted"><small>This will be replaced with the url of the online version of the email</small></span></div>
		<div id='linkedin_text_counter' class="col-md-3 text-right">140 characters remaining</div>
		<div class="clearfix">&nbsp;</div>
	  	<label class="col-md-4 col-xs-6 control-label">
				<?= __('Post to your Linkedin personal page')?>
		</label>
		<div class="col-md-8 col-xs-6">
			<?=$this->Form->input('linkedin_personal', ['type'=>'checkbox','value'=>'1','label'=>'Personal Profile','hiddenField' => false]);?>
		</div>
	  	<?php if($linkedin_companies): ?>
	  	<label class="col-md-4 col-xs-6 control-label">
				<?= __(($linkedin_companies->_total>0?'Post to your ':'').'Linkedin company pages ('.$linkedin_companies->_total.')')?>
		</label>
		<div class="col-md-8 col-xs-6">
		<?php
			foreach($linkedin_companies->values as $company){
				echo $this->Form->input('linkedin_companies[]', ['type'=>'checkbox','value'=>$company->id,'label'=>$company->name,'hiddenField' => false]);
			}
		?>
		</div>
		<?php endif; ?>
	  </div>
		  
	  <?php
		  } else {
		    echo '<pre class="success"><i class="fa fa-check"></i>'.__('This email was sent on ').date('d/m/Y H:i', strtotime($partnerCampaignEmailSetting->sent_date)).'</pre>';
			}
		?>
   
		<?php echo $this->Form->input('status',['type'=>'hidden']); ?>
		
		<div class="row preview-button">
		  <div class="col-md-12">
			  
      <?php
	      if($partnerCampaignEmailSetting->status != 'sent') {
      ?>
      
	      <span id="sentschedulebtn"><?= $this->Html->link(__('Schedule'), '#',['class'=> 'pull-right btn btn-lg btn-pad-left ','onclick'=>'schedule();']); ?></span>
				<?= $this->Html->link(__('Save as draft'), '#',['class' => 'btn btn-lg btn-cancel btn-pad-left pull-right','onclick'=>'savedraft();']); ?>
	      <?= $this->Html->link(__('Send test email'), '#',['class' => 'btn btn-lg btn-cancel btn-pad-left pull-right','onclick'=>'sendtestmail();']); ?>

			<?php
				} else {
			?>
			
				<?= $this->Html->link(__('View campaigns'), ['controller'=>'PartnerCampaigns','view'=>'mycampaignslist'],['class' => 'btn btn-lg btn-pad-left pull-right']); ?>
	
			<?php
				}
			?>
			
	      <span  data-toggle="modal" data-target="#EMpreviewModal" onclick="newajaxprvbrowsr();" id="prvbrwsr" class="btn btn-lg btn-cancel btn-pad-left pull-right button">Preview <i class="fa fa-search"></i></span>
	      <?= $this->Html->link(__('Cancel'), $last_visited_page,['class' => 'pull-left btn btn-lg btn-cancel']); ?>
	
			</div>
		</div>
		
	</div>

</fieldset>

<?= $this->Form->end(); ?>

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
				<!-- Dynamically populate this area with the email content, via the ID -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>