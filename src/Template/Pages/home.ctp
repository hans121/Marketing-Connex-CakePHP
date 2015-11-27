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


<div class="jumbotron home-hero-area">
  <div class="container">
		<h1 class="text-center"><?= __('Turn your partners into profit'); ?></h1>
		<h2 class="text-center"><?= __('With the #1 Channel &amp; Partner Marketing platform'); ?></h2>
		<div class="row">
			<div class="col-md-6 col-sm-6 hidden-xs">
				<?= $this->Html->image('frontend/img_screens.png',['title'=>'Laptop displaying partner marketing diagram','alt'=>'Laptop displaying partner marketing diagram','width'=>'581','height'=>'274','class'=>'img-responsive computer-overlay center-block'])?>
			</div>
			<div class="col-md-6 col-sm-6 cta-buttons hidden-xs">
				<?= $this->Html->link('Get started',['controller'=>'SubscriptionPackages','action'=>'packagelist/'.$row->id],['class'=>'btn btn-xl btn-xl-blue'])?>
				<?= $this->Html->link('View benefits','#benefits',['class' => 'btn btn-xl btn-xl-white']);?>
			</div>
			<div class="col-sm-6 cta-buttons visible-xs text-center">
				<?= $this->Html->link('Get started',['controller'=>'SubscriptionPackages','action'=>'packagelist/'.$row->id],['class'=>'btn btn-xl btn-xl-blue'])?>
				<?= $this->Html->link('View benefits','#benefits',['class' => 'btn btn-xl btn-xl-white']);?>
			</div>
		</div>
  </div>
</div>

<div class="clearfix"></div>

<div id="content" class="section-white-fade">
	<div class="container">
		
    <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
		<?= $this->fetch('content') ?>
		
		<div class="row">
			
			<div class="col-xs-12 text-center section-title">
				<h2><?= __('What makes us different?'); ?></h2>
			</div>
			
		</div>
		
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				
				<div class="row usp" id="benefits">
			
					<div class="col-sm-6">
						<div class="row">
							<div data-sr="wait 0.5s and then enter left please, and hustle 250px" class="col-sm-3 col-sm-offset-1 col-xs-3 col-xs-offset-1">
								<?= $this->Html->image('frontend/img_usp-one-stop.png',['title'=>'The one-stop partner marketing solution','alt'=>'The one-stop partner marketing solution','width'=>'90','height'=>'90','class'=>'img-responsive'])?>
							</div>
							<div data-sr="wait 0.5s and then enter bottom please, and hustle 250px" class="col-sm-7 col-xs-7">
								<h3><?= __('The one-stop partner marketing solution'); ?></h3>
								<p><?= __('Partners can submit campaign plans for approval, deploy the programmes you build, and measure the effectiveness of the programmes through central dashboard reporting on both a vendor and partner level.'); ?></p>
							</div>
						</div>
					</div>
					
					<div class="col-sm-6">
						<div class="row">
							<div data-sr="wait 0.5s and then enter left please, and hustle 250px" class="col-sm-3 col-sm-offset-1 col-xs-3 col-xs-offset-1">
								<?= $this->Html->image('frontend/img_usp-app.png',['title'=>'Unique partner app available','alt'=>'Unique partner app available','width'=>'90','height'=>'90','class'=>'img-responsive'])?>
							</div>
							<div data-sr="wait 0.5s and then enter bottom please, and hustle 250px" class="col-sm-7 col-xs-7">
								<h3><?= __('Unique partner app available'); ?></h3>
								<p><?= __('Allowing you and your partners to monitor progress and record developments on the move.'); ?></p>
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="row usp">
		
					<div class="col-sm-6">
						<div class="row">
							<div data-sr="wait 0.5s and then enter left please, and hustle 250px" class="col-sm-3 col-sm-offset-1 col-xs-3 col-xs-offset-1">
								<?= $this->Html->image('frontend/img_usp-multicurrency.png',['title'=>'Multi-currency support','alt'=>'Multi-currency support','width'=>'90','height'=>'90','class'=>'img-responsive'])?>
							</div>
							<div data-sr="wait 0.5s and then enter bottom please, and hustle 250px" class="col-sm-8 col-xs-8">
								<h3><?= __('Multi-currency support'); ?></h3>
								<p><?= __('Whether you and your partners work in pounds, dollars or yen, you can track and report in your chosen currency against MDF allocation and spend.'); ?></p>
							</div>
						</div>
					</div>
					
					<div class="col-sm-6">
						<div class="row">
							<div data-sr="wait 0.5s and then enter left please, and hustle 250px" class="col-sm-3 col-sm-offset-1 col-xs-3 col-xs-offset-1">
								<?= $this->Html->image('frontend/img_usp-multilingual.png',['title'=>'Multi-lingual capabilities','alt'=>'Multi-lingual capabilities','width'=>'90','height'=>'90','class'=>'img-responsive'])?>
							</div>
							<div data-sr="wait 0.5s and then enter bottom please, and hustle 250px" class="col-sm-8 col-xs-8">
								<h3><?= __('Multi-lingual capabilities'); ?></h3>
								<p><?= __('Upon setup you can choose the native language for the platform, allowing you and your partners to operate in the same business language. '); ?></p>
							</div>
						</div>
					</div>
			
				</div>
				
				<div class="row">
					<div class="col-md-12 text-center">
						<?= $this->Html->link(__('Features for vendors'),'#vendor-features',['class' => 'btn btn-xl']);?>
						<?= $this->Html->link(__('Features for partners'),'#partner-features',['class' => 'btn btn-xl']);?>
					</div>
				</div>
				
			</div>
		</div>
		
		
	</div> <!-- container(class)-->
</div>


<div id="content" class="section-white-fade">
	<div class="container">

		<div class="row" id="vendor-features">
			
			<div class="col-xs-12 text-center section-title">
				<h2><?= __('Main features for vendors');?></h2>
				<small><?= $this->Html->link(__('Back to top'),'#top',['class' => '']);?><i class="fa fa-level-up"></i></small>
			</div>
			
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				
				<div class="row usp">
			
					<div class="col-sm-4">
						<div class="row">
							<div data-sr="wait 0.5s and then ease-in-out 100px" class="col-sm-3 col-xs-2 col-xs-offset-1">
								<?= $this->Html->image('frontend/img_feat-ven_entire.png',['title'=>'Support the entire channel base','alt'=>'Support the entire channel base','width'=>'90','height'=>'90','class'=>'img-responsive'])?>
							</div>
							<div data-sr="wait 0.7s and then fade in" class="col-sm-8 col-xs-8">
								<h4><?= __('Support the entire channel base'); ?></h4>
								<p><?= __('Provide marketing support and collateral to your entire partner community to drive channel sales up, and increase brand loyalty.'); ?></p>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="row">
							<div data-sr="wait 0.5s and then ease-in-out 100px" class="col-sm-3 col-xs-2 col-xs-offset-1">
								<?= $this->Html->image('frontend/img_feat-ven_markets.png',['title'=>'Identify and open up new markets','alt'=>'Identify and open up new markets','width'=>'90','height'=>'90','class'=>'img-responsive'])?>
							</div>
							<div data-sr="wait 0.7s and then fade in" class="col-sm-8 col-xs-8">
								<h4><?= __('Identify and open up new markets'); ?></h4>
								<p><?= __("Identify your channel's geographical coverage and where the best deals are being made, on both a national and international level, so you can recruit additional partners to open up new markets."); ?></p>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="row">
							<div data-sr="wait 0.5s and then ease-in-out 100px" class="col-sm-3 col-xs-2 col-xs-offset-1">
								<?= $this->Html->image('frontend/img_feat-ven_observe.png',['title'=>'Monitor partner performance against goals','alt'=>'Monitor partner performance against goals','width'=>'90','height'=>'90','class'=>'img-responsive'])?>
							</div>
							<div data-sr="wait 0.7s and then fade in" class="col-sm-8 col-xs-8">
								<h4><?= __('Monitor partner performance against goals'); ?></h4>
								<p><?= __('Build measurable objectives, go-to-market plans, execution strategies and tactics and then review partners’ results to analyse the effectiveness of their execution.'); ?></p>
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="row usp">
			
					<div class="col-sm-4">
						<div class="row">
							<div data-sr="wait 0.5s and then ease-in-out 100px" class="col-sm-3 col-xs-2 col-xs-offset-1">
								<?= $this->Html->image('frontend/img_feat-ven_pie.png',['title'=>'Forecast productivity and results by partner','alt'=>'Forecast productivity and results by partner','width'=>'90','height'=>'90','class'=>'img-responsive'])?>
							</div>
							<div data-sr="wait 0.7s and then fade in" class="col-sm-8 col-xs-8">
								<h4><?= __('Forecast productivity and results by partner'); ?></h4>
								<p><?= __('Central dashboard reporting highlights partner’s performance against agreed performance metrics and provides accurate forecasting for future activities.'); ?></p>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="row">
							<div data-sr="wait 0.5s and then ease-in-out 100px" class="col-sm-3 col-xs-2 col-xs-offset-1">
								<?= $this->Html->image('frontend/img_feat-ven_monitor.png',['title'=>'Drive growth and gain brand loyalty','alt'=>'Drive growth and gain brand loyalty','width'=>'90','height'=>'90','class'=>'img-responsive'])?>
							</div>
							<div data-sr="wait 0.7s and then fade in" class="col-sm-8 col-xs-8">
								<h4><?= __('Drive growth and gain brand loyalty'); ?></h4>
								<p><?= __('Allocate funds and leads, and help partners generate their own business. Monitor deal flow quickly and easily. Support your partner with branded programmes and an interactive community.'); ?></p>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="row">
							<div data-sr="wait 0.5s and then ease-in-out 100px" class="col-sm-3 col-xs-2 col-xs-offset-1">
								<?= $this->Html->image('frontend/img_feat-ven_money.png',['title'=>'Predictable costs','alt'=>'Predictable costs','width'=>'90','height'=>'90','class'=>'img-responsive'])?>
							</div>
							<div data-sr="wait 0.7s and then fade in" class="col-sm-8 col-xs-8">
								<h4><?= __('Predictable costs'); ?></h4>
								<p><?= __('Fixed monthly subscription plans allow for easy financial forecasting, with no unexpected costs.'); ?></p>
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="row">
					<div class="col-md-12 text-center">
						<?= $this->Html->link('Get started now',['controller'=>'SubscriptionPackages','action'=>'packagelist/'.$row->id],['class'=>'btn btn-xl'])?>
					</div>
				</div>
				
			</div>
		</div>
		
		
	</div> <!-- container(class)-->
</div>


<div id="content" class="section-white-fade">
	<div class="container">

		<div class="row" id="partner-features">
			
			<div class="col-xs-12 text-center section-title">
				<h2><?= __('Main features for partners'); ?></h2>
				<small><?= $this->Html->link(__('Back to top'),'#top',['class' => '']);?><i class="fa fa-level-up"></i></small>
			</div>
			
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				
				<div class="row usp">
			
					<div class="col-sm-4">
						<div class="row">
							<div data-sr="wait 0.5s and then ease-in-out 100px" class="col-sm-3 col-xs-2 col-xs-offset-1">
								<?= $this->Html->image('frontend/img_feat-part_star.png',['title'=>'Zero cost','alt'=>'Zero cost','width'=>'90','height'=>'90','class'=>'img-responsive'])?>
							</div>
							<div data-sr="wait 0.7s and then fade in" class="col-sm-8 col-xs-8">
								<h4><?= __('Zero cost');?></h4>
								<p><?= __('Maximum functionality to promote vendor solutions at no cost, meaning increased sales and brand loyalty.'); ?></p>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="row">
							<div data-sr="wait 0.5s and then ease-in-out 100px" class="col-sm-3 col-xs-2 col-xs-offset-1">
								<?= $this->Html->image('frontend/img_feat-part_thumbs.png',['title'=>'Easy to use','alt'=>'Easy to use','width'=>'90','height'=>'90','class'=>'img-responsive'])?>
							</div>
							<div data-sr="wait 0.7s and then fade in" class="col-sm-8 col-xs-8">
								<h4><?= __('Easy to use'); ?></h4>
								<p><?= __('Planning, forecasting, reporting and execution – all from a single, simple portal.'); ?></p>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="row">
							<div data-sr="wait 0.5s and then ease-in-out 100px" class="col-sm-3 col-xs-2 col-xs-offset-1">
								<?= $this->Html->image('frontend/img_feat-part_graph.png',['title'=>'Simplified pipeline management','alt'=>'Simplified pipeline management','width'=>'90','height'=>'90','class'=>'img-responsive'])?>
							</div>
							<div data-sr="wait 0.7s and then fade in" class="col-sm-8 col-xs-8">
								<h4><?= __('Simplified pipeline management'); ?></h4>
								<p><?= __('Facilitated deal registration, lead management and reporting.');?></p>
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="row usp">
			
					<div class="col-sm-4">
						<div class="row">
							<div data-sr="wait 0.5s and then ease-in-out 100px" class="col-sm-3 col-xs-2 col-xs-offset-1">
								<?= $this->Html->image('frontend/img_feat-part_lock.png',['title'=>'Peace of mind with secure partitioned data','alt'=>'Peace of mind with secure partitioned data','width'=>'90','height'=>'90','class'=>'img-responsive'])?>
							</div>
							<div data-sr="wait 0.7s and then fade in" class="col-sm-8 col-xs-8">
								<h4><?= __('Peace of mind with secure partitioned data'); ?></h4>
								<p><?= __('The partner’s data remains theirs, in line with data regulations.'); ?></p>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="row">
							<div data-sr="wait 0.5s and then ease-in-out 100px" class="col-sm-3 col-xs-2 col-xs-offset-1">
								<?= $this->Html->image('frontend/img_feat-part_banner.png',['title'=>'Customisable co-branded marketing materials','alt'=>'Customisable co-branded marketing materials','width'=>'90','height'=>'90','class'=>'img-responsive'])?>
							</div>
							<div data-sr="wait 0.7s and then fade in" class="col-sm-8 col-xs-8">
								<h4><?= __('Customisable co-branded marketing materials'); ?></h4>
								<p><?= __('Partner logos can be easily added to existing marketing materials to allow all partners to use personalised, vendor approved content.'); ?></p>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="row">
							<div data-sr="wait 0.5s and then ease-in-out 100px" class="col-sm-3 col-xs-2 col-xs-offset-1">
								<?= $this->Html->image('frontend/img_feat-part_dial.png',['title'=>'Deal registration module & dashboard','alt'=>'Deal registration module & dashboard','width'=>'90','height'=>'90','class'=>'img-responsive'])?>
							</div>
							<div data-sr="wait 0.7s and then fade in" class="col-sm-8 col-xs-8">
								<h4><?= __('Deal registration module & dashboard'); ?></h4>
								<p><?= __('Partners can record all deals via the central portal, with APIs to link the deals registered directly into your CRM system.'); ?></p>
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="row">
					<div class="col-md-12 text-center">
						<?= $this->Html->link('Get started now',['controller'=>'SubscriptionPackages','action'=>'packagelist/'.$row->id],['class'=>'btn btn-xl'])?>
					</div>
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
				<?= $this->Html->link(__('Book a demo'),['controller' => 'Contact','action' => 'index','request' => 'demo'],['escape' => false, 'title' => 'Book a demo','class'=>'btn btn-xl btn-xl-white']);?>
			</div>
		</div>
		
  </div>
</div>
<!--  updated  -->
