<!-- parter performance -->



<?php 
$this->layout = 'admin--ui';
?>
                   <?php 
                    $campaignQuarter = $campaignQ->toArray();
                    ?>
<!-- Card -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card--header">
                                <button type="button" class="close pull-right" data-toggle="collapse" data-target="#collapseCampaignsActive"><i class="icon icon--small ion-minus-circled"></i></button>

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="card--icon">
                                <div class="bubble">
                                    <i class="icon ion-clock"></i>
                                </div>
                            </div>
                            <div class="card--info">
                                <h2 class="card--title"><?= __('Campaigns active'); ?></h2>
                                <h3 class="card--subtitle"><?= __('Campaigns active/complete in '.$campaignQuarter[0]['financialquarter']['quartertitle']).' '; ?></h3>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="card--actions">
                                <?= $this->Html->link(__('View all'), ['controller' => 'campaigns','action' => 'index'], ['class' => 'btn btn-primary pull-right']); ?>

                            </div>
                        </div>
                    </div>   
                </div>
                <div class="collapse in" id="collapseCampaignsActive">

                <div class="card-content">
                    <!--
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Campaign Options</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </p>
                            <hr>
                        </div>
                    </div>
                -->
                    <!-- content below this line -->

<div class="row">
    <div class="col-md-12">



                <!-- Are there any campaigns? -->
                <?php
                if($campaignQ->count()>0) {
                    ?>

                    <div class="row table-th hidden-xs">

                        <div class="clearfix"></div>

                        <div class="col-md-7 col-sm-8">
                            <?= __('Campaign name') ?>
                        </div>

                        <div class="col-md-1 hidden-sm text-right">
                            <?= __('Deals') ?>
                        </div>

                        <div class="col-md-2 col-sm-2 text-right">
                            <?= __('Deals value') ?>
                        </div>

                        <div class="col-md-2 col-sm-2">
                        </div>

                    </div> <!--/.row.table-th -->

                    <!-- Start loop -->
                    <?php
                    $j =0;
                    foreach ($campaignQ as $row):
                        $j++;
                    $total_deal = 0;
                    $deal_count = 0;
                    foreach($row->campaign_partner_mailinglists as $row2) {                 
                        if($row2['campaign_partner_mailinglist_deals'][0]['status']=='Y') {
                            $total_deal += $row2['campaign_partner_mailinglist_deals'][0]['deal_value'];
                            $deal_count++;
                        }
                    }
                    ?>

                    <div class="row inner hidden-xs">

                        <div class="col-md-7 col-sm-8">
                            <?= $row->name ?>
                        </div>

                        <div class="col-md-1 hidden-sm text-right">
                            <?= $deal_count ?>
                        </div>

                        <div class="col-md-2 col-sm-2 text-right">

                            <?= $this->Number->currency(round($total_deal),$my_currency,['places'=>0]);?>
                        </div>

                        <div class="col-md-2 col-sm-2">

                            <div class="btn-group pull-right">
                                <?= $this->Html->link('Details',['controller'=>'campaigns','action'=>'view/'.$row->id],['class'=>'btn btn-default'])?>
                            </div>

                        </div>

                    </div> <!--/.row.inner-->

                    <div class="row inner visible-xs"   >

                        <div class="col-xs-12 text-center">

                            <a data-toggle="collapse" data-parent="#accordion" href="#basic-<?= $j ?>">
                                <h3><?= $row->name ?></h3>
                            </a>

                        </div> <!-- /.col -->

                        <div class="col-xs-12 panel-collapse collapse" id="basic-<?= $j ?>">

                            <div class="row inner">

                                <div class="col-xs-5">
                                    <?= __('Number of deals') ?>
                                </div>
                                <div class="col-xs-7">
                                    <?= $deal_count ?>
                                </div>

                                <div class="col-xs-5">
                                    <?= __('Deals value') ?>
                                </div>
                                <div class="col-xs-7">
                                    <?= $this->Number->currency(round($total_deal),$my_currency,['places'=>0]);?>
                                </div>

                                <div class="col-xs-12">

                                    <div class="btn-group pull-right">
                                        <?= $this->Html->link('View',['controller'=>'PartnerCampaigns','action'=>'mycampaignslist'],['class'=>'btn btn-default'])?>
                                    </div>

                                </div>

                            </div> <!--collapseOne-->

                        </div> <!--row-->

                    </div> <!-- /.row.inner -->

                    <?php

                    endforeach;

                } else {

                    ?>

                    <div class="row inner withtop">

                        <div class="col-sm-12 text-center">
                            <?=  __('No campaigns found') ?>
                        </div>

                    </div> <!--/.row.inner-->

                    <?php

                }

                ?>

                <!-- End loop -->

            </div> <!-- /.col -->
</div>

                </div>
</div>
            </div>
        </div>
    </div>
</div>
    <!-- /Card -->


