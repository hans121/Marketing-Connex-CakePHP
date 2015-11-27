<!--  Load ScrollReveal only on pages required, as clashes with some Bootstrap.js functions -->

<?php //echo $this->Html->script('scrollReveal.js-master/scrollReveal.js');?>
<?//= $this->fetch('script');?>



<div id="content" class="section-white-fade">
	<div class="container">
		
			<div class="row container-header">
				<div class="col-md-12">
<!--<div class="unsubscribedContacts form col-centered col-lg-10 col-md-10 col-sm-10">-->
	
  	<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
  
	<?= $this->Form->create($unsubscribedContact); ?>
	
  	<h1 class="text-center"><?= __('Unsubscribe')?></h1>
  	<h2 class="text-center"><?= __("We are sorry to see you go.")?></h2>
			</div>
			</div>
  	
  	<?php if (isset($this->request->query['md_id'])) {
	  	$md_email = $this->request->query['md_email']; ?>
  	
  		 	  
  	<div class="row">
	  	<div class="col-md-12">
  	
  	<p class="text-center"><?= __("If you're sure you wish to unsubscribe, please use the submit button below to confirm.")?></p>
    <p class="text-center"><i class="fa fa-envelope fa-lg text-center cyan" style="font-size: 30px;"></i>&nbsp; Unsubscribe <?= $md_email;?> from all future emails?</p>
	  	</div>
  	</div>
		
    <fieldset class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
	    
    	<?php
        //echo $this->Form->hidden('partner_id', ['value' => $pid]);
        //echo $this->Form->hidden('email', ['value' => $md_email]);
    		//echo $this->Form->input('email');
        echo $this->element('form-submit-bar');
      ?>
    </fieldset>
  
  <?= $this->Form->end(); ?>
  
  <?php }
	  else { ?>
		  <p class="text-center"><?= __("If you wish to unsubscribe from emails from Marketing Connex, please follow the unsubscribe link in an email from us.")?></p>
		  <p class="text-center"><?= __("Alternatively, you can contact customer support.")?></p> 

	 <?php } ?>
  
</div>
</div>