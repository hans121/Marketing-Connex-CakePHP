<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error;
use Cake\Utility\Debugger;
use Cake\Validation\Validation;

if (!Configure::read('debug')):
	//throw new Error\NotFoundException();
endif;
?>



<!--  Load ScrollReveal only on pages required, as clashes with some Bootstrap.js functions -->

<?php echo $this->Html->script('scrollReveal.js-master/scrollReveal.js');?>
<?= $this->fetch('script');?>



<div id="content" class="section-white-fade">
	<div class="container">
		
    <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
		<?= $this->fetch('content') ?>
		
		<div class="row">
			
			<div class="col-xs-12 text-center section-title">
				<h2><?= __('Why choose MarketingConneX for your channel marketing?'); ?></h2>
				<h3><?= __('A software foundation to turn your partners into profit'); ?></h3>
			</div>
			
		</div>
		
		<div class="row">
			<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
				
				<div class="row">

					<div class="col-md-4 col-md-offset-1 col-sm-10 col-sm-offset-1">
				
						<?= $this->Html->image('frontend/icon_thumbs.png',['title'=>'Vendor','alt'=>'Vendor','width'=>'80','height'=>'80','class'=>'img-responsive center-block'])?>
						<h4 class="text-center"><?= __('Get up and running quickly'); ?></h4>
						<p class="text-center"><?= __('Our user interface is easy to use so your partners can create, adapt, deliver and monitor marketing campaigns immediately.'); ?></p>
			
					</div>

					<div class="col-md-4 col-md-offset-2 col-sm-10 col-sm-offset-1">
				
						<?= $this->Html->image('frontend/icon_graph.png',['title'=>'Vendor','alt'=>'Vendor','width'=>'90','height'=>'80','class'=>'img-responsive center-block'])?>
						<h4 class="text-center"><?= __('Fixed pricing model'); ?></h4>
						<p class="text-center"><?= __('Bring more partners on board without worrying about additional costs - our fixed cost model lets you give access to the platform to all your partners at no extra charge!'); ?></p>
			
					</div>
			
				</div>
				
				<div class="row">
			
				</div>
				
			</div>
		</div>		
		
	</div> <!-- container(class)-->
</div>


<div id="content" class="section-white-fade">
	<div class="container">
		
		<div class="row">
			
			<div class="col-xs-12 text-center section-title">
				<h2><?= __('Turn partners into profit'); ?></h2>
				<h3><?= __('Give them the tools they need to grow your business'); ?></h3>
			</div>
			
		</div>
		

		<div class="row">

			<div class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2">
		
				<?= $this->Html->image('frontend/icon_earth.png',['title'=>'Vendor','alt'=>'Vendor','width'=>'80','height'=>'80','class'=>'img-responsive center-block'])?>
				<p class="text-center"><?= __('Support your partners’ lead generation and marketing activities globally and see your pipeline expand.'); ?></p>
	
			</div>
			
		</div>


		<div class="row">
			<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
				
				<div class="row spaced">

					<div class="col-md-4 col-md-offset-0 col-sm-8 col-sm-offset-2">
				
						<?= $this->Html->image('frontend/icon_agency.png',['title'=>'Vendor','alt'=>'Vendor','width'=>'120','height'=>'120','class'=>'img-responsive center-block'])?>
						<p class="text-center"><?= __('With traditional campaign development, an agency typically charges around $500 just to develop a marketing campaign template.'); ?></p>
			
					</div>

					<div class="col-md-4 col-md-offset-0 col-sm-8 col-sm-offset-2">
				
						<?= $this->Html->image('frontend/icon_partner_cost.png',['title'=>'Vendor','alt'=>'Vendor','width'=>'120','height'=>'120','class'=>'img-responsive center-block'])?>
						<p class="text-center"><?= __('Further, an integrated campaign using multiple elements (landing page, banner etc) could cost significantly more...'); ?></p>
			
					</div>
			
					<div class="col-md-4 col-md-offset-0 col-sm-8 col-sm-offset-2">
				
						<?= $this->Html->image('frontend/icon_partners_costs.png',['title'=>'Vendor','alt'=>'Vendor','width'=>'140','height'=>'120','class'=>'img-responsive center-block'])?>
						<p class="text-center"><?= __('Multiply those costs by the number of partners and the figure needed is much larger …and that’s just for one campaign!'); ?></p>
			
					</div>
			
				</div>
				
				<div class="row">
			
				</div>
				
			</div>
		</div>		
		
	</div> <!-- container(class)-->
</div>

<div class="jumbotron home-hero-area-bottom">
  <div class="container">
		<h3 class="text-center"><small><?= __('Introducing'); ?></small></h3>
		<?= $this->Html->image('frontend/logo-large.png',['title'=>'MarketingConneX logo','alt'=>'','width'=>'520','height'=>'110','class'=>'img-responsive center-block'])?>
		<h4 class="text-center"><?= __('the #1 Partner Channel Management platform'); ?></h4>
		
  </div>
</div>

<div id="content" class="section-white-fade">
	<div class="container">
		
		<div class="row">

			<div class="col-md-4 col-md-offset-1 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">

				<?= $this->Html->image('frontend/icon_partners.png',['title'=>'Vendor','alt'=>'Vendor','width'=>'160','height'=>'120','class'=>'img-responsive center-block'])?>
				<h4 class="text-center"><?= __('Enable your partners at no extra cost'); ?></h4>
				<p class="text-center"><?= __('With MarketingConneX, every partner has access to fully measurable, integrated marketing. And with our intuitive, multilingual channel software platform, we can help power pipeline growth. Not just for them, for you too!'); ?></p>
				<?= $this->Html->link(__('Features for partners'),['controller'=>'Pages', 'action'=>'home#partner-features'],['class' => 'btn btn-xl center-block hidden-lg hidden-md']);?>
	
			</div>

			<div class="col-md-4 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">
		
				<?= $this->Html->image('frontend/icon_vendor.png',['title'=>'Vendor','alt'=>'Vendor','width'=>'160','height'=>'120','class'=>'img-responsive center-block'])?>
				<h4 class="text-center"><?= __('It benefits you'); ?></h4>
				<p class="text-center"><?= __('MarketingConneX facilitates promotion of your products and services and helps protect your brand. At the same time, you can enjoy full visibility of Partner programmes and take control of your budgets while filling that all important pipeline.'); ?></p>
				<?= $this->Html->link(__('Features for vendors'),['controller'=>'Pages', 'action'=>'home#vendor-features'],['class' => 'btn btn-xl center-block hidden-lg hidden-md']);?>
	
			</div>
			
		</div>
			
		<div class="row">

			<div class="col-md-4 col-md-offset-1 col-sm-10 col-sm-offset-1">
		
				<?= $this->Html->link(__('Features for partners'),['controller' => 'pages', 'action' => 'home#partner-features'],['class' => 'btn btn-xl center-block hidden-sm hidden-xs']);?>
			
			</div>

			<div class="col-md-4 col-md-offset-2 col-sm-10 col-sm-offset-1">
		
				<?= $this->Html->link(__('Features for vendors'),['controller'=>'Pages', 'action'=>'home#vendor-features'],['class' => 'btn btn-xl center-block hidden-sm hidden-xs']);?>
	
			</div>
			
		</div>


		<div class="row">
			<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
				
				<div class="row spaced">

					<div class="col-md-3 col-md-offset-0 col-sm-8 col-sm-offset-2">
				
						<?= $this->Html->image('frontend/icon_thumbs-lg.png',['title'=> __("Super-intuitive user interface"),'alt'=>__("Super-intuitive user interface"),'width'=>'160','height'=>'120','class'=>'img-responsive center-block'])?>
						<h4 class="text-center"><?= __('Easy to use'); ?></p>
			
					</div>

					<div class="col-md-1 col-md-offset-0 col-sm-8 col-sm-offset-2">
				
						<?= $this->Html->image('frontend/icon_plus.png',['title'=> __("plus"),'alt'=> __("plus"),'width'=>'30','height'=>'120','class'=>'img-responsive center-block'])?>
			
					</div>

					<div class="col-md-4 col-md-offset-0 col-sm-8 col-sm-offset-2">
				
						<?= $this->Html->image('frontend/icon_zero.png',['title'=> __("zero cost"),'alt'=> __("zero cost"),'width'=>'160','height'=>'120','class'=>'img-responsive center-block'])?>
						<h4 class="text-center"><?= __('Fixed costs'); ?></h4>
			
					</div>
			
					<div class="col-md-1 col-md-offset-0 col-sm-8 col-sm-offset-2">
				
						<?= $this->Html->image('frontend/icon_equals.png',['title'=> __("equals"),'alt'=> __("equals"),'width'=>'30','height'=>'120','class'=>'img-responsive center-block'])?>
			
					</div>

					<div class="col-md-3 col-md-offset-0 col-sm-8 col-sm-offset-2">
				
						<?= $this->Html->image('frontend/icon_winner.png',['title'=> __("Empowered partners"),'alt'=> __("Empowered partners"),'width'=>'160','height'=>'120','class'=>'img-responsive center-block'])?>
						<h4 class="text-center"><?= __('High performance partners and faster ROI'); ?></h4>
			
					</div>
			
				</div>
				
				<div class="row">
			
				</div>
				
			</div>
		</div>		
		
	</div> <!-- container(class)-->
</div>

<div class="jumbotron home-hero-area-bottom">
  <div class="container">
		<h3 class="text-center"><?= __('Ready to turn your partners into profit?'); ?></h3>
		<h4 class="text-center"><?= __('with the #1 Partner Channel Management platform'); ?></h4>
		
		<div class="row">
			<div class="col-md-12 text-center cta-buttons">
				<?= $this->Html->link('Get started',['controller'=>'SubscriptionPackages','action'=>'packagelist/'.$row->id],['class'=>'btn btn-xl btn-xl-blue'])?>
				<?= $this->Html->link('Book a demo',['controller'=>'Contact','action'=>'index','request' => 'demo'],['class'=>'btn btn-xl btn-xl-white'])?>
			</div>
		</div>
		
  </div>
</div>
