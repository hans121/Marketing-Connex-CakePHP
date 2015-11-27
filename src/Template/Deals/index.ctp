<?php 
$this->layout = 'admin--ui';
$admn = $this->Session->read('Auth');
$my_currency    =   $admn['User']['currency'];
$this->set(compact('my_currency'));
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
                                    <i class="icon ion-cash"></i></div>
                                </div>
                                <div class="card--info">
                                    <h2 class="card--title"><?= __('Deals'); ?></h2>
                                    <h3 class="card--subtitle">List of Deals Registered to Date</h3>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="card--actions">
                                    <div class="dropdown pull-right">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            Manage
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                            <li><?= $this->Html->link(($salesforce_isauth?__('SalesForce Connected'):__('Connect to SalesForce')), ['controller'=>'ExternalApps','action'=>'salesforceInitialize'],['disabled'=>($salesforce_isauth?'true':'false')]); ?></li>
                                        </ul>
                                    </div>                            </div>
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

<div class="vendorManagers index">

    <?= $this->Form->create(null,['url'=>['controller'=>'Deals','action'=>'index'],'type'=>'post']); ?>
    <div class="row table-title">
        <div class="col-lg-3"><?= $this->Form->select('field',[''=>'Select Field','partner'=>'Partner','name'=>'Name','company'=>'Company'],['label'=>false, 'class' => 'form-control']); ?></div>
        <div class="col-lg-5">
            <div class="input-group">
                <?= $this->Form->input('query', ['label'=>false,'placeholder'=>'Search Term','class'=>'form-control']);?> <span class="input-group-btn"><?= $this->Form->button('<i class="icon ion-chevron-right"></i>',['class'=> 'btn btn-search btn-primary']); ?></span></div></div>
        </div>
        <hr>

        <?= $this->Form->end(); ?>

        <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

        <div class="row table-th hidden-xs">
            <div class="col-lg-3">
                <?= h('Partner') ?>
            </div>
            <div class="col-lg-2">
                <?= h('Name') ?>
            </div>
            <div class="col-lg-2">
                <?= h('Company') ?>
            </div>
            <div class="col-lg-1">
                <?= h('Value') ?>
            </div>
            <div class="col-lg-2 text-center">
                <?= h('Closure Date') ?>
            </div>
            <div class="col-lg-1 text-center">
                <?= h('Status') ?>
            </div>
            <div class="col-lg-1">
            </div>

        </div> <!-- /.row -->

        <?php 
        $j =0;
        foreach ($deals as $deal): 
            $j++;
        ?>
        <!-- Start loop -->
        <div class="row inner hidden-xs">
            <div class="col-md-3">
                <?= $deal->partner['company_name'] ?>
            </div>
            <div class="col-md-2">
                <?= $deal->partner_manager->user['first_name'].' '.$deal->partner_manager->user['last_name'] ?>
            </div>
            <div class="col-md-2">
                <?= $deal->lead['company'] ?>
            </div>
            <div class="col-md-1">
                <?= $this->Number->currency(round($deal->deal_value),$my_currency,['places'=>0]);?>
            </div>
            <div class="col-md-2 text-center">
                <?=$deal->closure_date ? date('d/m/Y',strtotime($deal->closure_date)) : '--------' ?>
            </div>
            <div class="col-md-1 text-center">
                <?= $deal->status=='Y'?'Closed':'Open' ?>
            </div>
            <div class="col-md-1">
                <div class="dropdown pull-right">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Manage
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><?= $this->Html->link('<i class="icon ion-eye"></i> '.__('View'), ['action' => 'view', $deal->id], ['escape' => false]); ?></li>
                    </ul>
                </div>
            </div>  
        </div> <!--row-->

        <!-- For mobile view only -->
        <div class="row inner visible-xs">

            <div class="col-xs-12 text-center">

                <a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">

                    <h3><?= $deal->partner_lead->partner['company_name'] ?></h3>

                </a>

            </div> <!--col-->

            <div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">

                <div class="row inner">
                    <div class="col-xs-5">
                        <?= __('Name')?>
                    </div>
                    <div class="col-xs-7">
                        <?= $deal->partner_manager->user['first_name'].' '.$deal->partner_manager->user['last_name'] ?>
                    </div>
                </div>

                <div class="row inner">
                    <div class="col-xs-5">
                        <?= __('Company')?>
                    </div>
                    <div class="col-xs-7">
                        <?= $deal->partner_lead->lead['company'] ?>
                    </div>
                </div>

                <div class="row inner">
                    <div class="col-xs-5">
                        <?= __('Value')?>
                    </div>
                    <div class="col-xs-7">
                        <?= $deal->deal_value; ?>
                    </div>
                </div>

                <div class="row inner">
                    <div class="col-xs-5">
                        <?= __('Closure Date')?>
                    </div>
                    <div class="col-xs-7">
                        <?= date('d/m/Y',strtotime($deal->closure_date)) ?>
                    </div>
                </div>

                <div class="row inner">
                    <div class="col-xs-5">
                        <?= __('Status')?>
                    </div>
                    <div class="col-xs-7">
                        <?= $deal->status=='Y'?'Closed':'Open' ?>
                    </div>
                </div>

                <div class="row inner">
                    <div class="col-xs-12">
                        <div class="dropdown pull-right">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                Manage
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><?= $this->Html->link(__('View'), ['action' => 'view', $lead->id]); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div> <!-- /.collapse -->

        </div> <!-- /.row -->

    <?php endforeach; ?>

    <?php echo $this->element('paginator'); ?>

</div><!--row table-th-->

</div> <!-- index?-->


<!-- /content below this line -->


<div class="card-footer">
    <div class="row">
        <div class="col-md-6">
            <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>               
                    <?php
                    $this->Html->addCrumb('Deals', ['controller' => 'Deals', 'action' => 'index']);
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

            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<!-- /Card -->
