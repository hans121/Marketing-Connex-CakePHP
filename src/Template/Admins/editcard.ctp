<div class="editcard form col-centered col-lg-10 col-md-10 col-sm-10">
<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
<?php echo $this->Form->create($ver,['class'=>'validatedForm']) ?>
	<h2><?= __('Cardholder\'s name & address')?></h2>
	<div class="breadcrumbs">
		<?php
			$this->Html->addCrumb('Vendors', ['controller'=>'Admins','action' => 'vendors']);
			$this->Html->addCrumb('Edit payment card', ['controller'=>'Admins','action' => 'editcard', $vendor->id]);
			echo $this->Html->getCrumbs(' / ', [
			    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
			    'url' => ['controller' => 'Admins', 'action' => 'index'],
			    'escape' => false
			]);
		?>
	</div>
	
	<fieldset>
		<?php
		  echo $this->Form->input('firstName',['value' => $vendor['u']['first_name'],'label' => 'First Name(s)']);
		  echo $this->Form->input('lastName',['value' => $vendor['u']['last_name'],'label' => 'Last Name']);
		  echo $this->Form->input('company',['value' => $vendor['company_name'],'label' => 'Company Name']);
		  echo $this->Form->input('address',['value' => $vendor['address'],'label' => 'Address']);
		  echo $this->Form->input('city',['value' => $vendor['city'],'label' => 'City']);
		  echo $this->Form->input('state',['value' => $vendor['state'],'label' => 'State / County']);
		  echo $this->Form->input('zip',['value' => $vendor['postalcode'],'label' => 'Zip / Post Code']);
		  echo $this->Form->input('country', ['options' => $vendor['country_list'],'type'=>'select','data-live-search' => true,'value'=>$vendor['country']]);
		?>
	</fieldset>
   
	<h2><?= __('Card Details')?></h2>
  <fieldset>
		<?php
			echo $this->Form->hidden('subscriptionId',['value' => $subscriptionid]);
			echo $this->Form->hidden('customerProfileId',['value' => $customerProfileId]);
			echo $this->Form->hidden('customerPaymentProfileId',['value' => $customerPaymentProfileId]);
			echo $this->Form->input('cardNumber',['length'=>16]);
		?>
		<div class="inline-twothirds">
		<?php
			echo $this->Form->input('expirationDate', [
				'label' => 'Expiry Date',
				'minYear' => date('Y'),
				'maxYear' => date('Y')+10,
				'day' => false,
				'labale'=> 'Expiry Date',
				'type'=> 'date',
				'monthNames'=>['01' => '01', '02' => '02','03' => '03','04' => '04','05' => '05','06' => '06','07' => '07','08' => '08','09' => '09','10' => '10','11' => '11','12' => '12',]
			]);
		?>
		</div>
		<div class="inline-onethird">
		<?php
	    echo $this->Form->input('cardCode');
	  ?>
			<?= __('<a class="popup" data-toggle="popover" data-content="For Mastercard or Visa, it\'s the last three digits in the signature area on the back of your card. For American Express, it\'s the four digits on the front of the card"><i class="fa fa-info-circle"></i> What\'s this?</a>')?>
		</div>
    </fieldset>
    
<?php echo $this->Form->button(__('Update Payment Details'),['class'=> 'btn btn-lg']); ?>

<?php echo $this->Form->end() ?>

</div>
