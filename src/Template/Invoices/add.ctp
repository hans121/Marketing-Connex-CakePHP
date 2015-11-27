<?php // echo $this->Html->script('tinymce/tinymce.min.js');?>

<script type="text/javascript">
tinymce.init({
    selector: "textarea"
 });
</script>

<div class="invoices form col-centered col-lg-10 col-md-10 col-sm-10">
	
    <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
    
		<?= $this->Form->create($invoice,['class'=>'validatedForm']); ?>

		<h2><?= __('Add Invoice')?></h2>
		<div class="breadcrumbs">
			<?php
				$this->Html->addCrumb('Vendors', ['controller'=>'Admins','action' => 'vendors']);
				$this->Html->addCrumb('Invoices', ['controller'=>'Invoices','action' => 'index']);
				$this->Html->addCrumb('Add', ['controller'=>'Invoices','action' => 'add']);
				echo $this->Html->getCrumbs(' / ', [
				    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
				    'url' => ['controller' => 'Admins', 'action' => 'index'],
				    'escape' => false
				]);
			?>
		</div>
						
		<fieldset>

		<?php
			echo $this->Form->input('vendor_id', ['options' => $vendors,'data-live-search' => true]);
			echo $this->Form->input('invoice_number');
			echo $this->CustomForm->date('invoice_date',date(),'Invoice Date');
			/*
			echo $this->Form->input('invoice_date', [
			'label' => 'Invoice Date',
			'type'=> 'text',
			'id'=> 'datepicker'
			]);*/
	    echo $this->Form->input('title');
			echo $this->Form->input('description');
			echo $this->Form->input('comments');
			//echo $this->Form->input('invoice_date',['maxYear' => date('Y')+10, 'type'=> 'date']);
			echo $this->Form->input('currency');
			echo $this->Form->input('amount');
			echo $this->Form->input('status',['options'=>['paid'=>'Paid','pending'=>'Pending','cancelled'=>'Cancelled'],]);
			echo $this->element('form-submit-bar');
		?>
	
  </fieldset>
  
  <?= $this->Form->end(); ?>
  
</div>