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
                                    <i class="icon ion-briefcase"></i>
                                </div>
                            </div>
                            <div class="card--info">
                                <h2 class="card--title"><?= __('Managers'); ?></h2>
                                <h3 class="card--subtitle"></h3>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="card--actions">
                                <?= $this->Html->link(__('Add new'), ['action' => 'addVendorManager'],['class'=>'btn btn-primary pull-right']); ?>
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="card-content">
<!--
<div class="row">
<div class="col-md-12">
<h4>Campaign Overview</h4>
<p>Breakdown of all campaigns to date, showcasing their status, how many partners have applied for the campaign, how many approved, how many have executed and the results seen to date.
</p>
<hr>
</div>
</div>
-->
<!-- content below this line -->
<div class="vendorManagers index">



    <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

    <div class="row table-th hidden-xs">    
        <div class="col-lg-5 col-md-5 col-sm-3 col-xs-3">
            <?= $this->Paginator->sort('user_id','Name'); ?>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center">
            <?= $this->Paginator->sort('primary_manager','Primary Manager'); ?>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-7 col-xs-5">
        </div>

    </div> <!-- /.row -->

    <?php 
    $j =0;
    $auth =   $this->Session->read('Auth');
    $auth_vendor_primary   =   $auth['User']['primary_manager'];
    foreach ($vendorManagers as $vendorManager): 
        $j++;
    ?>
    <!-- Start loop -->
    <div class="row inner hidden-xs">
        <div class="col-lg-4 col-md-4 col-sm-3 col-xs-3">
            <?= h($vendorManager->user->full_name); ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-2 col-xs-2 text-center">
            <?php
            if($vendorManager->primary_manager == 'Y'){ ?>
            <span class="fa fa-check"></span><?php
        }
        ?>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-7 col-xs-5">

        <div class="dropdown pull-right">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Manage
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><?= $this->Html->link('<i class="icon ion-eye"></i> '.__('View'), ['action' => 'viewManager', $vendorManager->id], ['escape' => false]); ?></li>
                <li><?= $this->Html->link('<i class="icon ion-edit"></i> '.__('Edit'), ['action' => 'editManager', $vendorManager->id], ['escape' => false]); ?></li>

                <li>                    <?php 
                if($auth_vendor_primary == 'Y' && $vendorManager->user_id != $auth['User']['id']){
                    echo $this->Form->postLink('<i class="icon ion-trash-a"></i> '.__('Delete'), ['action' => 'deleteVendorManager', $vendorManager->id], ['escape' => false], ['confirm' => __('Are you sure you want to delete?', $vendorManager->id)]);
                }?>
                <?php 
                if($auth_vendor_primary == 'Y' && $vendorManager->primary_manager != 'Y'){
                    echo $this->Form->postLink(__('Make Primary'), ['controller' => 'Vendors', 'action' => 'changePrimaryVmanager', $vendorManager->id], ['confirm' => __('Are you sure you want to change the Primary Vendor Manager?', $vendorManager->id)]);
                }?></li>
            </ul>
        </div>


    </div>  
</div> <!--row-->

<!-- For mobile view only -->
<div class="row inner visible-xs">

    <div class="col-xs-12 text-center">

        <a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">

            <h3><?= $vendorManager->user->full_name; ?></h3>

        </a>

    </div> <!--col-->

    <div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">

        <div class="row inner">
            <div class="col-xs-5">
                <?= __('Name')?>
            </div>
            <div class="col-xs-7">
                <?= $vendorManager->user->full_name; ?>
            </div>
        </div>

        <div class="row inner">
            <div class="col-xs-5">
                <?= __('Primary Manager')?>
            </div>
            <div class="col-xs-7">
                <?php
                if($vendorManager->primary_manager == 'Y'){ ?>
                <span class="glyphicon glyphicon-ok"></span><?php
            }
            ?>
        </div>
    </div>

    <div class="row inner">
        <div class="col-xs-12">
            <div class="btn-group pull-right">
                <?= $this->Html->link(__('View'), ['action' => 'viewManager', $vendorManager->id],['class' => 'btn pull-right']); ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'editManager', $vendorManager->id],['class' => 'btn pull-right']); ?>
                <?php 
                if($auth_vendor_primary == 'Y' && $vendorManager->user_id != $auth['User']['id']){
                    echo $this->Form->postLink(__('Delete'), ['action' => 'deleteVendorManager', $vendorManager->id], ['confirm' => __('Are you sure you want to delete?', $vendorManager->id),'class' => 'btn btn-danger pull-right']);
                }?>
                <?php 
                if($auth_vendor_primary == 'Y' && $vendorManager->primary_manager != 'Y'){
                    echo $this->Form->postLink(__('Make Primary'), ['controller' => 'Vendors', 'action' => 'changePrimaryVmanager', $vendorManager->id], ['confirm' => __('Are you sure you want to change the Primary Vendor Manager?', $vendorManager->id),'class' => 'btn pull-right']);
                }?>
            </div>
        </div>
    </div>

</div> <!-- /.collapse -->

</div> <!-- /.row -->

<?php endforeach; ?>

<?php echo $this->element('paginator'); ?>

</div><!--row table-th-->





</div>
<div class="card-footer">
    <div class="row">
        <div class="col-md-6">
            <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>               
                    <?php
                    $this->Html->addCrumb('Managers', ['controller' => 'vendors', 'action' => 'listvendormanagers']);
                    echo $this->Html->getCrumbs(' / ', [
                        'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
                        'url' => ['controller' => 'Vendors', 'action' => 'index'],
                        'escape' => false
                        ]);
                        ?>
                    </li>
                </ol>
            </div>
            <div class="col-md-6">
                <?= $this->Html->link(__('Back'), ['controller' => 'vendors', 'action' => 'index'],['class' => 'btn btn-primary pull-right']); ?> 

            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<!-- /Card -->