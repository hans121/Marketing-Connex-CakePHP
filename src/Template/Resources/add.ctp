<?php $authUser = $this->Session->read('Auth');?>

<div class="resources form col-centered col-lg-10 col-md-10 col-sm-10">
	
	<?= $this->Form->create($resource,['type'=>'file','controller'=>'Resources','action'=>'add/'.$parent_id]); ?>
	
	<h2><?= __('Add Resource')?></h2>
	<div class="breadcrumbs">
		<?php
			$this->Html->addCrumb('Resources', '/resources');
			$this->Html->addCrumb('Add resource', ['controller' => 'Resources', 'action' => 'add']);
			echo $this->Html->getCrumbs(' / ', [
			    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
			    'url' => ['controller' => 'Admins', 'action' => 'index'],
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
      
      
    <!-- Jasny Bootstrap input[type='file'] styling -->  
		<label for="description">
			<?php $max_file_size	= $this->CustomForm->fileUploadLimit(); ?>
			<?= __('Select a file to upload').' '; ?> 
			<a class="popup" data-toggle="popover" data-content="<?= __('The maximum file upload size is {0}. Supported file types are jpg, jpeg, gif, & png',[($max_file_size)]);?>">
				<i class="fa fa-info-circle"></i>
			</a>
		</label>
		<div class="row inner withtop">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
			</div>
		</div>
		
		
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
    ?>
      
      
    <!-- Our previous input[type='file'] styling 
		<div class="row table-th">
			<div class="col-lg-4 col-md-4 col-sm-4">
				<?= __('Select a file for upload'); 
				$max_file_size	= $this->CustomForm->fileUploadLimit();
				$allowed = array('image/jpeg', 'image/png', 'image/gif', 'image/JPG', 'image/jpg', 'image/pjpeg');?>
				<?= __('<a class="popup" data-toggle="popover" data-content="The maximum file upload size is {0}. Supported file types are jpg, jpeg, gif, & png only',[($max_file_size)] )?>
				<?= __('"><i class="fa fa-info-circle"></i></a>')?>
			</div>		
		</div>
		
		<div class="row inner">
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

			</div>
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
				<span class="file-wrapper ">
			    <?php echo $this->Form->input('sourcepath',['type' =>'file','id' =>'sourcepath', 'label'=>FALSE]); ?>
				<span class="btn pull-right button ">Change</span>
				</span>
			</div>	
		</div>
    -->  
      
      
    <?php  
      echo $this->element('form-submit-bar'); 
    ?>
    
	</fieldset>
	
  <?= $this->Form->end(); ?>
  
</div>