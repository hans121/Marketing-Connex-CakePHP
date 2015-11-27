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
                  <h2 class="card--title"><?= __('Add Page')?></h2>
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



<?php $authUser = $this->Session->read('Auth');?>

<div class="resources form">

  <?= $this->Form->create($page,['controller'=>'VendorResources','action'=>'add/'.$menuid]); ?>



  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

  <fieldset>

    <?php
    if(isset($menuid)) { ?>
    <? echo $this->Form->input('menu_id', ['type'=>'hidden','value' => $menuid]);?>
    <?php } else { ?>
    <? echo $this->Form->input('menu_id', ['label'=>'Choose a menu location for this page','options' => $menus,'data-live-search' => true,]);?>
    <?php } ?>

    <!-- form input content -->
    <div class="row input--field">
      <div class="col-md-3">
        <label>Title</label>
      </div>
      <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('title', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
      </div>

    </div>
    <!-- form input content -->

    <!-- form input content -->
    <div class="row">

      <div class="col-md-12">
        <?php echo $this->Form->input('content', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control', 'id'=>'wysiwyg')); ?>
      </div>

    </div>
    <!-- form input content -->
    <!-- form input content -->
    <div class="row input--field">
      <div class="col-md-3">
        <label>Publish Status</label>
      </div>
      <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('status', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control', 'options'=> ['Y'=>'Published','N'=>'Private'])); ?>
      </div>

    </div>
    <!-- form input content -->






  </fieldset>


</div>
<script>
// Replace the <textarea id="editor1"> with a CKEditor
// instance, using default configuration.
CKEDITOR.replace( 'wysiwyg' );
</script>

<!-- content below this line -->
</div>
<div class="card-footer">
  <div class="row">
    <div class="col-md-6">
      <!-- breadcrumb -->
      <ol class="breadcrumb">
        <li>               
          <?php
          $this->Html->addCrumb('Communications', ['action'=>'index']);
          $this->Html->addCrumb('add', ['action' => 'add', $menuid]);
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

