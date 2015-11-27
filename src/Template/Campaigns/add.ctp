<?php echo $this->Html->script('dropzone'); //include dropzone plugin ?>
<style>
.connexForm {margin: 10px auto; padding: 20px 10px 0 10px; border: 2px dashed #FAEBCC; text-align:center; cursor: pointer; background: #FCF8E3;color: #8A6D3B;}	
</style>
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
								<div class="bubble"><i class="icon ion-compose"></i></div>
							</div>
							<div class="card--info">
								<h2 class="card--title"><?= __('Add Campaign')?></h2>
								<h3 class="card--subtitle">New Campaign Setup</h3>
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


<?php // marks up radio buttons in the right way for styling: http://book.cakephp.org/3.0/en/views/helpers/form.html#list-of-templates
$this->Form->templates([
	'nestingLabel' => '{{input}}<label{{attrs}}>{{text}}</label>',
	'radioWrapper' => '{{input}}{{label}}',
	]);
	?>

	<script type="text/javascript">
	$(document).ready(function(){
		$('#financialquarter-id').change(function() {
			var dataString = 'qtid='+$(this).val()+'&cal=0';
			$.ajax ({
				type: "POST",
				url: "<?php echo $this->Url->build([ "controller" => "Campaigns","action" => "getBalanceAllowance"],true);?>",
				data: dataString,
				cache: false,
				success: function(html)
				{
$('#ajaxallowance').html(html); // If you need to change html style on the related html element refer to Template Campaigns/get_balance_allowance.ctp
}
});
		});

		$('#campaign-type').change(function() {
			var other_cont = $('#campaign_type_other');
			var other = $('#campaign-type-other');
			if(this.value=='other') {
				other_cont.show();
				other.prop('disabled',false);
			}
			else {
				other.prop('disabled',true);
				other_cont.hide();
			}
		});

		if($.inArray($('#campaign-type').val(),['e-mail','Royal Mail','leaflet'])>-1)
			$('#campaign_type_other').hide();
		else
			$('#campaign-type-other').val('<?=$campaign->campaign_type?>');
	});
	</script>


	<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

	<?= $this->Form->create($campaign,['class'=>'validatedForm','type'=>'file','id'=>'my-dropzone']); ?>
	<?php
	$auth = $this->Session->read('Auth');
	echo $this->Form->hidden('vendor_id', ['value' => $auth['User']['vendor_id']]);
	echo $this->Form->hidden('campaign_type', ['value' =>'e-mail']);

	?>
	<!-- form input content -->
	<div class="row input--field">
		<div class="col-md-3">
			<label for="exampleInput">Name</label>
		</div>
		<div class="col-md-6" id="input--field">
			<?php echo $this->Form->input('name', array(
			'div'=>false, 'label'=>false, 'placeholder' => 'campaign name', 'class' => 'form-control required')); ?>
		</div>

	</div>
	<!-- form input content -->
	<!-- form input content -->
	<div class="row input--field">
		<div class="col-md-3">
			<label for="exampleInput">Financial Quarter</label>
		</div>
		<div class="col-md-9" id="input--field">
			<?php echo $this->Form->input('financialquarter_id', array(
			'div'=>false, 'label'=>false, 'value'=>$currentquarter->id,'options' => $financialquarters,'data-live-search' => true,'class'=>'required')); ?>
		</div>
	</div>
	<!-- form input content -->
	<!-- form input content -->
	<div class="row input--field">
		<div class="col-md-3">
			<label for="exampleInput">Target Market</label>
		</div>
		<div class="col-md-6" id="input--field">
			<?php echo $this->Form->input('target_market', array(
			'div'=>false, 'label'=>false, 'placeholder' => 'market', 'class' => 'form-control')); ?>
		</div>

	</div>
	<!-- form input content -->
	<!-- form input content -->
	<div class="row input--field">
		<div class="col-md-3">
			<label for="exampleInput">Average Deal Value</label>
		</div>
		<div class="col-md-6" id="input--field">
			<?php echo $this->Form->input('sales_value', array(
			'div'=>false, 'label'=>false, 'placeholder' => 'enter value', 'class' => 'form-control required')); ?>
		</div>

	</div>
	<!-- form input content -->
	<!-- form input content -->
	<div id="ajaxallowance"><?php //echo $this->element('campaign-ajax-sent');?></div>

	<!-- form input content -->
	<div class="row">
		<div class="col-md-12">
			<h4>Campaign Options</h4>

			<hr>
		</div>
	</div>



	<?php echo $this->element('checkbox-switches-campaign-modules');?>

	<div class="row">
		<div class="col-md-12">
			<h4>Campaign Resources</h4>
			<p>Upload relevant content here for your Partners to use with this campaign. Sales Guides / Case Studies / Product Datasheets, anything you feel will help them sell the product / solution range effectively.
			</p>

		</div>
	</div>
	

	<?php 
// elements are found on the Element folder in Template
// echo $this->element('campaign-resource-page'); // you may have to check this element for styling too



	echo $this->Form->hidden('status',['value' =>'Y']);
	?>
	<div class="row myDropZoneContainer" style="display:none">
		<div class="col-md-1">&nbsp;</div>
		<div class="col-md-10 connexForm" id="connex">
			<span class="dz-message " ><strong>Drop file here or click to upload.</strong></span>

			<div class="table table-striped" id="previews">

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
						<center>
							<button type="button" class="btn btn-primary start">
								<i class="fa fa-cloud-upload"></i>
								<span>Upload</span>
							</button>
							<button type="button" class="btn btn-warning cancel" data-dz-remove>
								<i class="fa fa-close"></i>
								<span>Cancel</span>
							</button>
						</center>
					</div>
				</div><!--template-->

			</div><!--previews-->

		</div>
		<div class="col-md-1">&nbsp;</div>
	</div>



</fieldset>
<!-- content below this line -->
</div>
<div class="card-footer">
	<div class="row">
		<div class="col-md-6">
			<!-- breadcrumb -->
			<ol class="breadcrumb">
				<li>               
					<?php
					$this->Html->addCrumb('Campaigns', ['controller' => 'Campaigns', 'action' => 'index']);
					$this->Html->addCrumb('add', ['controller' => 'Campaigns', 'action' => 'add']);
					echo $this->Html->getCrumbs(' / ', [
						'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
						'url' => ['controller' => 'Vendors', 'action' => 'index'],
						'escape' => false
						]);
						?>
					</li>
				</ol>
			</div>
			<div class="col-md-6 text-right">
		<?= $this->Html->link(__('Cancel'), $last_visited_page,['class' => 'btn btn-default btn-cancel']); ?>					

				<?= $this->Form->button(__('Save'),['class'=> 'btn btn-primary']); ?>
			</div>
		</div>
	</div>

</div>
</div>
</div>
</div>
<!-- /Card -->
<script>
$(function () {
	$("[name='uploadResource']").bootstrapSwitch();
	$('input[name="uploadResource"]').on('switchChange.bootstrapSwitch', function(event, state) {
		if(state){
			$(".myDropZoneContainer").show();
			activateDropzone();
		}else{
			$(".myDropZoneContainer").hide();
		}

	});
	$(".required").on("keypress keyup change", function () {
		var show_flag = true;
		$('.required').each( function(i) {
			if ($(this).val() == "") {
				show_flag = false;

			}else{
				show_flag = true;
			} 
		});
		if (show_flag){
			$(".myDropZoneContainer").show();
			activateDropzone();
		} else {
			$(".myDropZoneContainer").hide();

		}
	});
});
Dropzone.autoDiscover = false;

function activateDropzone(){
	var previewNode = document.querySelector("#template");
	previewNode.id = "";
	var previewTemplate = previewNode.parentNode.innerHTML;
	previewNode.parentNode.removeChild(previewNode);

	var myDropzone = new Dropzone("#my-dropzone",{
		paramName: 'resource',
		thumbnailWidth: 80,
		thumbnailHeight: 80,
		parallelUploads: 20,
		uploadMultiple: false,
		previewTemplate: previewTemplate,
		autoQueue: false, // Make sure the files aren't queued until manually added
		previewsContainer: "#previews",
		//maxFiles: 1,



	});

	myDropzone.on("addedfile", function(file) {
		// Hookup the start button
		//myDropzone.processQueue(file);
		file.previewElement.querySelector(".start").onclick = function() { myDropzone.processFile(file); };
		file.previewElement.querySelector(".cancel").onclick = function() { myDropzone.removeAllFiles(true); };

	});

	// Update the total progress bar
	myDropzone.on("uploadprogress", function(file,progress) {
		console.log(progress);
		document.querySelector(".progress .progress-bar").style.width = progress + "%";
		document.querySelector('.percent').innerHTML =progress;

	});

	myDropzone.on("sending", function(file,xhr,formData) {
	//console.log(file);
	});
	// Hide the total progress bar when nothing's uploading anymore
	myDropzone.on("queuecomplete", function(progress) {



	});
	myDropzone.on('success',function(file, responseText){

		file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
		file.previewElement.querySelector(".cancel").setAttribute("disabled", "disabled");
	
		if(responseText=='success'){
			file.previewElement.querySelector(".myIndicator").setAttribute("class", "text-success");
			file.previewElement.querySelector(".uploaded").innerHTML='has been uploaded.';
		window.location.href="<?php echo $this->Url->build([ "controller" => "Campaigns","action" => "index", $grp_id],true);?>";
		}else {
		
		}
		//$('#my-dropzone').submit();

		});

}



</script>
