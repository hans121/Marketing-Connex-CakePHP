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
                  <i class="icon ion-plus"></i></div>
                </div>
                <div class="card--info">
                  <h2 class="card--title"><?= __('Add default mailing list contact')?></h2>
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

<div class="partnerMailinglists index">
      

  
<div class="partnerManagers form">
  
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
   
    <div class="row table-title">
    
      <div class="alert-wrap">
      <div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4><i class="fa fa-exclamation-triangle"></i> <?= __('Warning')?></h4>
          <p><?= __("You must ensure that the person you add has given permission to be 'opted in' to your mailing list, and that you have evidence of this on file.  * Setting 'opted out' to 'Yes' will unsubscribe the contact from all future mailings for all campaigns. Please note that it is not possible to override this and opt the contact back in again.")?></p>
      </div>
      </div>
    
    </div> <!-- /.row.table-title -->
   
  <?= $this->Form->create($partnerMailinglist,['class'=>'validatedForm']); ?>
    
  <fieldset>


        
    <?php
      $auth = $this->Session->read('Auth');
      echo $this->Form->hidden('partner_id',['value'=>$auth['User']['partner_id']]);
      echo $this->Form->hidden('vendor_id',['value'=>$auth['User']['vendor_id']]);
      echo $this->Form->hidden('status',['value'=>'Y']);
      echo $this->Form->hidden('partner_mailinglist_group_id',['value'=>$grp_id]);

    ?>    

        <!-- form input content -->
    <div class="row input--field">
      <div class="col-md-3">
        <label>First Name</label>
      </div>
      <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('first_name', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
      </div>

    </div>
    <!-- form input content -->
            <!-- form input content -->
    <div class="row input--field">
      <div class="col-md-3">
        <label>Last Name</label>
      </div>
      <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('last_name', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
      </div>

    </div>
    <!-- form input content -->
                <!-- form input content -->
    <div class="row input--field">
      <div class="col-md-3">
        <label>Email</label>
      </div>
      <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('email', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
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
        'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
      </div>

    </div>
    <!-- form input content -->
                        <!-- form input content -->
    <div class="row input--field">
      <div class="col-md-3">
        <label>Industry</label>
      </div>
      <div class="col-md-6" id="input--field">
         <?php 
    $industryOpt=array('Industry1'=>'Industry1','Industry2'=>'Industry2','Industry3'=>'Industry3','Industry4'=>'Industry4','Industry5'=>'Industry5','Industry6'=>'Industry6','Industry7'=>'Industry7','Industry8'=>'Industry8','Industry9'=>'Industry9','Industry10'=>'Industry10'); ?>
        <?php echo $this->Form->input('industry', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control', 'options'=>$industryOpt)); ?>
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
        'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
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
        'div'=>false, 'label'=>false, 'class' => 'form-control', 'options' => $country_list,'data-live-search' => true, 'empty' => 'Select a country')); ?>
      </div>

    </div>
    <!-- form input content -->

  </fieldset>
  
  
</div>


  
</div> <!-- /#content -->

<!-- content below this line -->
</div>
<div class="card-footer">
  <div class="row">
    <div class="col-md-6">
      <!-- breadcrumb -->
      <ol class="breadcrumb">
        <li>               
          <?php
            $this->Html->addCrumb('Mailing List', ['controller' => 'PartnerMailinglists', 'action' => 'index']);
            $this->Html->addCrumb('add contact', ['controller' => 'PartnerMailinglists', 'action' => 'add']);
            echo $this->Html->getCrumbs(' / ', [
                'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
                'url' => ['controller' => 'Partners', 'action' => 'index'],
                'escape' => false
            ]);
          ?>
          </li>
        </ol>
      </div>
      <div class="col-md-6 text-right">
        <?= $this->Html->link(__('Cancel'), $last_visited_page,['class' => 'btn btn-default btn-cancel']); ?>         
        <?= $this->Form->button(__('Submit'),['class'=> 'btn btn-primary']); ?>
        <?= $this->Form->end(); ?>

      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
<!-- /Card -->

