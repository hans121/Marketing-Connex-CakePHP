		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				&copy; <?= date('Y').' ' ?> <?= $this->Html->link(__('Panovus'), 'http://panovus.com/', ['target' => '_blank', 'escape' => false] ) ?><?=__('. All Rights Reserved')?>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				<?= $this->Html->link(__('Privacy'), ['controller' => 'Pages', 'action' => 'privacy'],['title'=>'Privacy & Cookies']); ?> | <?= $this->Html->link(__('T & Cs'), ['controller' => 'Pages', 'action' => 'conditions'],['title'=>'Terms & Conditions']); ?> | <?= $this->Html->link(__('Terms of Use'), ['controller' => 'Pages', 'action' => 'terms'],['title'=>'Terms of Use']); ?>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-right">
				<a href="https://www.linkedin.com/company/marketingconnex" target="_blank"><i class="fa fa-linkedin fa-2x olive"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="https://twitter.com/marketingconnex" target="_blank"><i class="fa fa-twitter fa-2x claret"></i></a>&nbsp;&nbsp;
				<a href="https://www.facebook.com/pages/MarketingConnex/362839223900115" target="_blank"><i class="fa fa-facebook fa-2x cyan"></i></a>
			</div>
			
		</div> <!--row-->
