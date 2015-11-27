<?php 
$admn = $this->Session->read('Auth');
$my_currency    =   $admn['User']['currency'];
$this->set(compact('my_currency'));
?>

				<!-- Are there any deals? -->
				<?php
					if($campaignPartnerMailinglistDeal->count()>0)
					{
				?>
				
				<div class="row table-th hidden-xs">
					
					<div class="clearfix"></div>	
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<?= __('Rank') ?>
					</div>
					<div class="col-lg-2 col-md-3 col-sm-3 col-xs-3">
						<?= __('Name') ?>
					</div>
					<div class="col-lg-2 hidden-md hidden-sm col-xs-1">
						<?= __('Company name') ?>
					</div>
					<div class="col-lg-1 col-md-2 col-sm-3 col-xs-1 text-center">
						<?= __('Deal value') ?>
					</div>
					<div class="col-lg-2 col-md-2 hidden-sm col-xs-1 text-center">
						<?= __('Closure date') ?>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-1">
						<?= __('Status') ?>
					</div>
					<div class="col-lg-2 col-md-3 col-sm-2 col-xs-4">
					</div>
					
				</div> <!--row-table-th-->


				<div class="rosette">    
					
					<!-- Start loop -->
					<?php
							$j =0;
						  foreach ($campaignPartnerMailinglistDeal as $row):
						  $j++;
					?>
					
						<div class="row inner hidden-xs">
						
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center rank-<?= $j ?>">
								<?= $j ?>
						  </div>
						  
						  <?php
							  $email = $row['partner_manager']['user']->email;
							  $size = 30;
							  $grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default_avtar_url ) . "&s=".$size;
							?>
							<div class="col-lg-2 col-md-3 col-sm-3 col-xs-3">
							
								<?= $this->Html->image($grav_url,['class' => 'gravatar', 'width' => '35', 'height' => '35'])?>
								&nbsp;
								<?= $row['partner_manager']['user']->first_name.' '.$row['partner_manager']['user']->last_name ?>
							</div>
							
							<div class="col-lg-2 hidden-md hidden-sm col-xs-1">
								<?= $row['partner_manager']['partner']->company_name ?>
							</div>
							
							<div class="col-lg-1 col-md-2 col-sm-3 col-xs-1 text-right">
								<?=$this->Number->currency($row->deal_value, $my_currency);?>
							</div>
							
							<div class="col-lg-2 col-md-2 hidden-sm col-xs-1 text-center">
								<?= date('d/m/Y',strtotime($row->closure_date)) ?>	
							</div>
							
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-1">
						    <?php
							    if($row->status == 'Y') {
									  echo ('<i class="fa fa-gavel"></i>'.' '.__('Closed'));
									} else {
									  echo ('<i class="fa fa-bookmark"></i>'.' '.__('Registered'));
									}
									?>
							</div>
						
							<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
						
								<div class="btn-group pull-right">
									<?= $this->Html->link('View',['controller'=>'CampaignPartnerMailinglists','action'=>'viewdeal',$row->campaign_partner_mailinglist_id,$row->id],['class'=>'btn btn-default'])?>
									<?=$this->Html->link('Edit',['controller'=>'CampaignPartnerMailinglists','action'=>'editdeal',$row->campaign_partner_mailinglist_id,$row->id],['class'=>'btn btn-default'])?>
								</div>
							
							</div>
							
						</div> <!--row-->
						
						
				<div class="row inner visible-xs">
				
					<div class="col-xs-12 text-center">
						
						<a data-toggle="collapse" data-parent="#accordion" href="#basic-<?=$j?>">
							
							<h3><?= $j.' - ' ?><?= $row['partner_manager']['user']->first_name.' '.$row['partner_manager']['user']->last_name ?><?php if($j == 1){ echo ' <i class="fa fa-trophy"></i>'; } ?></h3>
							
						</a>
						
					</div> <!-- /.col -->
				
					<div id="basic-<?=$j?>" class="col-xs-12 panel-collapse collapse">
				
						<div class="row inner">
						
						  <div class="col-xs-6">
								<?='Company name'?>
						  </div>
						  
						  <div class="col-xs-6">
								<?= $row['partner_manager']['partner']->company_name ?>
						  </div>
						  
						  <div class="col-xs-6">
								<?='Deal value'?>
						  </div>
						  
				      <div class="col-xs-6">
								<?=$this->Number->currency($row->deal_value, $my_currency);?>
					    </div>
					    
						  <div class="col-xs-6">
								<?='Deal status'?>
						  </div>
						  
				      <div class="col-xs-6">
						    <?php
							    if($row->status == 'Y') {
									  echo ('<i class="fa fa-gavel"></i>'.' '.__('Closed'));
									} else {
									  echo ('<i class="fa fa-bookmark"></i>'.' '.__('Registered'));
									}
									?>
					    </div>
				      
						</div>
						
						<div class="row inner">
							
							<div class="col-xs-12">
							
								<div class="btn-group pull-right">
									<?= $this->Html->link('View',['controller'=>'CampaignPartnerMailinglists','action'=>'viewdeal',$campaignPartnerMailinglist->id,$row->id],['class'=>'btn btn-default'])?>
									<?=$this->Html->link('Edit',['controller'=>'CampaignPartnerMailinglists','action'=>'editdeal',$campaignPartnerMailinglist->id,$row->id],['class'=>'btn btn-default'])?>
								</div>
								
							</div>
							
						</div>
								
					</div> <!--collapseOne-->
							
				</div> <!--row-->
				
				
				<?php
					
					endforeach;
				
				?>
					
				</div>
					
				<?php
					
					} else {
					
				?>
					
					<div class="row inner withtop">
						
					  <div class="col-xs-12 text-center">
							<?= __('No deals have yet been registered for this campaign') ?>
					  </div>
						  
					</div>
						  
				<?php
					
				}
				
				?>
				
				<!-- End loop -->
				
				<?php 
				$this->Paginator->options(['url'=>['action'=>'listdeals']]);
				echo $this->element('paginator'); 
				?>
