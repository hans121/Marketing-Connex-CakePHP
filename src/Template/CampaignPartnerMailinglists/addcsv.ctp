<?php
	echo $this->Html->script('dropzone'); //include dropzone plugin
?>
<div class="campaignPartnerMailinglists index">
			
	<div class="row table-title partner-table-title">
	
		<div class="partner-sub-menu clearfix">
		
			<div class="col-md-6 col-sm-4">
				<h2><?= __('Mailing List')?></h2>
				<div class="breadcrumbs">
					<?php
						$this->Html->addCrumb('Email Management', ['controller' => 'PartnerCampaignEmailSettings', 'action' => 'index']);
						$this->Html->addCrumb('Mailing List', ['controller' => 'CampaignPartnerMailinglists', 'action' => 'index',$partnerCampaignEmailSetting->campaign->id]);
						$this->Html->addCrumb('import', ['controller' => 'CampaignPartnerMailinglists', 'action' => 'addcsv']);
						echo $this->Html->getCrumbs(' / ', [
						    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
						    'url' => ['controller' => 'Partners', 'action' => 'index'],
						    'escape' => false
						]);
					?>
				</div>
			</div>
			
			<div class="col-md-6 col-sm-8">
				
				<div class="btn-group pull-right hidden-xs">
					<?= $this->Html->link($this->Html->tag('span',__('',true),['class' => 'fa fa-cloud-download']).' '.__('CSV Template'), ['action' => 'gettemplate'],['title' => 'Download CSV template', 'escape' => false, 'class'=>'btn btn-lg pull-right']) ?>	
				</div>
				
			</div>
		
		</div>
		
	</div> <!--row-table-title-->
	
	<div class="col-centered col-lg-10 col-md-10 col-sm-10">
				
		<div class="row table-title">
		
			<div class="alert-wrap">
			<div class="alert alert-warning alert-dismissible" role="alert">
			  	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			    <h4><i class="fa fa-exclamation-triangle"></i> <?= __('Warning')?></h4>
			    <p><?= __("You must ensure that the people that you upload details for have each given permission to be 'opted in' to your mailing list, and that you have evidence of this on file.")?></p>
			</div>
			</div>
					
		</div> <!-- /.row.table-title -->
	
	</div>

	<div class="form col-centered col-lg-10 col-md-10 col-sm-10">
		<h3><?= __('Import email contact list')?></h3>	
		<div class="row table-thd">	
			<div class="col-lg-4 col-md-4 col-sm-4">
				<?= __('Select CSV file'); ?>
							<?php $csvmsg   =   __("Please download our CSV template to be sure your data is arranged in the correct format. After editing, save it as a 'Windows comma separated (.csv)' file to ensure compatibility.");?>
				<?= '<a class="popup" data-toggle="popover" data-content="'.$csvmsg.'"><i class="fa fa-info-circle"></i></a>';?>
			</div>		
		</div>
	  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	   
	   <?= $this->Form->create('',['type'=>'file','class'=>'connexForm','id'=>'my-dropzone']); ?>
	
		<?php
			$auth =   $this->Session->read('Auth');
			echo $this->Form->hidden('partner_id',['value'=>$auth['User']['partner_id']]);
			echo $this->Form->hidden('vendor_id',['value'=>$auth['User']['vendor_id']]);
			echo $this->Form->hidden('campaign_id',['value'=>$campaign->id]);
			echo $this->Form->input('partner_campaign_email_setting_id',['type'=>'hidden','value'=>$partnerCampaignEmailSetting->id]);
			echo $this->Form->input('partner_campaign_id',['type'=>'hidden','value'=>$pcmp_id]);
				
			echo $this->Form->input('subscribe',['type'=>'hidden','value'=>'Y']);
			echo $this->Form->input('status',['type'=>'hidden','value'=>'Y']);
	    ?>
	   
	   
		<span class="dz-message"><strong>Drop file here or click to upload.</strong></span>
		<div class="table table-striped" class="files" id="previews">

			<div id="template" class="file-row">
				<!-- This is used as the file preview template -->
				<div>
					<span class="preview"><img data-dz-thumbnail /></span>
				</div>
				<div>
					<p class="myIndicator"><span class="name" data-dz-name></span> (<small class="size" data-dz-size></small>) <span class="uploaded"></span></p>
					<strong class="text-danger" data-dz-errormessage></strong>
				</div>
				<div>
					
					<div class="progress spamchecker">
						<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%" id="progressbar" data-dz-uploadprogress>
							
							<span class="percent">0</span>%
						</div>
					</div>
				</div>
				<div>
					<button type="button" class="btn btn-primary start">
						<i class="fa fa-cloud-upload"></i>
						<span>Upload</span>
					</button>
					<button data-dz-remove class="btn btn-warning cancel">
						<i class="glyphicon glyphicon-ban-circle"></i>
						<span>Cancel</span>
					</button>

				</div>
			</div>

		</div>

		
	  <?= $this->Form->end(); ?>
	  
	</div>
	
</div> <!-- /#content -->
<script>
	Dropzone.autoDiscover = false;
	$(function(){
		var previewNode = document.querySelector("#template");
		previewNode.id = "";
		var previewTemplate = previewNode.parentNode.innerHTML;
		previewNode.parentNode.removeChild(previewNode);

		
		var myDropzone = new Dropzone("#my-dropzone",{
			paramName: 'importcsv',
			thumbnailWidth: 80,
			thumbnailHeight: 80,
			parallelUploads: 20,
			uploadMultiple: false,
			previewTemplate: previewTemplate,
			autoQueue: false, // Make sure the files aren't queued until manually added
			previewsContainer: "#previews",
			maxFiles: 1,
			acceptedFiles: "text/csv,text/x-csv,application/vnd.ms-excel,'text/x-comma-separated-values'",
			
		});
		
		myDropzone.on("addedfile", function(file) {
			// Hookup the start button
			myDropzone.processQueue(file);
			file.previewElement.querySelector(".start").onclick = function() { myDropzone.processFile(file); };
			
		});

		// Update the total progress bar
		myDropzone.on("totaluploadprogress", function(progress) {
			
			document.querySelector(".progress .progress-bar").style.width = progress + "%";
			document.querySelector('.percent').innerHTML =progress;
		});

		myDropzone.on("sending", function(file,xhr,formData) {
			
		});
		// Hide the total progress bar when nothing's uploading anymore
		myDropzone.on("queuecomplete", function(progress) {
			
			
			
		});
		myDropzone.on('success',function(file, responseText){
			
			file.previewElement.querySelector(".cancel").setAttribute("disabled", "disabled");
			file.previewElement.querySelector(".progress").style.display = "none";
				alert(responseText);
			if(responseText){
				file.previewElement.querySelector(".myIndicator").setAttribute("class", "text-success");
				file.previewElement.querySelector(".uploaded").innerHTML='has been uploaded!';
				
				window.location.href="<?php echo $this->Url->build([ "controller" => "CampaignPartnerMailinglists","action" => "successdropcsv", $campaign->id],true);?>";
			}else {
				window.location.href="<?php echo $this->Url->build([ "controller" => "CampaignPartnerMailinglists","action" => "errordropcsv", $campaign->id],true);?>";
			}
			
		});
		
	
	});

</script>