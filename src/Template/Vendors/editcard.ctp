<?php 
$this->layout = 'admin--ui';
?>



<!-- Card -->

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">

        <div class="card--header">

          <div class="row">
            <div class="col-xs-12 col-md-6">
              <div class="card--icon">
                <div class="bubble">
                  <i class="icon ion-card"></i></div>
                </div>
                <div class="card--info">
                  <h2 class="card--title"><?= __('Billing Address'); ?></h2>
                  <h3 class="card--subtitle"></h3>
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <div class="card--actions">
                </div>
              </div>
            </div>   
          </div>


          <div class="card-content">
<!--
<div class="row">
<div class="col-md-12">
<h4>Campaign Options</h4>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
</p>
<hr>
</div>
</div>
-->
<!-- content below this line -->
<div class="editcard form">

  <?php echo $this->Form->create($ver,['class'=>'validatedForm']) ?>


  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

  <fieldset>


    <!-- form input content -->
    <div class="row input--field">
      <div class="col-md-3">
        <label>First Name</label>
      </div>
      <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('firstName', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control', 'value' => $vendor['u']['first_name'])); ?>
      </div>

    </div>
    <!-- form input content -->
    <!-- form input content -->
    <div class="row input--field">
      <div class="col-md-3">
        <label>Last Name</label>
      </div>
      <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('lastName', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control', 'value' => $vendor['u']['last_name'])); ?>
      </div>

    </div>
    <!-- form input content -->
    <!-- form input content -->
    <div class="row input--field">
      <div class="col-md-3">
        <label>Company</label>
      </div>
      <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('company', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control', 'value' => $vendor['company_name'])); ?>
      </div>

    </div>
    <!-- form input content -->
    <!-- form input content -->
    <div class="row input--field">
      <div class="col-md-3">
        <label>Address</label>
      </div>
      <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('company', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control', 'value' => $vendor['address'])); ?>
      </div>

    </div>
    <!-- form input content -->
    <!-- form input content -->
    <div class="row input--field">
      <div class="col-md-3">
        <label>City</label>
      </div>
      <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('city', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control', 'value' => $vendor['city'])); ?>
      </div>

    </div>
    <!-- form input content -->
    <!-- form input content -->
    <div class="row input--field">
      <div class="col-md-3">
        <label>State</label>
      </div>
      <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('state', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control', 'value' => $vendor['state'])); ?>
      </div>

    </div>
    <!-- form input content -->
    <!-- form input content -->
    <div class="row input--field">
      <div class="col-md-3">
        <label>Postcode</label>
      </div>
      <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('zip', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control', 'value' => $vendor['postalcode'])); ?>
      </div>

    </div>
    <!-- form input content -->
    <!-- form input content -->
    <div class="row input--field">
      <div class="col-md-3">
        <label>Country</label>
      </div>
      <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('country', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control', 'options' => $vendor['country_list'],'type'=>'select','data-live-search' => true,'value'=>$vendor['country'])); ?>
      </div>

    </div>
    <!-- form input content -->

  </fieldset>


  <div class="row">
    <div class="col-md-12">
      <h4><?= __('Card Details'); ?></h4>
      <hr>
    </div>
  </div>


  <fieldset>


    <?php
    echo $this->Form->hidden('subscriptionId',['value' => $subscriptionid]);
    echo $this->Form->hidden('customerProfileId',['value' => $customerProfileId]);
    echo $this->Form->hidden('customerPaymentProfileId',['value' => $customerPaymentProfileId]);
    ?>

    <!-- form input content -->
    <div class="row input--field">
      <div class="col-md-3">
        <label>Card Number</label>
      </div>
      <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('cardNumber', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control', 'length'=>16)); ?>
      </div>

    </div>
    <!-- form input content -->

    <!-- form input content -->
    <div class="row input--field">
      <div class="col-md-3">
        <label>Expiry Date</label>
      </div>
      <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('expirationDate', array(
          'div'=>false, 'label'=>false, 'class' => 'form-control', 'length'=>16,
          'minYear' => date('Y'),
          'maxYear' => date('Y')+10,
          'day' => false,
          'type'=> 'date',
          'monthNames'=>['01' => '01', '02' => '02','03' => '03','04' => '04','05' => '05','06' => '06','07' => '07','08' => '08','09' => '09','10' => '10','11' => '11','12' => '12',])); ?>
        </div>

      </div>
      <!-- form input content -->

      <!-- form input content -->
      <div class="row input--field">
        <div class="col-md-3">
          <label>CVV2  <a class="popup" data-toggle="popover" data-content="<?= __("For Mastercard or Visa, it's the last three digits in the signature area on the back of your card. For American Express, it's the four digits on the front of the card");?>">
            <i class="fa fa-info-circle"></i>
          </a>
        </label>
      </div>
      <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('cardCode', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
      </div>

    </div>
    <!-- form input content -->


  </fieldset>

  <?php echo $this->Form->end() ?>

</div>
<!-- content below this line -->
</div>
<div class="card-footer">
  <div class="row">
    <div class="col-md-6">
      <!-- breadcrumb -->
      <ol class="breadcrumb">
        <li>               

        </li>
      </ol>
    </div>
    <div class="col-md-6 text-right">
      <?= $this->Html->link(__('Cancel'), $last_visited_page,['class' => 'btn btn-default btn-cancel']); ?>         
      <?= $this->Form->button(__('Submit'),['class'=> 'btn btn-primary']); ?>
    </div>
  </div>
</div>
</div>
</div>
</div>
</div>
<!-- /Card -->

