<!-- Google Maps API -->
<?php echo $this->Html->script('https://maps.googleapis.com/maps/api/js?key=AIzaSyBlNRHavddm2klM2rvZG0_TPOChIFY4Vrg');?>
<?= $this->fetch('script');?>


<?php
	$admn = $this->Session->read('Auth');
	$my_currency = $admn['User']['currency'];
?>

<script type="text/javascript">
	
	function initialize() {
	  
		var map;
		var elevator;
		var myOptions = {
		    zoom: 1,
		    scrollwheel: false,
		    center: new google.maps.LatLng(0, 0),
		    mapTypeId: 'terrain',
		    styles: [{"elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"color":"#f5f5f2"},{"visibility":"on"}]},{"featureType":"administrative","stylers":[{"visibility":"off"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"poi.attraction","stylers":[{"visibility":"off"}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"off"}]},{"featureType":"poi.medical","stylers":[{"visibility":"off"}]},{"featureType":"poi.place_of_worship","stylers":[{"visibility":"off"}]},{"featureType":"poi.school","stylers":[{"visibility":"off"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#ffffff"},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"visibility":"simplified"},{"color":"#ffffff"}]},{"featureType":"road.highway","elementType":"labels.icon","stylers":[{"color":"#ffffff"},{"visibility":"off"}]},{"featureType":"road.highway","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","stylers":[{"color":"#ffffff"}]},{"featureType":"poi.park","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"color":"#71c8d4"}]},{"featureType":"landscape","stylers":[{"color":"#e5e8e7"}]},{"featureType":"poi.park","stylers":[{"color":"#8ba129"}]},{"featureType":"road","stylers":[{"color":"#ffffff"}]},{"featureType":"poi.sports_complex","elementType":"geometry","stylers":[{"color":"#c7c7c7"},{"visibility":"off"}]},{"featureType":"water","stylers":[{"color":"#a0d3d3"}]},{"featureType":"poi.park","stylers":[{"color":"#91b65d"}]},{"featureType":"poi.park","stylers":[{"gamma":1.51}]},{"featureType":"road.local","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"poi.government","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"landscape","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"road.local","stylers":[{"visibility":"simplified"}]},{"featureType":"road"},{"featureType":"road"},{},{"featureType":"road.highway"}]
		};
		map = new google.maps.Map($('#vendor-map')[0], myOptions);
	
		<?php 
	    	$addresses = '';
	    	foreach($vendors_locations as $row)
	    		$addresses[] = array('country'=>$row['country'],'state'=>$row['state'],'count'=>$row['vendorscnt']);
	    	$addresses = json_encode($addresses);
		?>
		var addresses = <?=$addresses?>;
		for (var x=0; x < addresses.length; x++)
			setmarker(map,addresses[x]);
	}
	
	function setmarker(map,address) {
		$.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address='+escape(address['state']+', '+address['country'])+'&sensor=false', null, function (data) {
			var p = data.results[0].geometry.location;
			var latlng = new google.maps.LatLng(p.lat, p.lng);
			new google.maps.Marker ({
				position: latlng,
				map: map,
				icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+address['count']+'|FFA32F|000000',
				title: address['state'] + ', ' + address['country'],
			});
		});	
	}
	
  google.maps.event.addDomListener(window, 'load', initialize);
  
</script>


<div class="index row table-title admin-table-title">
			
	<div class="vendor-sub-menu clearfix">
	
		<h2 class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<?= __('Dashboard'); ?>
		</h2>
				
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<div class="btn-group pull-right">
				<?= $this->Html->link(__('Export data').' <i class="fa fa-share-square-o"></i>', ['action' => 'export'], ['escape' => false, 'title' => 'Export dashboard data', 'class'=>'pull-right btn btn-lg']); ?>
			</div>
		</div>
	
	</div> <!-- /.row.table-title -->

</div>



<div class="row dashboard">
	
	<div class="col-sm-12">
			
      <div class="row">
        
				<div class="col-md-3 col-sm-3 col-sm-offset-0 col-xs-8 col-xs-offset-2">
  				
          <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
						
					<div class="row">
						
						<div class="col-sm-12">
							<h4 class="text-center"><?= __('No. of vendors by Subscription Package').' '; ?></h4>
							<div class="canvas-holder">
								<canvas id="chart-area" width="500" height="500"></canvas>
							</div>
						</div>
												
					</div> <!-- /.row -->
					
				</div> <!-- /.col -->
				
				<div class="col-md-8 col-md-offset-1 col-sm-8 col-sm-offset-1 col-xs-12">
						
						<div class="row table-title">
					
							<dt class="col-xs-12">
								<h4><?= __('Expiring vendor subscriptions (next 90 days)').' '; ?><small><?= $this->Html->link(__('See all subscribers'), ['controller' => 'Admins', 'action' => 'vendors']); ?></small></h4>
							</dt>
							
						</div> <!--/.row.table-title-->
						
						<!-- Are there any campaigns? -->
						<?php
							if($vendors_expiring->count()>0)
							{
						?>
						
						<div class="row table-th hidden-xs">
							
							<div class="clearfix"></div>
								
							<div class="col-md-3 col-sm-4">
								<?= __('Vendor') ?>
							</div>
							
							<div class="col-md-3 hidden-sm">
								<?= __('Package') ?>
							</div>
							
							<div class="col-md-2 col-sm-3">
								<?= __('Monthly amount') ?>
							</div>
							
							<div class="col-sm-3">
								<?= __('Expiry date') ?>
							</div>
							
							<div class="col-sm-1">
							</div>
							
						</div> <!--/.row.table-th -->
						
						<!-- Start loop -->
						<?php
							$j =0;
							foreach ($vendors_expiring as $row):
							$j++;
						?>
						
							<div class="row inner hidden-xs">
							
								<dt class="col-md-3 col-sm-4">
									<?= $row->company_name ?>
								</dt>
								
								<dd class="col-md-3 hidden-sm">
									<?= $row->subscription_package->name ?>
								</dd>
								
								<dd class="col-md-2 col-sm-3">
									<?= $this->Number->currency(round($row->subscription_package->monthly_price),$my_currency,['places'=>0]) ?>
								</dd>
								
								<dd class="col-md-3 col-sm-4 small">
									<?= date('d/m/Y',strtotime($row->subscription_expiry_date)) ?>
								</dd>
								
								<dd class="col-md-1 col-sm-1">
							
									<div class="btn-group pull-right">
										<?= $this->Html->link('Details',['controller'=>'Admins','action'=>'ViewVendor',$row->id],['class'=>'btn'])?>
									</div>
								
								</dd>
								
							</div> <!--/.row.inner-->
							
							<div class="row inner visible-xs"	>
							
								<div class="col-xs-12 text-center">
										
									<a data-toggle="collapse" data-parent="#accordion" href="#campaign-<?= $j ?>">
										<h3><?= __('Expiring vendor subscriptions (next 90 days)').' '; ?></h3>
									</a>
									
								</div> <!-- /.col -->
								
								<div class="col-xs-12 panel-collapse collapse" id="campaign-<?= $j ?>">
							
									<div class="row inner">
									
									  <dt class="col-xs-6">
											<?= 'Vendor'?>
									  </dt>
									  	
									  <dd class="col-xs-6">
											<?= $row->company_name ?>
									  </dd>
									  
									  <dt class="col-xs-6">
											<?=	'Package' ?>
									  </dt>
									  
							      	  <dd class="col-xs-6">
											<?= $row->subscription_package->name ?>
								      </dd>

									  <dt class="col-xs-6">
											<?=	'Monthly amount' ?>
									  </dt>
									  
							      	  <dd class="col-xs-6">
											<?= $this->Number->currency(round($row->subscription_package->monthly_price),$my_currency,['places'=>0]) ?>
								      </dd>

									  <dt class="col-xs-6">
											<?=	'Expiry date' ?>
									  </dt>
									  
							      	  <dd class="col-xs-6">
											<?= date('m/d/Y',strtotime($row->subscription_expiry_date)) ?>
								      </dd>								      								      
								    											
										<dd class="col-xs-12">
									
											<div class="btn-group pull-right">
												<?= $this->Html->link('Details',['controller'=>'Admins','action'=>'ViewVendor',$row->id],['class'=>'btn'])?>
											</div>
											
										</dd>
										
									</div> <!--collapseOne-->
										
								</div> <!--row-->
							
							</div> <!-- /.row.inner -->
							
							<?php
									
							endforeach;
								
							} else {
									
							?>
								
							<div class="row inner withtop">
									
								<div class="col-sm-12 text-center">
									<?=	 __('No expiring vendors found') ?>
								</div>
								
							</div> <!--/.row.inner-->
							
							<?php
							
							}
							
							?>
							
							<!-- End loop -->
								
						</div> <!-- /.col -->
				
			</div> <!-- /.row -->
			
			
			
      <div class="row charts">
        
				<div class="col-xs-12">
						
						<div class="row table-title">
					
							<div class="col-xs-12">
								<h4><?= __('Subscription packages').' ' ?><small><?= $this->Html->link(__('See all'), ['controller' => 'SubscriptionPackages','action' => 'Index']); ?></small></h4>
							</div>
							
						</div> <!--/.row.table-title-->
						
						<!-- Are there any campaigns? -->
						<?php
							if($subscription_packages->count()>0)
							{
						?>
						
						<div class="row table-th hidden-xs">
							
							<div class="clearfix"></div>
								
							<div class="col-sm-2">
								<?= __('Title') ?>
							</div>
							
							<div class="col-sm-2 text-right">
								<?= __('Subscribers')?><br /><?=__('(all)') ?>
							</div>
							
							<div class="col-sm-2 text-right">
								<?= __('Annualised income')?><br /><?=__('(all)') ?>
							</div>

							<div class="col-sm-2 text-right">
								<?= __('Subscribers')?><br /><?=__('(new this month)') ?>
							</div>

							<div class="col-sm-2 text-right">
								<?= __('Annualised income')?><br /><?=__("(this month's new subscribers)") ?>
							</div>

							<div class="col-sm-2">
							</div>
							
						</div> <!--/.row.table-th -->
													
							<!-- Start loop -->
							<?php
									$j =0;
									foreach ($subscription_packages as $row):
									$j++;

									$subscribers_cnt = count($row->vendors);
									$annual_income = 0;
									$subscribers_cnt_currmonth = 0;
									$subscribers_curr_income = 0;
									foreach($row->vendors as $v) {
										// Get current income, annualised
										if($v->last_billed_date!='')
											if((date('Y',strtotime($v->subscription_expiry_date)) - date('Y',strtotime($v->last_billed_date))) >= 0)
												$annual_income += ($v->subscription_type=='monthly' ? $row->monthly_price*12 : $row->annual_price);

										// Get new subscription count and income, annualised
										if($v->last_billed_date!='')
											if((date('Y',strtotime($v->created_on)) == date('Y',strtotime($v->last_billed_date))) && date('Y',strtotime($v->last_billed_date)) == date('Y') && date('m',strtotime($v->last_billed_date)) == date('m')) {
												$subscribers_cnt_currmonth++;
												$subscribers_curr_income += ($v->subscription_type=='monthly' ? $row->monthly_price*12 : $row->annual_price);
											}
									}
							?>
							
								<div class="row inner hidden-xs">
								
									<dt class="col-sm-2">
										<?= $row->name ?>
									</dt>
									
									<dd class="col-sm-2 text-right">
										<?= $subscribers_cnt ?>
									</dd>
									
									<dd class="col-sm-2 text-right">
										<?= $this->Number->currency(round($annual_income),$my_currency,['places'=>0]) ?>
									</dd>
									
									<dd class="col-sm-2 text-right">
										<?= $subscribers_cnt_currmonth ?>
									</dd>
									
									<dd class="col-sm-2 text-right">
										<?= $this->Number->currency(round($subscribers_curr_income),$my_currency,['places'=>0]) ?>
									</ddd>
									
									<dd class="col-sm-2">
								
										<div class="btn-group pull-right">
											<?= $this->Html->link('Details',['controller'=>'SubscriptionPackages','action'=>'view',$row->id],['class'=>'btn'])?>
										</div>
									
									</dd>
									
								</div> <!--/.row.inner-->
								
								<div class="row inner visible-xs"	>
								
									<div class="col-xs-12 text-center">
											
										<a data-toggle="collapse" data-parent="#accordion" href="#subs-<?= $j ?>">
											<h3><?= $row->name ?></h3>
										</a>
										
									</div> <!-- /.col -->
									
									<div class="col-xs-12 panel-collapse collapse" id="subs-<?= $j ?>">
								
										<div class="row inner">
										
										  <dt class="col-xs-7">
												<?= 'Subscribers (all)'?>
										  </dt>
										  	
										  <dd class="col-xs-5">
												<?= $subscribers_cnt ?>
										  </dd>
										  
										  <dt class="col-xs-7">
												<?=	'Annualised income (all)' ?>
										  </dt>
										  
								          <dd class="col-xs-5">
												<?= $this->Number->currency(round($annual_income),$my_currency,['places'=>0]) ?>
									      </dd>
									    											
										  <dt class="col-xs-7">
												<?=	'Subscribers (new this month)' ?>
										  </dt>
										  
								          <dd class="col-xs-5">
												<?= $subscribers_cnt_currmonth ?>
									      </dd>

										  <dt class="col-xs-7">
												<?=	"Annualised income (this month's new subscribers)" ?>
										  </dt>
										  
								          <dd class="col-xs-5">
												<?= $this->Number->currency(round($subscribers_curr_income),$my_currency,['places'=>0]) ?>
									      </dd>									      
									    											
											<dd class="col-xs-12">
										
												<div class="btn-group pull-right">
													<?= $this->Html->link('Details',['controller'=>'SubscriptionPackages','action'=>'view',$row->id],['class'=>'btn'])?>
												</div>
												
											</dd>
											
										</div> <!--collapseOne-->
											
									</div> <!--row-->
								
								</div> <!-- /.row.inner -->
								
								<?php
										
										endforeach;
									
									} else {
										
								?>
									
								<div class="row inner withtop">
										
									<div class="col-sm-12 text-center">
										<?=	 __('No subscription packages found') ?>
									</div>
									
								</div> <!--/.row.inner-->
								
								<?php
								
									}
								
								?>
								
								<!-- End loop -->
								
						</div> <!-- /.col -->
			
			</div> <!-- /.row -->



      <div class="row charts">
        
				<div class="col-xs-12">
						
						<div class="row table-title">
					
							<div class="col-xs-12">
								<h4><?= __('Vendor locations').' ' ?><small><?= $this->Html->link(__('See all'), ['controller' => 'Admins','action' => 'Vendors']); ?></small></h4>
							</div>
							
						</div> <!--/.row.table-title-->
			
						<div class="row">
							
							<div class="col-xs-12">
								<div id="vendor-map" class="map-canvas"></div>
							</div>
							
						</div>
						
						<div class="row table-th hidden-xs">
							
							<div class="clearfix"></div>
								
							<div class="col-md-2 col-sm-2">
								<?= __('Country') ?>
							</div>
							
							<div class="col-md-2 col-sm-2">
								<?= __('County/State') ?>
							</div>
							
							<div class="col-md-1 col-sm-1 text-right">
								<?= __('Vendors') ?>
							</div>
							
							<div class="col-md-1 col-sm-1 text-right">
								<?= __('Campaigns') ?>
							</div>
							
							<div class="col-md-2 col-sm-2 text-right">
								<?= __('Closed deals') ?>
							</div>
									
							<div class="col-md-2 col-sm-2 text-right">
								<?= __('Annualised Revenue') ?><!-- This is the total of the annual subscription payments, for vendors based in each county/state -->
							</div>
									
							<div class="col-md-2 col-sm-2">
							</div>
							
						</div> <!--/.row.table-th -->
													

							<!-- Are there any campaigns? -->
							<?php
								if(count($vendors_locations)>0)
								{
							?>
							

							<!-- Start loop -->
							<?php
								$j =0;
						  		foreach ($vendors_locations as $row):
						  		$j++;
							?>
							
								<div class="row inner hidden-xs">
								

									<dt class="col-sm-2">
										<?= $row['country'] ?>
									</dt>
									
									<dd class="col-sm-2">
										<?= $row['state'] ?>
									</dd>
									
									<dd class="col-sm-1 text-right">
										<?= $row['vendorscnt'] ?>
									</dd>
									
									<dd class="col-sm-1 text-right">
										<?= $row['campaignscnt'] ?>
									</dd>
									
									<dd class="col-sm-2 text-right">
										<?= $this->Number->currency(round($row['deals_value']),$my_currency,['places'=>0]) ?>
									</dd>
									
									<dd class="col-sm-2 text-right">
										<?= $this->Number->currency(round($row['annualised_revenue']),$my_currency,['places'=>0]) ?>

									</dd>

									<dd class="col-md-2 col-sm-2">
								
										<div class="btn-group pull-right">
											<?= $this->Html->link('Details',['controller'=>'Admins','action'=>'vendorsbyterritory',$row['country'],$row['state']],['class'=>'btn'])?>
										</div>
									
									</dd>
									
								</div> <!--/.row.inner-->
								
								<div class="row inner visible-xs"	>
								
									<div class="col-xs-12 text-center">
											
										<a data-toggle="collapse" data-parent="#accordion" href="#map-<?= $j ?>">
											<h3><?= $row['state'] ?>, <?= $row['country'] ?></h3>
										</a>
										
									</div> <!-- /.col -->
									
									<div class="col-xs-12 panel-collapse collapse" id="map-<?= $j ?>">
								
										<div class="row inner">
										
										 	<dt class="col-xs-6">
												<?= __('Country') ?>
										  </dt>
										  	
										  <dd class="col-xs-6">
												<?= $row['country'] ?>
										  </dd>
										  
										  <dt class="col-xs-6">
												<?= __('County/State') ?>
										  </dt>
										  
								      <dd class="col-xs-6">
												<?= $row['state'] ?>
									    </dd>
									    											
										  <dt class="col-xs-6">
												<?= __('Vendors') ?>
										  </dt>
										  
								      <dd class="col-xs-6">
												<?= $row['vendorscnt'] ?>
									    </dd>
									    											
										<dt class="col-xs-6">
											<?= __('Campaigns') ?>
										</dt>
										  
										<dd class="col-xs-6">
											<?= $row['campaignscnt'] ?>
										</dd>

										<dt class="col-xs-6">
											<?= __('Closed deals') ?>
										</dt>
										  
										<dd class="col-xs-6">
											<?= $this->Number->currency(round($row['deals_value']),$my_currency,['places'=>0]) ?>
										</dd>

										<dt class="col-xs-6">
											<?= __('Annualised Revenue') ?>
										</dt>
										  
										<dd class="col-xs-6">
											<?= $this->Number->currency(round($row['annualised_revenue']),$my_currency,['places'=>0]) ?>
										</dd>									    
									    											
										<dd class="col-xs-12">
										
												<div class="btn-group pull-right">
													<?= $this->Html->link('Details',['controller'=>'Admins','action'=>'vendorsbyterritory',$row['country'],$row['state']],['class'=>'btn'])?>
												</div>
												
											</dd>
											
										</div> <!--collapseOne-->
											
									</div> <!--row-->
								
								</div> <!-- /.row.inner -->
								
								<?php
										
										endforeach;
									
									} else {
										
								?>
									
								<div class="row inner withtop">
										
									<div class="col-sm-12 text-center">
										<?=	 __('No vendors found') ?>
									</div>
									
								</div> <!--/.row.inner-->
								
								<?php
								
									}
								
								?>
								
								<!-- End loop -->
								
						</div> <!-- /.col -->
			
			</div> <!-- /.row -->



      <div class="row charts">
					
				<div class="col-sm-6 col-xs-12">
						
						<div class="row table-title">
					
							<div class="col-xs-12">
								<h4><?= __('Campaigns').' '; ?></h4>
							</div>
							
						</div> <!--/.row.table-title-->
						
						<div class="row table-th hidden-xs">
							
							<div class="clearfix"></div>
								
							<div class="col-sm-3">
								<?= __('Financial year') ?>
							</div>
							
							<div class="col-sm-3 text-right">
								<?= __('No. Campaigns') ?>
							</div>
							
							<div class="col-sm-3 text-right">
								<?= __('Closed deals') ?>
							</div>
							
							<div class="col-sm-3">
							</div>
							
						</div> <!--/.row.table-th -->
						
						
							<div class="row inner hidden-xs">
							
								<dt class="col-sm-3">
									<?= 'Current' ?>
								</dt>
								
								<dd class="col-sm-3 text-right">
									<?= $fyear_current['campaigns'] ?>
								</dd>
								
								<dd class="col-sm-3 text-right">
									<?= $this->Number->currency(round($fyear_current['deals']),$my_currency,['places'=>0]) ?>
								</dd>

								<dd class="col-sm-3">
							
									<!-- <div class="btn-group pull-right">
										<?= $this->Html->link('Details',['controller'=>'Admins'],['class'=>'btn'])?>
									</div> -->
								
								</dd>
								
							</div> <!--/.row.inner-->

							<div class="row inner hidden-xs">
							
								<dt class="col-sm-3">
									<?= 'Previous' ?>
								</dt>
								
								<dd class="col-sm-3 text-right">
									<?= $fyear_last['campaigns'] ?>
								</dd>
								
								<dd class="col-sm-3 text-right">
									<?= $this->Number->currency(round($fyear_last['deals']),$my_currency,['places'=>0]) ?>
								</dd>

								<dd class="col-sm-3">
							
									<!-- <div class="btn-group pull-right">
										<?= $this->Html->link('Details',['controller'=>'Admins'],['class'=>'btn'])?>
									</div> -->
								
								</dd>
								
							</div> <!--/.row.inner-->
							
							<div class="row inner visible-xs"	>
							
								<div class="col-xs-12 text-center">
										
									<a data-toggle="collapse" data-parent="#accordion" href="#campaigns-1">
										<h3><?= 'Current financial year' ?></h3>
									</a>
									
								</div> <!-- /.col -->
								
								<div class="col-xs-12 panel-collapse collapse" id="campaigns-1">
							
									<div class="row inner">
									
									 	<dt class="col-xs-6">
											<?= 'No. Campaigns'?>
									  </dt>
									  	
									  <dd class="col-xs-6">
											<?= $fyear_current['campaigns'] ?>
									  </dd>
									  
									  <dt class="col-xs-6">
											<?=	'Closed deals' ?>
									  </dt>
									  
							      <dd class="col-xs-6">
											<?= $this->Number->currency(round($fyear_current['deals']),$my_currency,['places'=>0]) ?>
								    </dd>
								    											
										<dd class="col-xs-12">
									
											<!-- <div class="btn-group pull-right">
												<?= $this->Html->link('Details',['controller'=>'Admins'],['class'=>'btn'])?>
											</div> -->
											
										</dd>
										
									</div> <!--collapseOne-->
										
								</div> <!--row-->
							
							</div> <!-- /.row.inner -->

							<div class="row inner visible-xs"	>
							
								<div class="col-xs-12 text-center">
										
									<a data-toggle="collapse" data-parent="#accordion" href="#campaigns-2">
										<h3><?= 'Previous financial year' ?></h3>
									</a>
									
								</div> <!-- /.col -->
								
								<div class="col-xs-12 panel-collapse collapse" id="campaigns-2">
							
									<div class="row inner">
									
									 	<dt class="col-xs-6">
											<?= 'No. Campaigns'?>
									  </dt>
									  	
									  <dd class="col-xs-6">
											<?= $fyear_last['campaigns'] ?>
									  </dd>
									  
									  <dt class="col-xs-6">
											<?=	'Closed deals' ?>
									  </dt>
									  
							      <dd class="col-xs-6">
											<?= $this->Number->currency(round($fyear_last['deals']),$my_currency,['places'=>0]) ?>
								    </dd>
								    											
										<!--<dd class="col-xs-12">
									
											<div class="btn-group pull-right">
												<?= $this->Html->link('Details',['controller'=>'Admins'],['class'=>'btn'])?>
											</div>
											
										</dd>-->
										
									</div> <!--collapseOne-->
										
								</div> <!--row-->
							
							</div> <!-- /.row.inner -->
							
						</div> <!-- /.col -->
			

					<div class="col-sm-6 col-xs-12">
						
						<div class="row table-title">
					
							<div class="col-xs-12">
								<h4><?= __('Income, by country').' '; ?></h4>
							</div>
							
						</div> <!--/.row.table-title-->
						
						<div class="row table-th hidden-xs">
							
							<div class="clearfix"></div>
								
							<div class="col-sm-5">
								<?= __('Country') ?>
							</div>
							
							<div class="col-sm-4 text-right">
								<?= __('Income (all packages)') ?><!-- Total of all subscription payments received - annualised -->
							</div>
							
							<div class="col-sm-3">
							</div>
							
						</div> <!--/.row.table-th -->
						
						<!-- Are there any campaigns? -->
						<?php
							if(count($profit_bycountry)>0)
							{
						?>
						
						<!-- Start loop -->
						<?php
								$j =0;
							  	foreach ($profit_bycountry as $row):
							  	$j++;
						?>
						
							<div class="row inner hidden-xs">
							
								<dt class="col-sm-5">
									<?= $row['country'] ?>
								</dt>
								
								<dd class="col-sm-4 text-right">
									<?= $this->Number->currency(round($row['profit']),$my_currency,['places'=>0]) ?>
								</dd>
								
								<dd class="col-sm-3">
							
									<div class="btn-group pull-right">
										<?= $this->Html->link('Details',['controller'=>'Admins','action'=>'vendorsbyterritory', $row['country']],['class'=>'btn'])?>
									</div>
								
								</dd>
								
							</div> <!--/.row.inner-->
							
							<div class="row inner visible-xs"	>
							
								<div class="col-xs-12 text-center">
										
									<a data-toggle="collapse" data-parent="#accordion" href="#profit-<?= $j ?>">
										<h3><?= $row['country'] ?></h3>
									</a>
									
								</div> <!-- /.col -->
								
								<div class="col-xs-12 panel-collapse collapse" id="profit-<?= $j ?>">
							
									<div class="row inner">
																		  
									  <dt class="col-xs-6">
											<?=	'Income (all packages)' ?>
									  </dt>
									  
								      <dd class="col-xs-6">
											<?= $this->Number->currency(round($row['profit']),$my_currency,['places'=>0]) ?>
									  </dd>
								    											
										<dd class="col-xs-12">
									
											<div class="btn-group pull-right">
												<?= $this->Html->link('Details',['controller'=>'Admins','action'=>'vendorsbyterritory',$row['country']],['class'=>'btn'])?>
											</div>
											
										</dd>
										
									</div> <!--collapseOne-->
										
								</div> <!--row-->
							
							</div> <!-- /.row.inner -->
							
							<?php
									
								endforeach;
								
									} else {
									
							?>
								
							<div class="row inner withtop">
									
								<div class="col-sm-12 text-center">
									<?=	 __('No data found') ?>
								</div>
								
							</div> <!--/.row.inner-->
							
							<?php
							
							}
							
							?>
							
							<!-- End loop -->
								
						</div> <!-- /.col -->
			
			</div> <!-- /.row -->

	</div> <!-- /.col -->

</div> <!-- /.row.dashboard -->
	




  
<!-- Initialize Charts.js -->
<script>
/*!	
 * Chart.js
 * http://chartjs.org/
 * Version: 1.0.1-beta.4
 *
 * Copyright 2014 Nick Downie
 * Released under the MIT license
 * https://github.com/nnnick/Chart.js/blob/master/LICENSE.md
 */
 
/* Campaigns */
	var CampaignStatus = [
	<?php
	$p_colors = ['#AD0061','#46BFBD','#ED8D20','#867C04'];
	$h_colors = ['#C04668','#5AD3D1','#FFAD00','#969B1E'];
	$i = 0;
	$v_bcnt = 0;
	if($vendors_bypackage->count()>0)
		foreach($vendors_bypackage as $vb):
			$v_cnt = 0;
		
			foreach($vb->vendors as $v)
				if($vb->status=='A')
					$v_cnt++;
				else
					$v_bcnt++;

			if($vb->status=='A'):
	?>
		{
			value: <?=$v_cnt?>,
			color:"<?=$p_colors[$i]?>",
			highlight: "<?=$h_colors[$i]?>",
			label: "<?=$vb->name?>"
		},
	<?php 
				$i++;
			endif;
		endforeach;
	?>
		{
			value: <?=$v_bcnt?>,
			color: "#5E5901",
			highlight: "#797300",
			label: "Bespoke packages" // this is an aggregate ttal of vendors who have signed up for any other packages i.e. not one of the 4 shown on the pricing and plans frontend page
		}
	];
	var helpers = Chart.helpers;
	var ctx = document.getElementById("chart-area").getContext("2d");
	var CampaignDoughnut = new Chart(ctx).Doughnut(CampaignStatus, {
		responsive : true,
		animateScale : true,
		segmentStrokeColor : "#fff",
		segmentStrokeWidth : 2,
		tooltipTemplate : "<%if (label){%><%=label%>: <%}%><%= value %>",
		tooltipTitleFontFamily : "'Roboto', sans-serif",
		tooltipTitleFontSize : 9,
		legendTemplate : "<div class=\"col-sm-12\"><ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%> (<%=segments[i].value%>)</li><%}%></ul></div>"
		}
	);

var legendHolder = document.createElement('div');
legendHolder.innerHTML = CampaignDoughnut.generateLegend();

// Include a html legend template after the module doughnut itself
helpers.each(legendHolder.firstChild.childNodes, function (legendNode, index) {
  helpers.addEvent(legendNode, 'mouseover', function () {
    var activeSegment = CampaignDoughnut.segments[index];
    activeSegment.save();
    CampaignDoughnut.showTooltip([activeSegment]);
    activeSegment.restore();
  });
});
helpers.addEvent(legendHolder.firstChild, 'mouseout', function () {
    CampaignDoughnut.draw();
});

CampaignDoughnut.chart.canvas.parentNode.parentNode.appendChild(legendHolder.firstChild);

/*Number of deals*/

var funding = {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [
        {
            label: "Funding approved",
            fillColor: "rgba(253,180,92,1)",
            highlightFill: "rgba(253,180,92,0.8)",
            data: [65, 59, 80, 81, 56, 55, 40]
        },
        {
            label: "Funding approved (last financial year)",
            fillColor: "rgba(151,187,205,0.3)",
            highlightFill: "rgba(151,187,205,0.5)",
            data: [44, 49, 60, 91, 65, 65, 50]
        }
    ]
};
	var helpers = Chart.helpers;
	var ctx = document.getElementById("chart-area-funding").getContext("2d");
	var FundingChart = new Chart(ctx).Bar(funding, {
		responsive : true,
		scaleShowGridLines : false,
		barShowStroke : false,
		legendTemplate : "<div class=\"col-sm-12\"><ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%=segments[i].value%> <%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul></div>"
		}
	);

var legendHolder = document.createElement('div');
legendHolder.innerHTML = FundingChart.generateLegend();

// Include a html legend template after the module doughnut itself
helpers.each(legendHolder.firstChild.childNodes, function (legendNode, index) {
  helpers.addEvent(legendNode, 'mouseover', function () {
    var activeSegment = FundingChart.segments[index];
    activeSegment.save();
    FundingChartFundingChart.showTooltip([activeSegment]);
    activeSegment.restore();
  });
});
helpers.addEvent(legendHolder.firstChild, 'mouseout', function () {
    FundingChart.draw();
});

FundingChart.chart.canvas.parentNode.parentNode.appendChild(legendHolder.firstChild);		


/*Value of deals*/

	var DealVal = [
		{
			value: 70000,
			color:"#F7464A",
			highlight: "#FF5A5E",
			label: "Samsung home appliance Autumn 2014"
		},
		{
			value: 89000,
			color: "#46BFBD",
			highlight: "#5AD3D1",
			label: "Bosch domestic appliances Q3"
		},
		{
			value: 94000,
			color: "#FDB45C",
			highlight: "#FFC870",
			label: "Home appliance autumn drive"
		}
	];
	var helpers = Chart.helpers;
	var ctx = document.getElementById("chart-area-deal-value").getContext("2d");
	var DealValDoughnut = new Chart(ctx).Pie(DealVal, {
		responsive : true,
		animateScale : true,
		segmentStrokeColor : "#fff",
		segmentStrokeWidth : 2,
		tooltipTemplate : "<%if (label){%><%=label%>: <%}%><%= value %>",
		tooltipTitleFontFamily : "'Roboto', sans-serif",
		tooltipTitleFontSize : 9,
		legendTemplate : "<div class=\"col-sm-12\"><ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%=segments[i].value%> <%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul></div>"
		}
	);

var legendHolder = document.createElement('div');
legendHolder.innerHTML = DealValDoughnut.generateLegend();

// Include a html legend template after the module doughnut itself
helpers.each(legendHolder.firstChild.childNodes, function (legendNode, index) {
  helpers.addEvent(legendNode, 'mouseover', function () {
    var activeSegment = DealValDoughnut.segments[index];
    activeSegment.save();
    DealValDoughnut.showTooltip([activeSegment]);
    activeSegment.restore();
  });
});
helpers.addEvent(legendHolder.firstChild, 'mouseout', function () {
    DealValDoughnut.draw();
});

DealValDoughnut.chart.canvas.parentNode.parentNode.appendChild(legendHolder.firstChild);

</script>
