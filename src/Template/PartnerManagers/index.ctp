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
                  <h2 class="card--title"><?= __('Managers'); ?></h2>
                  <h3 class="card--subtitle"></h3>
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <div class="card--actions">
                  <?= $this->Html->link(__('Add new'), ['controller' => 'PartnerManagers', 'action' => 'add'], ['class' => 'btn btn-primary']); ?>
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



<?php 
$auth =   $this->Session->read('Auth');
$auth_vendor_primary   =   $auth['User']['primary_contact'];
?>
<div class="partnerManagers index">



  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

  <div class="row table-th hidden-xs">  
    <div class="clearfix"></div>  
    <div class="col-xs-3">
      <?= $this->Paginator->sort('user_id'); ?>
    </div>
    <div class="col-xs-2">
      <?= $this->Paginator->sort('created_on'); ?>
    </div>
    <div class="col-xs-1 text-center">
      <?= $this->Paginator->sort('primary_contact'); ?>
    </div>
    <div class="col-xs-6">
    </div>

  </div> <!--row-table-th-->

  <?php 
  $j =0;
  foreach ($partnerManagers as $partnerManager):
    $j++;
  ?>
  <!-- Start loop -->
  <div class="row inner hidden-xs">

    <div class="col-xs-3">
      <?= $partnerManager->user->full_name; ?>
    </div>

    <div class="col-xs-2">
      <?= h(date('d/m/Y',strtotime($partnerManager->created_on))); ?>
    </div>

    <div class="col-xs-1 text-center">
      <?php if (h($partnerManager->primary_contact) == 'Y') { ?>
      <span class="fa fa-check"></span> 
      <?php } ?>
    </div>

    <div class="col-xs-6">


      <div class="dropdown pull-right">
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          Manage
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
          <?php 
          if($auth_vendor_primary == 'Y'){?>

          <li><?= $this->Html->link(__('Edit'), ['action' => 'edit', $partnerManager->id]); ?>
            <li><?= $this->Html->link(__('View'), ['action' => 'view', $partnerManager->id]); ?>
              <?php 
              if($partnerManager->primary_contact != 'Y'){ ?>
              <li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $partnerManager->id], ['confirm' => __('Are you sure you want to delete?', $partnerManager->id)]); ?>
                <li><?= $this->Form->postLink(__('Make Primary'), ['action' => 'changePrimaryPmanager', $partnerManager->id], ['confirm' => __('Are you sure you want to change primary manager?', $partnerManager->id)]); ?>
                  <?php }
                } 
                ?>
              </ul>
            </div>

          </div>  

        </div> <!-- /.row -->

        <div class="row inner visible-xs">

          <div class="col-xs-12 text-center">

            <a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
              <h3><?= $partnerManager->user->full_name; ?></h3>
            </a>

          </div> <!--col-->

          <div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">
            <div class="row inner">

              <div class="col-xs-6">
                <?= __('Full Name')?>
              </div>

              <div class="col-xs-6">
                <?= $partnerManager->user->full_name; ?>
              </div>

            </div>

            <div class="row inner">

              <div class="col-xs-6">
                <?= __('Date Created')?>
              </div>

              <div class="col-xs-6">
                <?= h(date('d/m/Y',strtotime($partnerManager->created_on))); ?>
              </div>

            </div>

            <?php if(h($partnerManager->primary_contact) == 'Y'){?>
            <div class="row inner">

              <div class="col-xs-6">
                <?= __('Primary Contact')?>
              </div>

              <div class="col-xs-6">
                <span class="fa fa-check"></span> 
              </div>

            </div>
            <?php } ?>

            <div class="row inner">

              <div class="col-xs-12">


                <div class="dropdown pull-right">
                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Manage
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <?php 
                    if($auth_vendor_primary == 'Y'){?>

                    <li><?= $this->Html->link(__('Edit'), ['action' => 'edit', $partnerManager->id]); ?>
                      <li><?= $this->Html->link(__('View'), ['action' => 'view', $partnerManager->id]); ?>
                        <?php 
                        if($partnerManager->primary_contact != 'Y'){ ?>
                        <li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $partnerManager->id], ['confirm' => __('Are you sure you want to delete?', $partnerManager->id)]); ?>
                          <li><?= $this->Form->postLink(__('Make Primary'), ['action' => 'changePrimaryPmanager', $partnerManager->id], ['confirm' => __('Are you sure you want to change primary manager?', $partnerManager->id)]); ?>
                            <?php }
                          } 
                          ?>
                        </ul>
                      </div>

                    </div> <!--col-xs-12-->

                  </div>

                </div> <!--collapseOne-->

              </div> <!--row-->

            <?php endforeach; ?>

            <?php echo $this->element('paginator'); ?>

          </div><!--row table-th-->





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
                <?= $this->Html->link(__('Back'), $last_visited_page,['class' => 'btn btn-default btn-cancel']); ?>         


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /Card -->

