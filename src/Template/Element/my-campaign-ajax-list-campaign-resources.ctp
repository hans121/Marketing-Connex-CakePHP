<div class="col-sm-12">
	<div class="row table-title">

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<h2><?= __('Campaign resources'); ?></h2>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		</div>

	</div> <!--row-table-title-->


	<div class="row">

		<?php 
		$j=0;
		foreach ($campaigndetails->campaign_resources as $resrc): $j++;
		?>

			<div class="col-sm-6 resource-list clearfix">

				<div class="row inner withtop resource-inner clearfix">


					<div class="col-xs-3">
						<?= $this->Html->image('icon-generic-download.png',['alt'=>'File for download','class' => 'img-responsive'])?>
					</div>

					<div class="col-xs-9">

						<h5><?= h($resrc->title) ?></h5>

						<?php echo $this->Form->postLink(__('Download'), ['controller' => 'PartnerCampaigns', 'action' => 'downloadfile', $resrc->id],['class'=>'btn pull-left']);?>

					</div>


				</div>

			</div>	

	<?php endforeach; ?>

	</div> <!-- /.row -->
</div>