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
                                    <i class="icon ion-gear-b"></i></div>
                                </div>
                                <div class="card--info">
                                    <h2 class="card--title"><?=__('Upgrade');?></h2>
                                    <h3 class="card--subtitle"><?=__('Upgrade to increase your email send limit');?></h3>
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



<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

<div class="vendors--view">

    <fieldset class="well">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h4><?= __('Current package details')?></h4>
            </div>
        </div>
        <div class="row inner">

            <dt class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                <?php echo __('Package Name') ?>
            </dt>
            <dd class="col-lg-6 col-md-6 col-sm-6 col-xs-7">
                <?php echo $current_package['s']['name'] ?>
            </dd>
        </div>

        <div class="row inner">

            <dt class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                <?php echo __('Package Type') ?>
            </dt>
            <dd class="col-lg-6 col-md-6 col-sm-6 col-xs-7">
                <?php echo ucwords($current_package['subscription_type']). __(' Subscription') ?>
            </dd>
        </div>
        <div class="row inner">

            <dt class="col-lg-6 col-md-6 col-sm-6 col-xs-5">

                <?php 
                if($current_package['subscription_type'] == 'yearly'){
                    if ($current_package['currency_choice'] == 'GBP') {
                        $price = $this->Number->precision(($current_package['s']['annual_price']/ $current_package['GBP_rate']), 2). ' '.__('/ Year');
                    } elseif ($current_package['currency_choice'] == 'EUR') {
                        $price = $this->Number->precision(($current_package['s']['annual_price'] / $current_package['EUR_rate']), 2). ' '.__('/ Year');
                    } else {
                        $price = $this->Number->precision($current_package['s']['annual_price'], 2). ' '.__('/ Year');
                    }
                } else {
                    if ($current_package['currency_choice'] == 'GBP') {
                        $price = $this->Number->precision(($current_package['s']['monthly_price']/ $current_package['GBP_rate']), 2). ' '.__('/ Month');
                    } elseif ($current_package['currency_choice'] == 'EUR') {
                        $price = $this->Number->precision(($current_package['s']['monthly_price']/ $current_package['EUR_rate']), 2). ' '.__('/ Month');
                    } else {
                        $price = $this->Number->precision($current_package['s']['monthly_price'], 2). ' '.__('/ Month');
                    }
                };
                echo __('Price')
                ?>

            </dt>
            <dd class="col-lg-6 col-md-6 col-sm-6 col-xs-7">

                <?php
                if ($current_package['currency_choice'] == 'GBP') {
                    echo __('£ ').$price;
                } elseif ($current_package['currency_choice'] == 'EUR') {
                    echo __('€ ').$price;
                } else {
                    echo __('$').$price;
                }
                ?>  

            </dd>
        </div>
        <div class="row inner">
            <dt class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                <?php echo __('Partners')?>
            </dt>
            <dd class="col-lg-3 col-md-3 col-sm-3 col-xs-7">
                <?php echo $this->Number->precision($current_package['s']['no_partners'], 0) ?>
            </dd>
        </div>
        <div class="row inner">

            <dt class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
                <?php echo __('Email send limit')?>
            </dt>
            <dd class="col-lg-6 col-md-6 col-sm-6 col-xs-7">
                <?php echo $this->Number->precision($current_package['s']['no_emails'], 0).' / '.__('Month') ?>
            </dd>
        </div>
    </fieldset>



    <div class="row">
        <div class="col-md-6">
            <h4><?= __('Next Package'); ?></h4>
        </div>
        <div class="col-md-6 text-right">
            <?= $this->Form->postLink(__('Upgrade Now'), ['controller' => 'Vendors', 'action' => 'upgradeMyPackage',$package['id']], ['confirm' => __('Are you sure you want to upgrade ?',$package['id']),'class' => 'btn btn-primary']); ?>
        </div>
    </div>



    <div class="row inner">
        <dt class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <?= __('Package name'); ?>
        </dt>
        <dd class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <?= h($package['name']); ?>
        </dd>
    </div>

    <div class="row inner">
        <dt class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <?= __('Package price'); ?>
        </dt>
        <dd class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <?php

            if($package['vendor_subscription_type'] == 'monthly'){
                if ($current_package['currency_choice'] == 'GBP') {
                    echo __('£ ').$this->Number->precision(($package['monthly_price']/$current_package['GBP_rate']), 2). ' '.__('/ Month');
                } elseif ($current_package['currency_choice'] == 'EUR') {
                    echo __('€ ').$this->Number->precision(($package['monthly_price']/$current_package['EUR_rate']), 2). ' '.__('/ Month');
                } else {
                    echo __('$ ').$this->Number->precision($package['monthly_price'], 2). ' '.__('/ Month');
                }

            } else {
                if ($current_package['currency_choice'] == 'GBP') {
                    echo __('£ ').$this->Number->precision(($package['annual_price']/$current_package['GBP_rate']), 2). ' '.__('/ Year');
                } elseif ($current_package['currency_choice'] == 'EUR') {
                    echo __('€ ').$this->Number->precision(($package['annual_price']/$current_package['EUR_rate']), 2). ' '.__('/ Year');
                } else {
                    echo __('$ ').$this->Number->precision($package['annual_price'], 2). ' '.__('/ Year');
                }

            }
            ?>
        </dd>
    </div>

    <div class="row inner">
        <dt class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <?= __('Partners'); ?>
        </dt>
        <dd class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <?= $this->Number->precision($package['no_partners'], 0); ?>
        </dd>
    </div>

    <div class="row inner">
        <dt class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <?= __('Email send limit'); ?>
        </dt>
        <dd class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <?= $this->Number->precision($package['no_emails'], 0).' / '.__('Month'); ?>
        </dd>
    </div>

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

        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
<!-- /Card -->

