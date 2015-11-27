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
                                <i class="icon ion-home"></i></div>
                            </div>
                            <div class="card--info">
                                <h2 class="card--title"><?= __('Upcoming campaigns (next QTR)'); ?></h2>
                                <h3 class="card--subtitle"><?= __('(next QTR)'); ?></h3>
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
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </p>
                            <hr>
                        </div>
                    </div>
                -->
                    <!-- content below this line -->
                    <div class="row">
                   <div class="col-md-12">
                        

                        
                        <div class="row table-th hidden-xs">
                            
                            <div class="clearfix"></div>
                                
                            <div class="col-sm-10">
                                <?= __('Campaign name') ?>
                            </div>
                            
                            <div class="col-sm-2">
                            </div>
                            
                        </div> <!--/.row.table-th -->
                        
                        <!-- Are there any campaigns? -->
                        <?php
                            if($campaign_next->count()>0)
                            {
                        ?>
                        
                        <!-- Start loop -->
                        <?php
                            $j =0;
                            foreach ($campaign_next as $row):
                            $j++;
                        ?>
                        
                            <div class="row inner hidden-xs">
                            
                                <div class="col-sm-10">
                                    <?= $row->name ?>
                                </div>
                                
                                <div class="col-sm-2">
                            
                                    <div class="btn-group pull-right">
                                        <?= $this->Html->link('View',['controller'=>'PartnerCampaigns','action'=>'viewCampaign',$row->id],['class'=>'btn btn-default'])?>
                                    </div>
                                
                                </div>
                                
                            </div> <!--/.row.inner-->
                            
                            <div class="row inner visible-xs"   >
                            
                                <div class="col-xs-12 text-center">
                                        
                                    <a data-toggle="collapse" data-parent="#accordion" href="#upcoming-<?= $j ?>">
                                        <h3><?= $row->name ?></h3>
                                    </a>
                                    
                                </div> <!-- /.col -->
                                
                                <div class="col-xs-12 panel-collapse collapse" id="upcoming-<?= $j ?>">
                            
                                    <div class="row inner">
                                    
                                        <div class="col-xs-6">
                                            <?= 'Campaign name'?>
                                      </div>
                                        
                                      <div class="col-xs-6">
                                            <?= $row->name ?>
                                      </div>
                                                                                
                                        <div class="col-xs-12">
                                    
                                            <div class="btn-group pull-right">
                                                <?= $this->Html->link('View',['controller'=>'PartnerCampaigns','action'=>'availablecampaigns'],['class'=>'btn btn-default'])?>
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
                                    <?=  __('No upcoming campaigns') ?>
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
<!-- /Card -->


