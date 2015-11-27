<?php echo $this->Html->script('dropzone'); //include dropzone plugin ?>
<?php $authUser = $this->Session->read('Auth');?>

<div class="resources form col-centered col-lg-10 col-md-10 col-sm-10">
	
	<?= //$this->Form->create($resource,['id'=>'myDropzone','type'=>'file','controller'=>'VendorResources','action'=>'add/'.$parent_id]);
	$this->Form->create($resource,['id'=>'myDropzone','type'=>'file','controller'=>'VendorResources','action'=>'add/'.$parent_id]);
	?>
	
	<h2><?= __('Add Resource')?></h2>
	<div class="breadcrumbs">
		<?php
			$this->Html->addCrumb('Resources', ['controller'=>'VendorResources', 'action'=>'index']);
			$this->Html->addCrumb('add', ['controller' => 'VendorResources', 'action' => 'add', $parentfolder->id]);
			echo $this->Html->getCrumbs(' / ', [
			    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
			    'url' => ['controller' => 'Vendors', 'action' => 'index'],
			    'escape' => false
			]);
		?>
	</div>
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
    
	<fieldset>
	
	<?php
	  if(isset($parent_id))
	  	echo $this->Form->input('folder_id', ['type'=>'hidden','value' => $parent_id]);
	  else
    	echo $this->Form->input('folder_id', ['label'=>'Choose a folder location for this resource','options' => $folders,'data-live-search' => true,]);
      echo $this->Form->input('user_id', ['type' => 'hidden','value'=>$parentfolder->user_id]);
      echo $this->Form->input('user_role',['type' => 'hidden','value'=>$parentfolder->user_role]);
      echo $this->Form->input('vendor_id', ['type' => 'hidden','value' => $parentfolder->vendor_id]);
      echo $this->Form->input('name',['label'=>'Title']);
      echo $this->Form->input('description', ['label'=>'Description']);
      echo $this->Form->input('status',['type'=> 'hidden','value'=>'Y']);
      // echo $this->Form->input('sourcepath',['type'=>'file']);
    ?>
      <script> // Grab the filename and extract the file type from this
		
			$('#sourcepath').change(function() {
	        var filename = $('#sourcepath').val();
	        
	        var a = filename.split(".");
					if( a.length === 1 || ( a[0] === "" && a.length === 2 ) ) {
					    return "";
					}
					filetype = a.pop();
	        
					var elem = document.getElementById("select_file");
					elem.value = filetype;
	    });
			
		</script>
		
		<?php
      echo $this->Form->input('type',['type'=> 'text','id'=>'select_file','disabled'=>'disabled']);
      echo $this->Form->input('groups',['options'=> $groups, 'label'=>'Assign to Group/s', 'multiple'=>true, 'value'=>$assigned_groups]);
    ?>
      
    <!-- Jasny Bootstrap input[type='file'] styling -->  
		<label for="description">
			<?php $max_file_size	= $this->CustomForm->fileUploadLimit(); ?>
			<?= __('Drag file or click add file to upload').' '; ?> 
			<a class="popup" data-toggle="popover" data-content="<?= __('The maximum file upload size is {0}. Supported file types are jpg, jpeg, gif, & png',[($max_file_size)]);?>">
				<i class="fa fa-info-circle"></i>
			</a>
		</label>
		<div id="dropzoneArea" class="row inner withtop">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<?php /*
				<div class="">
					<div class="fileinput fileinput-new" data-provides="fileinput">
					  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
					  <div>
					    <span class="btn btn-default btn-file">
					    	<span class="fileinput-new">Select file</span>
					    	<span class="fileinput-exists">Change</span>
					    	<?php echo $this->Form->input('sourcepath',['type'=>'file', 'id'=>'sourcepath']);?>
					    </span>
					    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
					  </div>
					</div>
				</div> 
				*/?>
				<div id="actions" class="row">

				  <div class="col-lg-7">
					<!-- The fileinput-button span is used to style the file input field as button -->
					<span class="btn btn-success fileinput-button">
						<i class="glyphicon glyphicon-plus"></i>
						<span>Add file...</span>
					</span>
					<button type="submit" class="btn btn-primary start">
						<i class="glyphicon glyphicon-upload"></i>
						<span>Start upload</span>
					</button>
					<button type="reset" class="btn btn-warning cancel">
						<i class="glyphicon glyphicon-ban-circle"></i>
						<span>Clear</span>
					</button>
				  </div>

				  <div class="col-lg-5">
					<!-- The global file processing state -->
					<span class="fileupload-process">
					  <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
						<div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
					  </div>
					</span>
				  </div>

				</div>
				<div  class="table table-striped" id="previews">

				  <div id="template" class="file-row">
					<!-- This is used as the file preview template -->
					<div>
						<span class="preview"><img data-dz-thumbnail /></span>
					</div>
					<div>
						<p class="name" data-dz-name></p>
						<strong class="error text-danger" data-dz-errormessage></strong>
					</div>
					<div>
						<p class="size" data-dz-size></p>
						<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
						  <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
						</div>
					</div>
					<div>
					
					  <button class="btn btn-primary start">
						  <i class="glyphicon glyphicon-upload"></i>
						  <span>Start</span>
					  </button>
					  <button data-dz-remove class="btn btn-warning cancel">
						  <i class="glyphicon glyphicon-trash"></i>
						  <span>Delete</span>
					  </button>
					 
					</div>
				  </div>

				</div>
			</div>
		</div>
		
		
		
      
      
      
    <?php  
     // echo $this->element('form-submit-bar'); 
    ?>
    
	</fieldset>
	
  <?= $this->Form->end(); ?>
  
</div>
<style>
    /* Mimic table appearance */
    div.table {
      display: table;
    }
    div.table .file-row {
      display: table-row;
    }
    div.table .file-row > div {
      display: table-cell;
      vertical-align: top;
      border-top: 1px solid #ddd;
      padding: 8px;
    }
    div.table .file-row:nth-child(odd) {
      background: #f9f9f9;
    }



    /* The total progress gets shown by event listeners */
    #total-progress {
      opacity: 0;
      transition: opacity 0.3s linear;
    }

    /* Hide the progress bar when finished */
    #previews .file-row.dz-success .progress {
      opacity: 0;
      transition: opacity 0.3s linear;
    }

    /* Hide the delete button initially */
    #previews .file-row .delete {
      display: none;
    }

    /* Hide the start and cancel buttons and show the delete button */

    #previews .file-row.dz-success .start,
    #previews .file-row.dz-success .cancel {
      display: none;
    }
    #previews .file-row.dz-success .delete {
      display: block;
    }


</style>
<script>
	$("#myDropzone").submit(function(e){
		return false;
	});
	Dropzone.autoDiscover = false;
	var previewNode = document.querySelector("#template");
	previewNode.id = "";
	var previewTemplate = previewNode.parentNode.innerHTML;
	previewNode.parentNode.removeChild(previewNode);
	
	var myDropzone = new Dropzone("#myDropzone", { 
		//url: "<?php echo $this->Url->build([ "controller" => "VendorResources","action" => "add",$parent_id],true);?>", // Set the url
		paramName: 'sourcepath',
		thumbnailWidth: 80,
		thumbnailHeight: 80,
		parallelUploads: 20,
		previewTemplate: previewTemplate,
		autoQueue: false, // Make sure the files aren't queued until manually added
		previewsContainer: "#previews", // Define the container to display the previews
		clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
		maxFiles: 1,
		acceptedFiles: "image/*"
	});
	
	myDropzone.on("addedfile", function(file) {
	  // Hookup the start button
	  file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
	  $('#select_file').val(file.type);
	});

	// Update the total progress bar
	myDropzone.on("totaluploadprogress", function(progress) {
	  document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
	});

	myDropzone.on("sending", function(file) {
	  // Show the total progress bar when upload starts
	  document.querySelector("#total-progress").style.opacity = "1";
	  // And disable the start button
	  file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
	});

	// Hide the total progress bar when nothing's uploading anymore
	myDropzone.on("queuecomplete", function(progress) {
	  document.querySelector("#total-progress").style.opacity = "0";
	});

	myDropzone.on("success", function(file,responseText) {
		//alert(file);
		//obj = JSON.parse(responseText);
		//alert(responseText);
		if(responseText == "success"){
			window.location.href="<?php echo $this->Url->build([ "controller" => "VendorResources","action" => "navigate", $parent_id],true);?>";
		}
		
		

	});
	// Setup the buttons for all transfers
	// The "add files" button doesn't need to be setup because the config
	// `clickable` has already been specified.
	document.querySelector("#actions .start").onclick = function() {
	  myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
	};
	document.querySelector("#actions .cancel").onclick = function() {
	  myDropzone.removeAllFiles(true);
	};
</script>








