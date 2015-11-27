<div class="countries form col-centered col-lg-10 col-md-10 col-sm-10">
  
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
  
  <?= $this->Form->create($country,['class'=>'validatedForm']); ?>
	<h2><?= __('Add Country')?></h2>
	
  <fieldset>
    
    <?php
      echo $this->Form->input('iso_alpha_code_2',['type'=>'text']);	
      echo $this->Form->input('iso_alpha_code_3');
  		echo $this->Form->input('title');
  		echo $this->Form->input('iso_numeric');
			echo $this->element('form-submit-bar');
  	?>
  	
  </fieldset>
  
  <?= $this->Form->end(); ?>
  
</div>