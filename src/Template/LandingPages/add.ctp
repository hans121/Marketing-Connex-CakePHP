<?php echo $this->Html->script('tinymce/tinymce.min.js');?>

<script>
  $(document).ready(function(){
    $("#ajaxpreviewimg").sticky({topSpacing:0});
    $('#modal-close1').click(function() {
	    $('#previewbrowser').html('');
	  });
	  $('#modal-close2').click(function() {
	    $('#previewbrowser').html('');
	  });
  });
</script>

<script>
	function newajaxprvbrowsr(){
             var formData = new FormData($('#frmemailtmplt')[0]);

            $.ajax({
                url: "<?php echo $this->Url->build([ "controller" => "LandingPages","action" => "ajaxpreviewbrowser"],true);?>",
                type: "POST",
                data: formData,
                async: false,
                success: function (msg) {
                     $('#previewbrowser').html(msg);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
        function ajaxpreviewload(poston){
	    var dataString = 'mtemplate_id='+$('#master-template-id').val()+'&poston='+poston;
	      $.ajax ({
	      type: "POST",
	      url: "<?php echo $this->Url->build([ "controller" => "LandingPages","action" => "ajaxpreviewimage"],true);?>",
	      data: dataString,
	      cache: false,
	      success: function(html)
	      {
	        $('#ajaxpreviewimg').html(html);
	      }
	    });
	}
	 $(document).ready(function()
    {
      $('#use_templates').change(function() {
          $('#toggle-width').toggleClass( 'col-sm-12' );
          $('#toggle-width').toggleClass( 'col-sm-7' );
          $('#ajaxpreviewimg').fadeToggle( "slow", "linear" );
      });
      $('#master-template-id').change(function() {
          ajaxpreviewload(0);
      });
      $('.hover-area1').hover(function() {
          ajaxpreviewload(1);
      });
      $('.hover-area2').hover(function() {
          ajaxpreviewload(2);
      });
      $('.hover-area3').hover(function() {
          ajaxpreviewload(3);
      });
      $('.hover-area4').hover(function() {
          ajaxpreviewload(4);
      });
      $('.hover-area5').hover(function() {
          ajaxpreviewload(5);
      });
    });
</script>

<div class="landingPages form col-centered col-lg-10 col-md-10 col-sm-10">

  <?php
	  echo $this->Flash->render(); echo $this->Flash->render('auth');
	?>
    
	<?= $this->Form->create($landingPage,['class'=>'validatedForm form-with-preview','type'=>'file','id'=>'frmemailtmplt']); ?>
	
	<fieldset>
	
		<div class="row checkbox_group">
			<div class="col-md-9">
				<h2>
					<?= __('Manage landing page') ?>
				</h2>
				<div class="breadcrumbs">
					<?php
						$this->Html->addCrumb('Campaigns', ['controller' => 'Campaigns', 'action' => 'index']);
						$this->Html->addCrumb('Manage landing page', ['controller' => 'Campaigns', 'action' => 'view', $campaign->id]);
						$this->Html->addCrumb('add', ['controller' => 'LandingPages', 'action' => 'add', $campaign->id]);
						echo $this->Html->getCrumbs(' / ', [
						    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
						    'url' => ['controller' => 'Vendors', 'action' => 'index'],
						    'escape' => false
						]);
					?>
				</div>
			</div>
		</div>
		
		<div class="row form-inner">
			
			<div class="col-lg-3 col-md-3 col-sm-5 hidden-xs pull-right show-area">
				<div id="ajaxpreviewimg">
		      <?php echo $this->element('landingpage-mastertemplate-ajax-previewimg'); ?>
				</div>
			</div>
			
			<div id="toggle-width" class="col-lg-9 col-md-9 col-sm-7 col-xs-12 pull-left">
			
				<?php
					echo $this->Form->input('vendor_id', ['type' => 'hidden','value'=>$vid]);
					echo $this->Form->input('campaign_id', ['type' => 'hidden','value'=>$cmp_id]);
					echo $this->Form->input('master_template_id', ['options' => $masterTemplates,'label'=>'Choose base template']);
					echo '<div class="badge badge-blue badge-large">'.__('1').'</div>';
				?>
				
				<div class="hover-area1">
				
		    <!-- Jasny Bootstrap input[type='file'] styling -->  
				<label for="description">
					<?= __('Banner background image').' '; ?>
					<?php 
						$max_file_size	= $this->CustomForm->fileUploadLimit();
						$allowed = array('image/jpeg', 'image/png', 'image/gif', 'image/JPG', 'image/jpg', 'image/pjpeg');?>
						<a class="popup" data-toggle="popover" data-content="<?= __('The maximum file upload size is').' '.$max_file_size.__('. Supported file types are jpg, jpeg, gif, & png only');?>">
						<i class="fa fa-info-circle"></i></a>
				</label>
				<div class="row inner withtop">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="">
							<div class="fileinput fileinput-new" data-provides="fileinput">
							  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
							    <?php if(trim($landingPage->banner_bg_image) != ''){ ?>	 
										<?php  echo $this->Html->image('landingpages/bgimages/'.$landingPage->banner_bg_image,['class'=>'img-responsive'])?>
										<?= $this->Form->hidden('banner_bg_image_stored',['value'=>$landingPage->banner_bg_image]);?>
							    <?php } ?>
							  </div>
							  <div>
							    <span class="btn btn-default btn-file">
							    	<span class="fileinput-new">Select file</span>
							    	<span class="fileinput-exists">Change</span>
							    	<?= $this->Form->input('banner_bg_image',['type'=>'file','id' =>'banner_bg_image', 'label'=>FALSE]);?>
							    </span>
							    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
							  </div>
							</div>
						</div>
					</div>
				</div>
				
				<?php
					echo $this->Form->input('banner_text',['id'=>'wysiwyg1']);
				?>
				
				</div>
				
				<?php
					echo '<div class="badge badge-blue badge-large">'.__('2').'</div>';
				?>
		
				<div class="hover-area2">
					<?php	
						echo $this->Form->input('heading');
						echo $this->Form->input('body_text',['id'=>'wysiwyg2']);
					?>
				</div>
			
				<div class="hover-area3">
					<?php
						echo '<div class="badge badge-blue badge-large">'.__('3').'</div>';
						echo $this->Form->input('form_heading');
					?>
						<p>Choose form fields</p>
					<?php
						echo $this->element('checkbox-switches-landing-form-fields');
					?>
					
  		    <!-- Jasny Bootstrap input[type='file'] styling -->  
  				<label for="description">
  					<?= __('Downloadable item'); ?>
  					<?php 
  						$max_file_size	= $this->CustomForm->fileUploadLimit();
  				  ?>
  						<a class="popup" data-toggle="popover" data-content="<?= __('The maximum file upload size is').' '.$max_file_size ?>">
    						<i class="fa fa-info-circle"></i>
  						</a>
  				</label>
  				<div class="row inner withtop">
  					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  						<div class="">
      					<div class="fileinput fileinput-new" data-provides="fileinput">
      					  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
      					    <?php if(trim($landingPage->downloadable_item)){ ?>	 
      								<?php  echo $this->Html->image('../files/landingpages/'.$landingPage->downloadable_item,['class'=>'img-responsive'])?>
      					    <?php } ?>
      					  </div>
      					  <div>
      					    <span class="btn btn-default btn-file">
      					    	<span class="fileinput-new"><?= __("Select file");?></span>
      					    	<span class="fileinput-exists"><?= __("Change");?></span>
      					    	<?= $this->Form->input('downloadable_item',['type'=>'file','id' =>'downloadable_item', 'label'=>FALSE]);?>
      					    </span>
      					    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
      					  </div>
      					</div>
  						</div>
  					</div>
  				</div>
					
			    <div id="collapseFormSubmit">
						<div class="row checkbox_group">
					       <label class="col-md-10 col-xs-6 control-label"><?=__('Form submission required to receive downloadable item?')?>
					       </label>
						    <div class="col-md-2 col-xs-6">
						    	<div class="onoffswitch"><?=$this->Form->checkbox('chk_frm_submission' ,['value'=>'Y', 'checked'=>($landingPage->chk_frm_submission=='Y' ? true : false), 'class'=>'onoffswitch-checkbox', 'id'=>'chk_frm_submission', 'name'=>'chk_frm_submission' ])?>
						    		<label class="onoffswitch-label" for="chk_frm_submission">
										<span class="onoffswitch-inner"></span>
										<span class="onoffswitch-switch"></span>
									</label>
								</div>
							</div>
						</div>
					</div>

					<script>
					$("#downloadable_item").change(function (event) {
						if(this.value)
							$('#collapseFormSubmit').collapse('show');
						else
							$('#collapseFormSubmit').collapse('hide');
					});
					</script>

				</div>
				
				<div class="hover-area4">
					<?php
					echo '<div class="badge badge-blue badge-large">'.__('4').'</div>';
					echo $this->element('external-url-landing-page');
					?>
				</div>
				
				<div class="hover-area5">
					<?php
						echo '<div class="badge badge-blue badge-large">'.__('5').'</div>';
						echo $this->Form->input('footer_text',['id'=>'wysiwyg3']);
					?>
				</div>
				
				<?php
					echo $this->element('form-submit-bar');
				?>

			</div>
		</div><!-- /.row -->
		
	</fieldset>
	<?= $this->Form->end(); ?>
  
</div>


<script type="text/javascript">
	 ajaxpreviewload(0);
 </script>
 
 <!-- Modal -->
<div class="modal fade" id="LMpreviewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id="modal-close1"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">E-mail preview</h4>
      </div>
      <div class="modal-body" id="previewbrowser">
				<!-- Dynamically populate this area with the email content, via the ID -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-close2">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
	// Replace the <textarea id="editor1"> with a CKEditor
	// instance, using default configuration.
	CKEDITOR.replace( 'wysiwyg1' );
	CKEDITOR.replace( 'wysiwyg2' );
	CKEDITOR.replace( 'wysiwyg3' );
</script>