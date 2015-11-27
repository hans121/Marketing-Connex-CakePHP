<?php echo $this->Html->script('tinymce/tinymce.min.js');?>
<script type="text/javascript">
tinymce.init({
    selector: "textarea"
 });
</script>

<div class="masterTemplates form col-centered col-lg-10 col-md-10 col-sm-10">
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
  
	<?= $this->Form->create($masterTemplate,['class'=>'validatedForm']); ?>

	<h2><?= __('Add Master Template')?></h2>
	
  <fieldset>

		<?php
			echo $this->Form->input('title');
			echo $this->Form->input('content');
		   /*
		    * Section for landing page variable...
		    */
		  echo __('For Landing page templates use the following variables inside your template to replace with the values from vendor');
		  echo '[*!BANNERIMAGE!*]
		  
		  [*!BANNERTEXT!*]
		  
		  [*!VENDORLOGO!*]
		  
		  [*!PARTNERLOGO!*]
		
			[*!HEADING!*]
			
			[*!BODYTEXT!*]
			
			[*!FRMHEADING!*]
			
			[*!FRMFIELDS!*]
			
			[*!EXTERNALMENU!*]
			
			[*!FOOTERTEXT!*]';
			
		?>
			
			<br />
			<br />
			
		<?php
			
		  /*
		   * Section for email variables....
		   */
		  
		  echo __('For Email templates use the following variables inside your template to replace with the values from vendor');
		  echo '[*!BANNERIMAGE!*]
		  
		  [*!BANNERTEXT!*]
		  
		  [*!VENDORLOGO!*]
		  
		  [*!PARTNERLOGO!*]
		
			[*!HEADING!*]
			
			[*!BODYTEXT!*]
			
			[*!FEATUREHEADING!*]
			
			[*!FEATURES!*]
			
			[*!SUBJECT!*]
			
			[*!CTAIMAGE!*]
			
			[*!CTATEXT!*] AND the mailchimp variables *|EMAIL|*, *|FNAME|*, *|LNAME|*';
									
			echo $this->Form->input('template_type',['options'=>['email'=>'E-mail','landing_page'=>'Landing Page']]);
			echo $this->Form->input('status',['options'=>['Y'=>'Active',]]);
			echo $this->element('form-submit-bar');
		?>
	
  </fieldset>
  
  <?= $this->Form->end(); ?>
    
</div>