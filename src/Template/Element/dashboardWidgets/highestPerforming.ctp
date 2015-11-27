<!-- parter performance -->



<?php 
$this->layout = 'admin--ui';
?>
<!-- Card -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card--header">
<button type="button" class="close pull-right" data-toggle="collapse" data-target="#collapseHighestPerforming"><i class="icon icon--small ion-minus-circled"></i></button>

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="card--icon">
                                <div class="bubble">
                                    <i class="icon ion-arrow-graph-up-right"></i></div>
                            </div>
                            <div class="card--info">
                                <h2 class="card--title"><?= __('Highest performing partners'); ?></h2>
                                <h3 class="card--subtitle">Snapshot of your top 5 Highest Earning Partners</h3>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="card--actions">
                                                                <?= $this->Html->link(__('View all'), ['controller' => 'Vendors','action' => 'Partners'], ['class' => 'btn btn-primary pull-right']); ?>

                            </div>
                        </div>
                    </div>   
                </div>
                                                <div class="collapse in" id="collapseHighestPerforming">

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

                    <div class="row charts">

                        <div class="col-sm-12 col-xs-12">



                            <!-- Are there any campaigns? -->
                            <?php
                            if(count($partners_registered_highest)>0)
                            {
                                ?>

                                <div class="row table-th hidden-xs">

                                    <div class="clearfix"></div>

                                    <div class="col-md-3 col-sm-5">
                                        <?= __('Partner') ?>
                                    </div>

                                    <div class="col-md-1 hidden-sm text-right">
                                        <?= __('Deals closed') ?>
                                    </div>

                                    <div class="col-md-3 col-sm-4 text-right">
                                        <?= __('Value of closed deals') ?>
                                    </div>

                                    <div class="col-md-3 hidden-sm text-right">
                                        <?= __('ROI') ?>
                                    </div>

                                    <div class="col-md-2 col-sm-3">
                                    </div>

                                </div> <!--/.row.table-th -->

                                <?php
                                $cnt=1;
                                foreach($partners_registered_highest as $row):
                                    ?>

                                <div class="row inner hidden-xs">

                                    <div class="col-md-3 col-sm-5 small">
                                        <?= $row['partner_name'] ?>
                                    </div>

                                    <div class="col-md-1 hidden-sm small text-right">
                                        <?= $row['deals_count'] ?>
                                    </div>

                                    <div class="col-md-3 col-sm-4 small text-right">
                                        <?= $this->Number->currency(round($row['deals_value']),$my_currency,['places'=>0]);?>
                                    </div>

                                    <div class="col-md-3 hidden-sm small text-right">
                                        <?= $this->Number->currency(round($row['roi']),$my_currency,['places'=>0]);?>
                                    </div>

                                    <div class="col-md-2 col-sm-3">

                                        <div class="btn-group pull-right">
                                            <?= $this->Html->link('Details',['controller'=>'Vendors','action'=>'viewPartner/'.$row['id']],['class'=>'btn btn-default'])?>
                                        </div>

                                    </div>

                                </div> <!--/.row.inner-->

                                <div class="row inner visible-xs"   >

                                    <div class="col-xs-12 text-center">

                                        <a data-toggle="collapse" data-parent="#accordion" href="#basic5-<?= $cnt ?>">
                                            <h3><?= $cnt.' - '.$row['partner_name'] ?></h3>
                                        </a>

                                    </div> <!-- /.col -->

                                    <div class="col-xs-12 panel-collapse collapse" id="basic5-<?= $cnt ?>">

                                        <div class="row inner">

                                            <div class="col-xs-5">
                                                <?= __('Deals closed') ?>
                                            </div>
                                            <div class="col-xs-7">
                                                <?= $row['deals_count'] ?>
                                            </div>

                                            <div class="col-xs-5">
                                                <?= __('Value of closed deals') ?>
                                            </div>
                                            <div class="col-xs-7">
                                                <?= $this->Number->currency(round($row['deals_value']),$my_currency,['places'=>0]);?>
                                            </div>

                                            <div class="col-xs-5">
                                                <?= 'ROI'?>
                                            </div>
                                            <div class="col-xs-7">
                                                <?= $this->Number->currency(round($row['roi']),$my_currency,['places'=>0]);?>
                                            </div>

                                            <div class="col-xs-12">

                                                <div class="btn-group pull-right">
                                                    <?= $this->Html->link('Details',['controller'=>'Vendors','action'=>'viewPartner/'.$row['id']],['class'=>'btn btn-default'])?>
                                                </div>

                                            </div>

                                        </div> <!--collapseOne-->

                                    </div> <!--row-->

                                </div> <!-- /.row.inner -->

                                <?php
                                $cnt++;
                                if($cnt==6) break;
                                endforeach;

                            } else {

                                ?>

                                <div class="row inner withtop">

                                    <div class="col-sm-12 text-center">
                                        <?=  __('No partners found') ?>
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


