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
<button type="button" class="close pull-right" data-toggle="collapse" data-target="#collapseFundingApproved"><i class="icon icon--small ion-minus-circled"></i></button>

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="card--icon">
                                <div class="bubble">
                                    <i class="icon "></i></div>
                            </div>
                            <div class="card--info">
                                <h2 class="card--title"><?= __('Funding approved (by partner)'); ?></h2>
                                <h3 class="card--subtitle"></h3>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="card--actions">
                            </div>
                        </div>
                    </div>   
                </div>
                                <div class="collapse in" id="collapseFundingApproved">

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

                    <div class="col-sm-12 col-xs-12">



                        <!-- Are there any campaigns? -->
                        <?php
                        if($funding_approved_partner->count()>0)
                        {
                            ?>

                            <div class="row table-th hidden-xs">

                                <div class="clearfix"></div>

                                <div class="col-md-4 col-sm-5">
                                    <?= __('Partner') ?>
                                </div>

                                <div class="col-md-3 col-sm-4 text-right">
                                    <?= __('QTD') ?>
                                </div>

                                <div class="col-md-3 hidden-sm text-right">
                                    <?= __('YTD') ?>
                                </div>

                                <div class="col-md-2 col-sm-3">
                                </div>

                            </div> <!--/.row.table-th -->

                            <!-- Start loop -->
                            <?php
                            $m =0;
                            foreach ($funding_approved_partner as $key=>$row):
                                $m++;

// data for QTD
                            $rowq = $funding_approved_partnerq[$key];

// total for YTD
                            $total_funding=0;
                            foreach($row->businesplans as $businesplan)
                                $total_funding += $businesplan->required_amount;

// total for QTD
                            $total_fundingq=0;
                            foreach($rowq['businesplans'] as $businesplan)
                                $total_fundingq += $businesplan['required_amount'];
                            ?>

                            <div class="row inner hidden-xs">

                                <div class="col-md-4 col-sm-5">
                                    <?= $row['company_name'] ?>
                                </div>

                                <div class="col-md-3 col-sm-4 small text-right">
                                    <?= $this->Number->currency(round($total_fundingq),$my_currency,['places'=>0]);?>
                                </div>

                                <div class="col-md-3 hidden-sm small text-right">
                                    <?= $this->Number->currency(round($total_funding),$my_currency,['places'=>0]);?>
                                </div>

                                <div class="col-md-2 col-sm-3">

                                    <div class="btn-group pull-right">
                                        <?= $this->Html->link('Details',['controller'=>'Vendors','action'=>'viewPartner',$row['id']],['class'=>'btn btn-default'])?>
                                    </div>

                                </div>

                            </div> <!--/.row.inner-->

                            <div class="row inner visible-xs"   >

                                <div class="col-xs-12 text-center">

                                    <a data-toggle="collapse" data-parent="#accordion" href="#basic1-<?= $m ?>">
                                        <h3><?= $row['company_name'] ?></h3>
                                    </a>

                                </div> <!-- /.col -->

                                <div class="col-xs-12 panel-collapse collapse" id="basic1-<?= $m ?>">

                                    <div class="row inner">

                                        <div class="col-xs-5">
                                            <?= __('QTD') ?>
                                        </div>
                                        <div class="col-xs-7">
                                            <?= $this->Number->currency(round($total_funding_querter),$my_currency,['places'=>0]);?>
                                        </div>

                                        <div class="col-xs-5">
                                            <?= __('YTD') ?>
                                        </div>
                                        <div class="col-xs-7">
                                            <?= $this->Number->currency(round($total_funding),$my_currency,['places'=>0]);?>
                                        </div>

                                        <div class="col-xs-12">

                                            <div class="btn-group pull-right">
                                                <?= $this->Html->link('Details',['controller'=>'Vendors','action'=>'viewPartner',$row['id']],['class'=>'btn btn-default'])?>
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
                                    <?=  __('No partners found') ?>
                                </div>

                            </div> <!--/.row.inner-->

                            <?php

                        }

                        ?>

                        <!-- End loop -->

                    </div> <!-- /.col -->

                </div> <!-- /.row -->

</div>

            </div>
        </div>
    </div>
</div>
</div>
<!-- /Card -->


