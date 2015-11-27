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
                  <h2 class="card--title"><?= __('New Manager')?></h2>
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



<div class="partnerManagers form">
  
  <?php echo $this->Form->create($user,['class'=>'validatedForm']) ?>


      
    <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
  
    <fieldset>

   
          <!-- form input content -->
    <div class="row input--field">
      <div class="col-md-3">
        <label>Title</label>
      </div>
      <div class="col-md-6" id="input--field">
              <?php 
    $titoptions=array('Mr'=>'Mr','Ms'=>'Ms','Mrs'=>'Mrs','Miss'=>'Miss','Dr'=>'Dr'); ?>
        <?php echo $this->Form->input('title', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control', 'options'=>$titoptions)); ?>
      </div>

    </div>
    <!-- form input content -->
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
        <label>Job Title</label>
      </div>
      <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('job_title', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
      </div>

    </div>
    <!-- form input content -->
                      <!-- form input content -->
    <div class="row input--field">
      <div class="col-md-3">
        <label>Number</label>
      </div>
      <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('phone', array(
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
        <label>Password</label>
      </div>
      <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('password', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
      </div>

    </div>
    <!-- form input content -->
                                  <!-- form input content -->
    <div class="row input--field">
      <div class="col-md-3">
        <label>Confirm Password</label>
      </div>
      <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('conf_password', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control', 'type' => 'password')); ?>
      </div>

    </div>
    <!-- form input content -->      
     
      <?php
        echo $this->Form->hidden('status',['value' =>'Y']);
        echo $this->Form->hidden('role',['value' =>'partner']);
        echo $this->Form->hidden('partner_manager.partner_id',['value'=>$partner_id]);
        echo $this->Form->hidden('partner_manager.primary_contact',['value' => 'N']);
      ?>
  
    </fieldset>
  
    
</div>


<!-- content below this line -->
</div>
<div class="card-footer">
  <div class="row">
    <div class="col-md-6">
      <!-- breadcrumb -->
      <ol class="breadcrumb">
        <li>               
      <?php
        $this->Html->addCrumb('Managers', ['controller' => 'PartnerManagers', 'action' => 'index']);
        $this->Html->addCrumb('add', ['controller' => 'PartnerManagers', 'action' => 'add']);
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
