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
                                <h2 class="card--title"><?= __('Partner Manager league table'); ?></h2>
                                <h3 class="card--subtitle"><?= $partner_name.', '.$financialquarter_current->quartertitle; ?></h3>
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
                        

                        
                        <!-- Are there any campaigns? -->
                        <?php
                            if(count($partner_manager_data)>0)
                            {
                        ?>
                        
                        <div class="row table-th hidden-xs">
                            
                            <div class="clearfix"></div>
                                
                            <div class="col-sm-1">
                                <?= __('Rank') ?>
                            </div>
                                
                            <div class="col-sm-2">
                                <?= __('Partner name') ?>
                            </div>
                            
                            <div class="col-sm-1 text-right">
                                <?= __('Campaigns completed') ?>
                            </div>

                            <div class="col-sm-2 text-right">
                                <?= __('Deals closed') ?>
                            </div>
                            
                            <div class="col-sm-2 text-right">
                                <?= __('Total value') ?>
                            </div>

                            <div class="col-sm-1 text-right">
                                <?= __('Campaigns active') ?>
                            </div>
                            
                            <div class="col-sm-3">
                            </div>
                            
                        </div> <!--/.row.table-th -->
                        
                        <div class="rosette">
                            
                            <!-- Start loop -->
                            <?php
                                $j =0;
                                foreach ($partner_manager_data as $row):
                                $j++;
                            ?>
                            
                                <div class="row inner hidden-xs">
                                
                                    <div class="col-sm-1 text-center rank-<?=$j?>">
                                        <?= $j ?>
                                    </div>
                                    <div class="col-sm-2">
                                        <?= $row['partner_name'] ?>
                                    </div>
                                    
                                    <div class="col-sm-1 text-right">
                                        <?= $row['campaigns_completed'] ?>
                                    </div>
                                    
                                    <div class="col-sm-2 text-right">
                                        <?= $row['deals_closed'] ?>
                                    </div>
                                    
                                    <div class="col-sm-2 text-right">
                                        <?= $this->Number->currency(round($row['deals_value']),$my_currency,['places'=>0]) ?>
                                    </div>
                                    
                                    <div class="col-sm-1 text-right">
                                        <?= $row['campaigns_active'] ?>
                                    </div>
                                    
                                    <div class="col-sm-3">
                                
                                        <div class="btn-group pull-right">
                                            <?= $this->Html->link('Details',['controller'=>'PartnerManagers','action'=>'view/'.$row['id']],['class'=>'btn btn-default'])?>
                                        </div>
                                    
                                    </div>
                                    
                                </div> <!--/.row.inner-->
                                
                                <div class="row inner visible-xs"   >
                                
                                    <div class="col-xs-12 text-center">
                                            
                                        <a data-toggle="collapse" data-parent="#accordion" href="#partnerleague-<?= $j ?>">
                                            <h3><?= $j.' - '. $row['partner_name'] ?></h3>
                                        </a>
                                        
                                    </div> <!-- /.col -->
                                    
                                    <div class="col-xs-12 panel-collapse collapse" id="partnerleague-<?= $j ?>">
                                
                                        <div class="row inner">
                                        
                                            <div class="col-xs-6">
                                                <?= __('Campaigns completed') ?>
                                          </div>
                                            
                                          <div class="col-xs-6">
                                                <?= $row['campaigns_completed'] ?>
                                          </div>
                                          
                                          <div class="col-xs-6">
                                                <?= __('Deals closed') ?>
                                          </div>
                                          
                                      <div class="col-xs-6">
                                                <?= $row['deals_closed'] ?>
                                        </div>
                                                                                    
                                            <div class="col-xs-6">
                                                <?= __('Total value') ?>
                                          </div>
                                            
                                          <div class="col-xs-6">
                                                <?= $this->Number->currency(round($row['deals_value']),$my_currency,['places'=>0]) ?>
                                          </div>
                                          
                                          <div class="col-xs-6">
                                                <?= __('Campaigns active') ?>
                                          </div>
                                          
                                      <div class="col-xs-6">
                                                <?= $row['campaigns_active'] ?>
                                        </div>

                                            <div class="col-xs-12">
                                        
                                                <div class="btn-group pull-right">
                                                    <?= $this->Html->link('Details',['controller'=>'PartnerManagers','action'=>'view/'.$row['id']],['class'=>'btn btn-default'])?>
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
            
                </div> <!-- /.rosette -->
                
            </div> <!-- /.row -->

    </div> <!-- /.col -->
</div>

                </div>

            </div>
        </div>
    </div>
</div>
<!-- /Card -->


