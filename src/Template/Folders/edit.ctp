<?php $authUser = $this->Session->read('Auth');?>

<div class="folders form col-centered col-lg-10 col-md-10 col-sm-10">

  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
    
	<?= $this->Form->create($folder); ?>
	
	<h2><?= __('Edit folder')?></h2>
	<div class="breadcrumbs">
		<?php
			$this->Html->addCrumb('Resources', ['controller'=>'Resources', 'action'=>'index']);
			$this->Html->addCrumb('Edit folder', ['controller' => 'Folders', 'action' => 'edit']);
			echo $this->Html->getCrumbs(' / ', [
			    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
			    'url' => ['controller' => 'Admins', 'action' => 'index'],
			    'escape' => false
			]);
		?>
	</div>
	
	<fieldset>
	
	<?php
		if(isset($parent_id))
			echo $this->Form->input('parent_id',['type'=>'hidden','value'=>$parent_id]);
		else
			echo $this->Form->input('parent_id',['options'=>$parentFolders,'label'=>'Source Folder','data-live-search' => true]);
		
		echo $this->Form->input('name',['label'=>'Folder Name']);
		echo $this->Form->input('description');
		echo $this->Form->input('status',['options'=> ['Y'=>'Active','B'=>'Blocked']]);
		echo $this->element('form-submit-bar'); 
    ?>
    
	</fieldset>
	
  <?= $this->Form->end(); ?>
  
</div>