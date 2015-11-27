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
<button type="button" class="close pull-right" data-toggle="collapse" data-target="#collapseRegisteredPartners"><i class="icon icon--small ion-minus-circled"></i></button>

					<div class="row">
						<div class="col-xs-12 col-md-6">
							<div class="card--icon">
								<div class="bubble">
								<i class="icon ion-person-stalker"></i></div>
							</div>
							<div class="card--info">
								<h2 class="card--title"><?= __('Registered partners'); ?></h2>
								<h3 class="card--subtitle">Breakdown of all of your partners</h3>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="card--actions">
								<?= $this->Html->link(__('View all'), ['controller' => 'Vendors','action' => 'Partners'], ['class' => 'btn btn-primary pull-right']); ?>
							</div>
						</div>
					</div>   
				</div>
				                                                                <div class="collapse in" id="collapseRegisteredPartners">

				<div class="card-content">
					
					<div class="row">
						<div class="col-md-12">
							<p>See below the details of your partners, showcasing the number of campaigns they have completed, revenue figures and ROI.
							</p>
							<hr>
						</div>
					</div>
				
					<!-- content below this line -->

					<div class="row charts">

						<div class="col-xs-12">



							<!-- Are there any campaigns? -->
							<?php
							if(count($partners_registered)>0)
							{
								?>

								<div class="row table-th hidden-xs">

									<div class="clearfix"></div>

									<div class="col-md-2 col-sm-3">
										<?= __('Partner') ?>
									</div>

									<div class="col-md-1 hidden-sm text-right">
										<?= __('Campaigns Completed') ?>
									</div>

									<div class="col-md-1 col-sm-1 text-right">
										<?= __('Deals closed') ?>
									</div>

									<div class="col-md-2 col-sm-3 text-right">
										<?= __('Total value of closed deals') ?>
									</div>

									<div class="col-md-1 col-sm-3 text-right">
										<?= __('ROI') ?>
									</div>

									<div class="col-md-1 hidden-sm text-right">
										<?= __('Campaigns Active') ?>
									</div>

									<div class="col-md-2 hidden-sm text-right">
										<?= __('Est. Revenue') ?>
									</div>

									<div class="col-md-12 col-sm-2">
									</div>

								</div> <!--/.row.table-th -->

								<!-- Start loop -->
								<?php
								$k =0;
								foreach ($partners_registered as $row):
									$k++;
								?>

								<div class="row inner hidden-xs">

									<div class="col-md-2 col-sm-3">
										<?= $row['partner_name'] ?>
									</div>

									<div class="col-md-1 hidden-sm text-right">
										<?= $row['campaigns_completed'] ?>
									</div>

									<div class="col-md-1 col-sm-1 text-right">
										<?= $row['deals_count'] ?>
									</div>

									<div class="col-md-2 col-sm-3 text-right">
										<?= $this->Number->currency(round($row['deals_value']),$my_currency,['places'=>0]);?>
									</div>

									<div class="col-md-1 col-sm-3 text-right">
										<?= $this->Number->currency(round($row['roi']),$my_currency,['places'=>0]);?>
									</div>

									<div class="col-md-1 hidden-sm text-right">
										<?= $row['campaigns_active'] ?>
									</div>

									<div class="col-md-2 hidden-sm text-right">
										<?= $this->Number->currency(round($row['expected_revenue']),$my_currency,['places'=>0]);?>
									</div>

									<div class="col-md-2 col-sm-2">

										<div class="btn-group pull-right">
											<?= $this->Html->link('Details',['controller'=>'Vendors','action'=>'viewPartner/'.$row['id']],['class'=>'btn btn-default'])?>
										</div>

									</div>

								</div> <!--/.row.inner-->

								<div class="row inner visible-xs"	>

									<div class="col-xs-12 text-center">

										<a data-toggle="collapse" data-parent="#accordion" href="#basic3-<?= $k ?>">
											<h3><?= $row['partner_name'] ?></h3>
										</a>

									</div> <!-- /.col -->

									<div class="col-xs-12 panel-collapse collapse" id="basic3-<?= $k ?>">

										<div class="row inner">

											<div class="col-xs-7">
												<?= __('Campaigns Completed') ?>
											</div>
											<div class="col-xs-5">
												<?= $row['campaigns_completed'] ?>
											</div>

											<div class="col-xs-7">
												<?= __('Campaigns Active') ?>
											</div>
											<div class="col-xs-5">
												<?= $row['campaigns_active'] ?>
											</div>

											<div class="col-xs-7">
												<?= __('Deals closed') ?>
											</div>
											<div class="col-xs-5">
												<?= $row['deals_count'] ?>
											</div>

											<div class="col-xs-7">
												<?= __('Total value of closed deals') ?>
											</div>
											<div class="col-xs-5">
												<?= $this->Number->currency(round($row['deals_value']),$my_currency,['places'=>0]);?>
											</div>

											<div class="col-xs-7">
												<?= __('ROI') ?>
											</div>
											<div class="col-xs-5">
												<?= $this->Number->currency(round($row['roi']),$my_currency,['places'=>0]);?>
											</div>

											<div class="col-xs-7">
												<?= __('Predicted Revenue') ?>
											</div>
											<div class="col-xs-5">
												<?= $this->Number->currency(round($row['expected_revenue']),$my_currency,['places'=>0]);?>
											</div>

											<div class="col-xs-12">

												<div class="btn-group pull-right">
													<?= $this->Html->link('Details',['controller'=>'Vendors','action'=>'viewPartner/5'],['class'=>'btn btn-default'])?>
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
										<?=	 __('No partners found') ?>
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


