<?php $authUser = $this->Session->read('Auth');?>

<div class="resources form col-centered col-lg-10 col-md-10 col-sm-10">
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
    
	<?= $this->Form->create($role); ?>
	
	<h2><?= __('Add User Role')?></h2>
	<div class="breadcrumbs">
		<?php
			$this->Html->addCrumb('Users', '/users');
			$this->Html->addCrumb('Admin Roles', '/admin_roles');
			$this->Html->addCrumb('add', ['action' => 'add']);
			echo $this->Html->getCrumbs(' / ', [
			    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
			    'url' => ['controller' => 'Admins'],
			    'escape' => false
			]);
		?>
	</div>
	
	<fieldset>
	
	<?php
      echo $this->Form->input('role', ['label'=>'Admin Role','options' => $roles,'data-live-search' => true,]);
      echo $this->Form->input('description',['label'=>'Description']);
      $prev_label = '';
      $rights_cnt = $rights->count();
      $rights_half = $rights_cnt/2;
      $cnt=0;
      echo '<div class="col-lg-6">';
      foreach($rights as $right) {
      	$cnt++;
      	if($right->controller_label!=$prev_label)
      	{
      		if($cnt>$rights_half)
      			echo '</div><div class="col-lg-6">';
      		$prev_label = $right->controller_label;
      		echo '<h4>'.$right->controller_label.'</h4>';
      	}
      	echo $this->Form->input('rights[]',['type'=>'checkbox','label'=>$right->action_label,'value'=>$right->id,'id '=>$right->id,'hiddenField' => false]);
      }
      echo '</div>';
    ?>
      
      
      
    <?php  
      echo $this->element('form-submit-bar'); 
    ?>
    
	</fieldset>
	
  <?= $this->Form->end(); ?>
  
</div>
