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
		
			<div class="row container-header">
				<div class="col-md-12">
		
					<h1 class="text-center"><?= __('Contact us'); ?></h1>
					<h2 class="text-center"><?= __("Here's all the information you need"); ?></h2>
					<p class="text-center"><?= __("If you’d like to find out more about MarketingConneX or have some feedback for us, we'd love to hear from you.  Our friendly team who will be pleased to help"); ?></p>
				
				</div>
			</div>
			
      <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
			<?= $this->fetch('content') ?>
		
			<div class="row">

				<div class="col-md-6">
					
					<div class="row">
					
						<div class="col-md-12 col-sm-6">
				
							<div class="row">
								
								<div class="col-xs-1">
									<p><i class="fa fa-phone fw fa-2x text-center claret"></i></p>
								</div>
								<div class="col-xs-11">
									<?= $this->Html->link(__('+44 1628 564 920'),'tel:+441628564920',['title'=>'Call +44 1628 564 920', 'class' => 'contact-ref']);?>
								</div>
								
							</div>
							<div class="row">
								
								<div class="col-xs-1">
									<p><i class="fa fa-at fa-lg text-center olive"></i></p>
								</div>
								<div class="col-xs-11">
									<?= $this->Html->link(__('contact@marketingconnex.com'),'mailto:contact@marketingconnex.com',['title'=>'email contact@marketingconnex.com', 'class' => '']);?>
								</div>
								
							</div>
							<div class="row">
								
								<div class="col-xs-1">
									<p><i class="fa fa-desktop fa-lg text-center orange"></i></p>
								</div>
								<div class="col-xs-11">
									<?= $this->Html->link(__('www.marketingconnex.com'),'http://www.marketingconnex.com',['title'=>'www.marketingconnex.com', 'class' => '', 'target'=>'_blank']);?>
								</div>
							
							</div>
							<div class="row container-header">
								
								<div class="col-xs-1">
									<p><i class="fa fa-envelope fa-lg text-center cyan"></i></p>
								</div>
								<div class="col-xs-11">
									<p><?= __('The Granary');?><br />
									   <?= __('Courtyard Barns');?><br />
									   <?= __('Choke Lane');?><br />
									   <?= __('Cookham Dean');?><br />
									   <?= __('SL6 6PT');?><br />
									   <?= __('United Kingdom');?></p>
								</div>
							
							</div>
							
						</div>
						
						<div class="col-md-12 col-sm-6 container-header">
							
							<div class="row">
							
								<div class="col-xs-1">
									<p><i class="fa fa-question-circle fa-2x text-center cyan"></i></p>
								</div>
								<div class="col-xs-11">
									<h3 style="margin-bottom:0;"><?= __('Help and Support');?></h3>
								</div>
								
							</div>
							<div class="row">
								
								<div class="col-xs-1">
									<p><i class="fa fa-phone fw fa-2x text-center claret"></i></p>
								</div>
								<div class="col-xs-11">
									<p class="contact-ref"><?= $this->Html->link(__('+44 1628 564 920'),'tel:+441628564920',['title'=>'Call our support team on +44 1628 564 920', 'class' => '']);?></p>
								</div>
								
							</div>
							<div class="row">
								
								<div class="col-xs-1">
									<p><i class="fa fa-at fa-lg text-center olive"></i></p>
								</div>
								<div class="col-xs-11">
									<?= $this->Html->link(__('support@marketingconnex.com'),'mailto:support@marketingconnex.com',['title'=>'email support@marketingconnex.com', 'class' => '']);?>
								</div>
								
							</div>
							<!--
							<div class="row">
								
								<div class="col-xs-1">
									<p><i class="fa fa-question-circle fa-lg text-center orange"></i></p>
								</div>
								<div class="col-xs-11">
									<?= $this->Html->link(__('Frequently Asked Questions'),['controller'=>'pages', 'action'=>'faq'],['title'=>'Frequently asked questions', 'class' => '']);?>
								</div>
							
							</div>
							-->
							
						</div>
						
					</div>
					
				</div>
				
				<div class="col-md-6">
				
					<h3 class="text-left"><?= __("We'd love to hear from you")?></h3>
					<p class="blog-links"><?= __("If you’d like to find out more about our services please complete the form and we’ll get back to you within 24 hours.  Alternatively, you can call us on <span class='contact-ref'>+44 1628 564 920</span>.")?></p>
					
					<!--
						
						
						Create cake form that's created from data NOT stored in the DB - refer to: http://book.cakephp.org/3.0/en/core-libraries/form.html
						
						
					-->
					
					<?php
						echo $this->Form->create($contact);
					?>
					
						<div class="row">
														
							<fieldset>
					
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							
							<?php
								echo $this->Form->input('firstname');
							?>		
												  
							</div>
							
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							
							<?php
								echo $this->Form->input('lastname');
							?>		
							  
							</div>
							
							<div class="col-md-12">
							
							<?php
								echo $this->Form->input('position');
							?>		
								
							</div>

							<div class="col-md-12">
							
							<?php
								echo $this->Form->input('company');
							?>		
								
							</div>
							
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							
							<?php
								echo $this->Form->input('email');
							?>		
							  
							</div>
							
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							
							<?php
								echo $this->Form->input('phone');
							?>		
							  
							</div>
							
							<div class="col-md-12">
							
							  <div class="form-group">
							    <label for="subject"><?= __("I'd like to find out more about")?></label>
									<?php
										$options = [			'General enquiry' => 'How MarketingConneX can help my business?',
																'Demo request' => 'Book a demonstration',
																'Pricing enquiry' => 'Pricing and Plans',
																'Other' => 'Other (please complete the text in the box below)'];

										if ($this->request->query['request']=='demo') {
											$extras = [
												'empty' => 'Please select',
												"label"=>"I'd like to find out more about",
												"class"=>"form-control turnintodropdown",
												'default' => 'Demo request'
											];
										} else {
											$extras = [
												'empty' => 'Please select',
												"label"=>"I'd like to find out more about",
												"class"=>"form-control turnintodropdown",
											];
											
										}
										
										echo $this->Form->select('info',
											$options,
											$extras
										);
										
										
									?>		
							  </div>

							</div>
							
							<div class="col-md-12">
								
							  <div class="form-group">
							    <label for="subject"><?= __("Any message")?></label>
									<?php
										echo $this->Form->textarea('message');
									?>		
							  </div>
							
							</div>
							
							</fieldset>
						
							<div class="col-md-12">
							
							<?php
								echo $this->Form->button('Send it!',['class'=>'btn btn-lg pull-right']);
							?>		
							  
							</div>
							
						</div>
						
					<?php
						echo $this->Form->end();
					?>		
							

				</div>

			</div> <!-- /.row -->

	</div>
</div>
