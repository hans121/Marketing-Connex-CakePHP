<?php $authUser = $this->Session->read('Auth');?>

<div class="folders form col-centered col-lg-10 col-md-10 col-sm-10">

	<?= $this->Form->create($folder); ?>
	
	<h2><?= __('Edit folder')?></h2>
	<div class="breadcrumbs">
		<?php
			$this->Html->addCrumb('Resources', ['controller'=>'VendorResources', 'action'=>'index']);
			$this->Html->addCrumb('edit folder', ['controller' => 'VendorFolders', 'action' => 'edit', $folder->id]);
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
			echo $this->Form->input('parent_id',['type'=>'hidden','value'=>$parent_id]);
		else
			echo $this->Form->input('parent_id',['options'=>$parentFolders,'label'=>'Source Folder','data-live-search' => true]);
		
		echo $this->Form->input('name',['label'=>'Folder Name']);
		echo $this->Form->input('description');
		echo $this->Form->input('status',['options'=> ['Y'=>'Active','B'=>'Blocked']]);
		echo $this->Form->input('groups',['options'=> $groups, 'label'=>'Assign to Group/s', 'multiple'=>true, 'value'=>$assigned_groups]);
		echo $this->element('form-submit-bar'); 
    ?>
    
	</fieldset>
	
  <?= $this->Form->end(); ?>
  
</div>