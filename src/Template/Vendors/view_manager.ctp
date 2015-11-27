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
                                    <i class="icon ion-briefcase"></i></div>
                                </div>
                                <div class="card--info">
                                    <h2 class="card--title"><?= __('Manager'); ?></h2>
                                    <h3 class="card--subtitle"></h3>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="card--actions">
                                    <?= $this->Html->link(__('Add new'), ['controller' => 'Vendors','action' => 'addVendorManager'],['class'=>'btn btn-primary pull-right']); ?>
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


<div class="vendorManagers view">



    <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

    <div class="row inner header-row ">

        <dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4">
            <?= h($vendorManager->user->title. ' '.$vendorManager->user->full_name); ?>
        </dt>

        <dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
            <div class="btn-group pull-right">
                <?= $this->Html->link(__('Edit'), ['controller' => 'Vendors','action' => 'editManager', $vendorManager->id],['class' => 'btn btn-default pull-right']); ?>
            </div>
        </dd>

    </div>

    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Job Title'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= h($vendorManager->user->job_title); ?>
        </dd>
    </div>

    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Company'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= h($vendorManager->vendor->company_name); ?>
        </dd>
    </div>

    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('E-mail'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= h($vendorManager->user->email); ?>
        </dd>
    </div>

    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Phone'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= h($vendorManager->user->phone); ?>
        </dd>
    </div>

    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Primary Manager'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?php if($vendorManager->primary_manager == 'Y') { ?>
            <span class="fa fa-check"></span>
            <?php } ?>
        </dd>
    </div>

    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Username'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= h($vendorManager->user->username); ?>
        </dd>
    </div>

</div>



</div>
<div class="card-footer">
    <div class="row">
        <div class="col-md-6">
            <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>               
                    <?php
                    $this->Html->addCrumb('Managers', ['controller' => 'vendors', 'action' => 'listvendormanagers']);
                    $this->Html->addCrumb('view', ['controller' => 'vendors', 'action' => 'viewManager', $vendorManager->id]);
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
                <?= $this->Html->link(__('Back'), $last_visited_page,['class' => 'btn btn-primary pull-right']); ?> 

            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<!-- /Card -->