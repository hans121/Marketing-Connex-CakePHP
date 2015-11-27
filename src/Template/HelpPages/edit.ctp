<?php $authUser = $this->Session->read('Auth');?>

<div class="resources form col-centered col-lg-10 col-md-10 col-sm-10">
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
    
	<?= $this->Form->create($page); ?>
	
	<h2><?= __('Edit Page')?></h2>
	<div class="breadcrumbs">
		<?php
			$this->Html->addCrumb('Help Pages', ['action'=>'index']);
			$this->Html->addCrumb('edit', ['action' => 'edit', $menuid]);
			echo $this->Html->getCrumbs(' / ', [
			    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
			    'url' => ['controller' => 'Admins', 'action' => 'index'],
			    'escape' => false
			]);
		?>
	</div>
	
	<fieldset>
	
	<?php
	  if(isset($menuid))
	  	echo $this->Form->input('menu_id', ['type'=>'hidden','value' => $menuid]);
	  else
    	echo $this->Form->input('menu_id', ['label'=>'Choose a folder location for this resource','options' => $menus,'data-live-search' => true,]);
      echo $this->Form->input('title',['label'=>'Title']);
      echo $this->Form->input('content', ['label'=>'Content', 'id'=>'wysiwyg']);
      echo $this->Form->input('status',['options'=> ['Y'=>'Published','N'=>'Private'], 'label'=>'Publish Status']);
    ?>
      
      
      
    <?php  
      echo $this->element('form-submit-bar'); 
    ?>
    
	</fieldset>
	
  <?= $this->Form->end(); ?>
  
</div>
<script>
	// Replace the <textarea id="editor1"> with a CKEditor
	// instance, using default configuration.
	CKEDITOR.replace( 'wysiwyg' );
</script>