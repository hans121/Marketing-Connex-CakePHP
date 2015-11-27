<?php $authUser = $this->Session->read('Auth');?>

<div class="resources form col-centered col-lg-10 col-md-10 col-sm-10">

	<?= $this->Form->create($resource, ['type' => 'file']) ?>
	
	<h2><?= __('Edit Resource')?></h2>
	<div class="breadcrumbs">
		<?php
			$this->Html->addCrumb('Resources', '/resources');
			$this->Html->addCrumb('Edit resource', ['controller' => 'Resources', 'action' => 'edit']);
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
		echo $this->Form->input('name');
		echo $this->Form->input('description');
	?>
		<label for="description">
			<?php $max_file_size	= $this->CustomForm->fileUploadLimit(); ?>
			<?= __('Select a file to replace current file').' '; ?> 
			<a class="popup" data-toggle="popover" data-content="<?= __('The maximum file upload size is {0}. Supported file types are jpg, jpeg, gif, & png',[($max_file_size)]);?>">
				<i class="fa fa-info-circle"></i>
			</a>
		</label>
		<div class="row inner withtop">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="">
					<div class="fileinput fileinput-new" data-provides="fileinput">
					  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
						<?php
							if(stristr($resource->type, 'image')):
						?>
							<img src="<?=$resource->publicurl?>" />
						<?php
							else:
						?>
							No Preview Available
						<?php
							endif;
						?>

					  </div>
					  <div>
					    <span class="btn btn-default btn-file">
					    	<span class="fileinput-new">Select file</span>
					    	<span class="fileinput-exists">Change</span>
					    	<?php echo $this->Form->input('sourcepath',['type'=>'file']);?>
					    </span>
					    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
					  </div>
					</div>
				</div>
			</div>
		</div>	

  <?php  
    echo $this->element('form-submit-bar'); 
  ?>

	</fieldset>
	
	<?= $this->Form->end() ?>

</div>
