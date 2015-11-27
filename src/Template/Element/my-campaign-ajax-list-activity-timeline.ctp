<div class="col-sm-12"><!-- Timeline -->
	<div class="well timeline">
		<h2 class="text-center">Activity timeline</h2>
		<div class="timelineLoader">
			<?= $this->Html->image('timeline/ajax-loader.gif')?>
		</div>
		<!-- BEGIN TIMELINE -->
		<div class="timelineFlat tl">
			<?php
				if(isset($allcampdeals)):
					foreach($allcampdeals as $dls):
			?>
						<div class="item" data-id="<?= date('d/m/Y',strtotime($dls->closure_date)) ?>" data-description="<?= $dls['partner_manager']['user']->full_name?>">

							<?php
							$email = $dls['partner_manager']['user']->email;
							$size = 50;
							$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default_avtar_url ) . "&s=".$size;
							?>

							<div class="gravatar">
								<?= $this->Html->image($grav_url,['class' => 'gravatar', 'width' => '50', 'height' => '50'])?>
							</div>

							<div class="deal-data">
								<h4><?= $dls['partner_manager']['user']->full_name?></h4>
								<p>
									<?=__('Deal ')?>
									<?php
									if($dls->status == 'Y') {
										echo (__('Closed').'&nbsp;<i class="fa fa-gavel"></i>');
									} else {
										echo (__('Registered').'&nbsp;<i class="fa fa-bookmark"></i>');
									}
									?>
								</p>
								<p><?= date('d/m/Y',strtotime($dls->closure_date)) ?></p>
								<h3><?=$this->Number->currency($dls->deal_value, $my_currency);?></h3>
								<a class="btn btn-default read_more" data-id="<?= date('d/m/Y',strtotime($dls->closure_date)) ?>"><?=__('View')?></a>
								<?=$this->Html->link('Edit',['controller'=>'CampaignPartnerMailinglists','action'=>'editdeal',$dls->campaign_partner_mailinglist_id,$dls->id],['class'=>'btn btn-default'])?>
							</div>

							</div>

							<div class="item_open" data-id="<?= date('d/m/Y',strtotime($dls->closure_date)) ?>">
								<p>
									<strong><?=__('Sale made to:').' '?></strong>
									<br />
									<?=$dls['campaign_partner_mailinglist']->first_name;?> <?=$dls['campaign_partner_mailinglist']->last_name;?>
									<br />
									<?='('?><?=$dls['campaign_partner_mailinglist']->email;?><?=')'?>
								</p>
								<p>
									<strong><?=__('Product sold:').' '?></strong>
									<br />
									<?=$dls->quantity_sold;?><?=' x '?><?=$dls->product_sold;?>
								</p>

							</div>

							<?php
							endforeach;
						endif;
						?>

		</div>
		<!-- /END TIMELINE -->

	</div>
</div><!-- end Timeline -->