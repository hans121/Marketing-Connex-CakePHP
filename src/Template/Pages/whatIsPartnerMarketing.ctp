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
				<h2><?= __('What is a channel partner?'); ?></h2>
			</div>
			
		</div>
		
		<div class="row what-is-info">
			<div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
				
				<div class="row">
			
					<div class="col-xs-3 col-xs-offset-1" data-sr="wait 0.5s and then fade in">
						<?= $this->Html->image('frontend/img_whatis_vendor_symbol.png',['title'=>'Vendor','alt'=>'Vendor','width'=>'250','height'=>'250','class'=>'img-responsive'])?>
						<h4 class="text-center"><?= ('Vendor'); ?></h4>
					</div>
					
					<div class="col-xs-4">
						<div class="row">
							<div class="col-xs-6 col-xs-offset-6" data-sr="wait 1.25s and then enter left over 4s please, and hustle 250px">
								<?= $this->Html->image('frontend/img_whatis_product_symbol.png',['title'=>'Product','alt'=>'Product','width'=>'250','height'=>'250','class'=>'img-responsive'])?>
							</div>
							<div class="col-xs-6" data-sr="wait 1.25s and then enter left over 4s please, and hustle 250px">
								<?= $this->Html->image('frontend/img_whatis_product_symbol.png',['title'=>'Product','alt'=>'Product','width'=>'250','height'=>'250','class'=>'img-responsive'])?>
							</div>
						</div>
					</div>
					
					<div class="col-xs-3" data-sr="wait 0.75s and then fade in">
						<?= $this->Html->image('frontend/img_whatis_partner_symbol.png',['title'=>'Partner','alt'=>'Partner','width'=>'250','height'=>'250','class'=>'img-responsive'])?>
						<h4 class="text-center"><?= ('Partner'); ?></h4>
					</div>
					
				</div>
				
				<div class="row">
			
					<div class="col-xs-6 what-is-info" data-sr="wait 1.5s and then fade in">
						<p><?= ('A channel partner sells products or services on behalf of a software or hardware vendor.'); ?></p>
						<p><?= ('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec rhoncus sagittis dignissim. Aliquam fermentum metus vitae tellus aliquet, sed ultrices augue gravida.'); ?></p>
						<p><?= ('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec rhoncus sagittis dignissim. Aliquam fermentum metus vitae tellus aliquet, sed ultrices augue gravida.'); ?></p>
					</div>

					<div class="col-xs-3 col-xs-offset-2">
						<div class="row">
							<div class="col-xs-12" data-sr="wait 2s and then fade in">
								<?= $this->Html->image('frontend/img_whatis_arrow_vertical.png',['title'=>'Flow','alt'=>'Flow','width'=>'250','height'=>'250','class'=>'img-responsive'])?>
							</div>
							<div class="col-xs-12" data-sr="wait 4s and then enter top over 4s please, and hustle 250px">
								<?= $this->Html->image('frontend/img_whatis_product_symbol.png',['title'=>'Product','alt'=>'Product','width'=>'250','height'=>'250','class'=>'img-responsive'])?>
								<h4 class="text-center"><?= ('Product or Service'); ?></h4>
							</div>
							<div class="col-xs-12" data-sr="wait 2s and then fade in">
								<?= $this->Html->image('frontend/img_whatis_arrow_vertical.png',['title'=>'Flow','alt'=>'Flow','width'=>'250','height'=>'250','class'=>'img-responsive'])?>
							</div>
							<div class="col-xs-12" data-sr="wait 2.5s and then enter left over 4s please, and hustle 250px">
								<?= $this->Html->image('frontend/img_whatis_customer_symbol.png',['title'=>'Consumer','alt'=>'Consumer','width'=>'250','height'=>'250','class'=>'img-responsive'])?>
								<h4 class="text-center"><?= ('Consumer'); ?></h4>
							</div>
						</div>
					</div>
					
				</div>
				
			</div>
		</div>
		
		
	</div> <!-- container(class)-->
</div>


<div id="content" class="section-white-fade">
	<div class="container">
		
		<div class="row">
			
			<div class="col-xs-12 text-center section-title">
				<h2><?= __('How does channel partner marketing work?'); ?></h2>
			</div>
			
		</div>
		

		<div class="row what-is-info">
			<div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
				
				<div class="row">
			
					<div class="col-xs-3 col-xs-offset-1" data-sr="wait 0.5s and then fade in">
						<?= $this->Html->image('frontend/img_whatis_vendor_symbol.png',['title'=>'Vendor','alt'=>'Vendor','width'=>'250','height'=>'250','class'=>'img-responsive'])?>
						<h4 class="text-center"><?= ('Vendor'); ?></h4>
					</div>
					
					<div class="col-xs-4" data-sr="wait 1.25s and then enter left over 4s please, and hustle 250px">
						<div class="row">
							<div class="col-xs-5 col-xs-offset-7">
								<?= $this->Html->image('frontend/img_whatis_pdf_symbol.png',['title'=>'Product','alt'=>'Product','width'=>'250','height'=>'250','class'=>'img-responsive'])?>
							</div>
							<div class="col-xs-5 col-xs-offset-3">
								<?= $this->Html->image('frontend/img_whatis_doc_symbol.png',['title'=>'Product','alt'=>'Product','width'=>'250','height'=>'250','class'=>'img-responsive'])?>
							</div>
						</div>
					</div>
					
					<div class="col-xs-3">
						<div class="row">
							<div class="col-xs-8 col-xs-offset-4" data-sr="wait 2s and then fade in">
								<?= $this->Html->image('frontend/img_whatis_thought-rh.png',['title'=>'Thinking about the product','alt'=>'Thought','width'=>'250','height'=>'250','class'=>'img-responsive'])?>
							</div>
							<div class="col-xs-10" data-sr="wait 0.75s and then fade in">
								<?= $this->Html->image('frontend/img_whatis_partner_symbol.png',['title'=>'Partner','alt'=>'Partner','width'=>'250','height'=>'250','class'=>'img-responsive'])?>
								<h4 class="text-center"><?= ('Partner'); ?></h4>
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="row">
			
					<div class="col-xs-6 what-is-info" data-sr="wait 1.5s and then fade in">
						<p><?= ("Channel partners receive access to product and marketing training, discounts, technical support, lead generation tools.  This keeps the vendor's product in their mind."); ?></p>
						<p><?= ('Channel partnerships provide an opportunity for partners to promote products or services for the vendor.'); ?></p>
						<p><?= ('This often takes the form of email, web or postal communications, in order to put the product in the mind of the consumer.'); ?></p>
					</div>
					
					<div class="col-xs-3 col-xs-offset-2 what-is-info">
						<div class="row" data-sr="wait 2s and then enter top over 4s please, and hustle 150px">
							<div class="col-xs-6 col-xs-offset-6" >
								<?= $this->Html->image('frontend/img_whatis_postal_symbol.png',['title'=>'Flow','alt'=>'Flow','width'=>'250','height'=>'250','class'=>'img-responsive'])?>
							</div>
							<div class="col-xs-6">
								<?= $this->Html->image('frontend/img_whatis_laptop_symbol.png',['title'=>'Flow','alt'=>'Flow','width'=>'250','height'=>'250','class'=>'img-responsive'])?>
							</div>
							<div class="col-xs-6 col-xs-offset-6">
								<?= $this->Html->image('frontend/img_whatis_email_symbol.png',['title'=>'Flow','alt'=>'Flow','width'=>'250','height'=>'250','class'=>'img-responsive'])?>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<div class="row">
									<div class="col-xs-8" data-sr="wait 2.5s and then fade in">
										<?= $this->Html->image('frontend/img_whatis_thought-lh.png',['title'=>'Thinking about the product','alt'=>'Thought','width'=>'250','height'=>'250','class'=>'img-responsive'])?>
									</div>
									<div class="col-xs-10 col-xs-offset-2" data-sr="wait 0.75s and then fade in">
										<?= $this->Html->image('frontend/img_whatis_customer_symbol.png',['title'=>'Partner','alt'=>'Partner','width'=>'250','height'=>'250','class'=>'img-responsive'])?>
										<h4 class="text-center"><?= ('Consumer'); ?></h4>
									</div>
								</div>
							</div>
						</div>
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
				<?= $this->Html->link('Book a demo',['request' => 'demo'], 'controller'=>'SubscriptionPackages','action'=>'packagelist/'.$row->id],['class'=>'btn btn-xl btn-xl-white'])?>
			</div>
		</div>
		
  </div>
</div>
