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
                  <h2 class="card--title"><?= __('Manager'); ?></h2>
                  <h3 class="card--subtitle"></h3>
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <div class="card--actions">
                  <?= $this->Html->link(__('See all'), ['controller' => 'PartnerManagers', 'action' => 'index'], ['class' => 'btn btn-default']); ?>
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

<div class="partnerManagers view">

  
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

  <div class="row inner header-row ">
    <dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4"><?= h($partnerManager->user->title. ' '.$partnerManager->user->full_name); ?></dt>
    <dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $partnerManager->id],['class' => 'btn btn-default pull-right']); ?> 
    </dd>
  </div>

  <div class="row inner">   
      <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <?= __('Job Title'); ?>
      </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <?= h($partnerManager->user->job_title); ?>
    </dd>
  </div>
  <div class="row inner">   
      <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <?= __('Username'); ?>
      </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <?= h($partnerManager->user->username); ?>
    </dd>
  </div>
  <div class="row inner">   
      <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <?= __('E-mail'); ?>
      </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <?= h($partnerManager->user->email); ?>
    </dd>
  </div>
  <div class="row inner">   
      <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <?= __('Phone'); ?>
      </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <?= h($partnerManager->user->phone); ?>
    </dd>
  </div>
  <?php if (h($partnerManager->primary_contact) == 'Y') { ?>
  <div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('Primary Manager'); ?>
    </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <span class="fa fa-check"></span> 
    </dd>
  </div>
  <?php } ?>
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
          $this->Html->addCrumb('view', ['controller' => 'PartnerManagers', 'action' => 'view', $partnerManager->id]);
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
        <?= $this->Html->link(__('Back'), $last_visited_page,['class' => 'btn btn-primary btn-cancel']); ?>         

      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
<!-- /Card -->

