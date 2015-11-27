<?php 
$this->layout = 'admin--ui';
?>
<script>
function checkurl() {
  var originalvalue = document.getElementById('websitefield').value;
  var value = originalvalue.toLowerCase();
  if (value && value.substr(0, 7) !== 'http://' && value.substr(0, 8) !== 'https://') {
// then prefix with http://
document.getElementById('websitefield').value = 'http://' + value;
}               
}
</script>


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
                  <i class="icon ion-edit"></i></div>
                </div>
                <div class="card--info">
                  <h2 class="card--title"><?= __('Edit Company Profile'); ?></h2>
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



<div class="vendors--view form">
  <?= $this->Form->create($vendor,['type' => 'file','class'=>'validatedForm','onsubmit'=>'checkurl()']); ?>


  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

  <fieldset>

    <?php
    echo $this->Form->input('id');
    ?>  

    <!-- form input content -->
    <div class="row input--field">
      <div class="col-md-3">
        <label>Company Name</label>
      </div>
      <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('company_name', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
      </div>

    </div>
    <!-- form input content -->

    <!-- form input content -->
    <div class="row input--field">
      <div class="col-md-3">
        <label><?= __('Upload your logo').' '; ?>
          <?php 
          $max_file_size  = $this->CustomForm->fileUploadLimit();
          $allowed = array('image/jpeg', 'image/png', 'image/gif', 'image/JPG', 'image/jpg', 'image/pjpeg');?>
          <a class="popup" data-toggle="popover" data-content="<?= __('The maximum file upload size is').' '.($max_file_size).__('. Supported file types are jpg, jpeg, gif, & png only');?>">
            <i class="fa fa-info-circle"></i></a>
          </label>
        </div>
        <div class="col-md-6" id="input--field">
          <div class="">
            <div class="fileinput fileinput-new" data-provides="fileinput">
              <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                <?php if(trim($vendor->logo_url) != ''){ ?>  
                <?= $this->Html->image($vendor->logo_url,['class'=>'img-responsive'])?>
                <?php } ?>
              </div>
              <div>
                <span class="btn btn-default btn-file">
                  <span class="fileinput-new">Select file</span>
                  <span class="fileinput-exists">Change</span>
                  <?php echo $this->Form->input('logo_url',['type' =>'file','id' =>'logo_url', 'label'=>FALSE]); ?>
                </span>
                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
              </div>
            </div>
          </div>
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
          <label>Website</label>
        </div>
        <div class="col-md-6" id="input--field">
          <?php echo $this->Form->input('website', array(
          'div'=>false, 'label'=>false, 'class' => 'form-control', 'id'=>'websitefield')); ?>
        </div>

      </div>
      <!-- form input content -->

      <!-- form input content -->
      <div class="row input--field">
        <div class="col-md-3">
          <label>Address</label>
        </div>
        <div class="col-md-6" id="input--field">
          <?php echo $this->Form->input('address', array(
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
          <?php echo $this->Form->input('country-select-list', array(
          'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
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
          <label>State</label>
        </div>
        <div class="col-md-6" id="input--field">
          <?php echo $this->Form->input('state', array(
          'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
        </div>

      </div>
      <!-- form input content -->

      <!-- form input content -->
      <div class="row input--field">
        <div class="col-md-3">
          <label>Postcode</label>
        </div>
        <div class="col-md-6" id="input--field">
          <?php echo $this->Form->input('postalcode', array(
          'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
        </div>

      </div>
      <!-- form input content -->

      <!-- form input content -->
      <div class="row input--field">
        <div class="col-md-3">
          <label>Language</label>
        </div>
        <div class="col-md-6" id="input--field">
          <?php echo $this->Form->input('language', array(
          'div'=>false, 'label'=>false, 'class' => 'form-control', 'options' => ['en'=>'English'],'data-live-search' => true)); ?>
        </div>

      </div>
      <!-- form input content -->

      <!-- form input content -->
      <div class="row input--field">
        <div class="col-md-3">
          <label>Currency</label>
        </div>
        <div class="col-md-6" id="input--field">
          <?php echo $this->Form->input('currency', array(
          'div'=>false, 'label'=>false, 'class' => 'form-control' ,'options' => $currency_list,'data-live-search' => true)); ?>
        </div>

      </div>
      <!-- form input content -->




      <?php 
      $month_list =   ['01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December',];
      if(isset($vendor->financial_quarter_start_month)){
        $fqtrid =   $vendor->financial_quarter_start_month;
      }else{
        $fqtrid = '04';
      } ?>
      <!-- form input content -->
      <div class="row input--field">
        <div class="col-md-3">
          <label>Financial Quarter</label>
        </div>
        <div class="col-md-6" id="input--field">
          <?php echo $this->Form->input('financial_quarter_start_month', array(
          'div'=>false, 'label'=>false, 'class' => 'form-control' ,'options' => $month_list,'value'=>$fqtrid,'data-live-search' => true)); ?>
        </div>

      </div>
      <!-- form input content -->



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
          $this->Html->addCrumb('Company profile', ['controller' => 'vendors', 'action' => 'profile']);
          $this->Html->addCrumb('edit', ['controller' => 'vendors', 'action' => 'edit']);
          echo $this->Html->getCrumbs(' / ', [
            'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
            'url' => ['controller' => 'Vendors', 'action' => 'index'],
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

