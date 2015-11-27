<?php $authUser = $this->Session->read('Auth');?>

<div class="folders form col-centered col-lg-10 col-md-10 col-sm-10">

  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
    
	<?= $this->Form->create($menu); ?>
	
	<h2><?= __('Add menu')?></h2>
	<div class="breadcrumbs">
		<?php
			$this->Html->addCrumb('Help Pages', ['controller'=>'HelpPages', 'action'=>'index']);
			$this->Html->addCrumb('Add menu', ['controller' => 'HelpMenus', 'action' => 'add',$parent_id]);
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
			echo $this->Form->input('parent_id',['options'=>$menus,'label'=>'Parent Menu','data-live-search' => true]);

		echo $this->Form->input('name',['label'=>'Menu name']);
		echo $this->Form->input('description');
		echo $this->Form->input('status',['options'=> ['Y'=>'Published','N'=>'Private'], 'label'=>'Publish Status']);
		echo $this->element('form-submit-bar'); 
    ?>
	</fieldset>
	
  <?= $this->Form->end(); ?>
  
</div>