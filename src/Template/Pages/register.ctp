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
	throw new Error\NotFoundException();
endif;
?>


			<div class="row base">  
  			
        <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
    		<?= $this->fetch('content') ?>

				<h1><?= __('Our plans and prices')?></h1>
				<h2><?= __('Feature rich, with simple pricing.  It’s Channel Management made easy')?></h2>
			
				<p class="text-center"><?= __('Our pricing is simple and modular, with special programs for those that are launching or in an early growth stage and complete packages for the more robust channels. In addition to our core functionality, our ecosystem of solutions providers connects to your existing applications, like CRM, eLearning and Marketing Automation Systems.')?></p>
				
				<div class="table-responsive">
					<table class="table">
	
						<thead>
							<tr>
								<td></td>
								<th>
									<h3><?= __('Bronze')?></h3>
									<h4><?= __('$25')?><small><?= __(' per month')?></small></h4>
									<p class="text-center"><?= __('or')?> <span class="price"><?= __('$250')?></span> <?= __('per year')?></p></th>
								<th>
									<h3><?= __('Silver')?></h3>
									<h4><?= __('$50')?><small><?= __(' per month')?></small></h4>
									<p class="text-center"><?= __('or')?> <span class="price"><?= __('$500')?></span> <?= __('per year')?></p></th>
								<th>
									<h3><?= __('Gold')?></h3>
									<h4><?= __('$100')?><small><?= __(' per month')?></small></h4>
									<p class="text-center"><?= __('or')?> <span class="price"><?= __('$900')?></span> <?= __('per year')?></p></th>
								<th>
									<h3><?= __('Platinum')?></h3>
									<h4><?= __('$125')?><small><?= __(' per month')?></small></h4>
									<p class="text-center"><?= __('or')?> <span class="price"><?= __('$1,250')?></span> <?= __('per year')?></p></th>
							</tr>
						</thead>
						
						<tbody>
							<tr>
								<th><a href="#" title="Storage"><?= __('Max storage capacity (GB)')?></a></th>
								<td>25</td>
								<td>50</td>
								<td>100</td>
								<td>500</td>
							</tr>
                                                        <tr>
								<th><a href="#" title="Partners"><?= __('Max number of partners')?></a></th>
								<td>10</td>
								<td>50</td>
								<td>100</td>
								<td>500</td>
							</tr>
							<tr>
								<th><a href="#" title="Emails"><?= __('Max number of emails (per month)')?></a></th>
								<td>100</td>
								<td>500</td>
								<td>1000</td>
								<td>5000</td>
							</tr>
							<tr>
								<th><a href="#" title="Deals registration module"><?= __('Deals registration module')?></a></th>
								<td></td>
								<td><span class="log-out glyphicon glyphicon-ok"></span></td>
								<td><span class="log-out glyphicon glyphicon-ok"></span></td>
								<td><span class="log-out glyphicon glyphicon-ok"></span></td>
							</tr>
							<tr>
								<th><a href="#" title="Channel &amp; Partner resource library"><?= __('Channel &amp; Partner resource library')?></a></th>
								<td></td>
								<td><span class="log-out glyphicon glyphicon-ok"></span></td>
								<td><span class="log-out glyphicon glyphicon-ok"></span></td>
								<td><span class="log-out glyphicon glyphicon-ok"></span></td>
							</tr>
							<tr>
								<th><a href="#" title="Feature 5"><?= __('Feature 5')?></a></th>
								<td></td>
								<td></td>
								<td><span class="log-out glyphicon glyphicon-ok"></span></td>
								<td><span class="log-out glyphicon glyphicon-ok"></span></td>
							</tr>
							<tr>
								<th><a href="#" title="Feature 6"><?= __('Feature 6')?></a></th>
								<td></td>
								<td></td>
								<td></td>
								<td><span class="log-out glyphicon glyphicon-ok"></span></td>
							</tr>
							<tr>
								<th></th>
								<td><a href="#" title="" class="small"><?= __('Full specification')?></a></td>
								<td><a href="#" title="" class="small"><?= __('Full specification')?></a></td>
								<td><a href="#" title="" class="small"><?= __('Full specification')?></a></td>
								<td><a href="#" title="" class="small"><?= __('Full specification')?></a></td>
							</tr>
							<tr>
								<th></th>
								

								<td><?= $this->Html->link(__('Get started'), ['controller' => 'subscription_packages', 'action' => 'packagelist'],['class' => 'btn btn-primary']); ?></a></td>
								<td><?= $this->Html->link(__('Get started'), ['controller' => 'subscription_packages', 'action' => 'packagelist'],['class' => 'btn btn-primary']); ?></a></td>
								<td><?= $this->Html->link(__('Get started'), ['controller' => 'subscription_packages', 'action' => 'packagelist'],['class' => 'btn btn-primary']); ?></a></td>
								<td><?= $this->Html->link(__('Get started'), ['controller' => 'subscription_packages', 'action' => 'packagelist'],['class' => 'btn btn-primary']); ?></a></td>
							</tr>
						</tbody>
	
					</table>
				</div>

				<p class="text-center"><?= __('Not sure what\'s best for you?  Ask our friendly team for advice')?></p>
				<p class="text-center"><a href="#" title="Contact us" class="btn btn-primary btn-xlg">Contact us</a></p>

			</div> <!-- /.row -->
			
			<div class="row white">
				
				<h3><?= __('Instant set-up gives you immediate access')?></h3>
				<h4><?= __('Launch your channel platform in weeks – not months')?></h4>
				<p class="text-center"><?= __('Our pricing is simple and modular, with special programs for those that are launching or in an early growth stage and complete packages for the more robust channels. In addition to our core functionality, our ecosystem of solutions providers connects to your existing applications, like CRM, eLearning and Marketing Automation Systems.  Learn more about our Software by reviewing the Modules below.')?></p>
				
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<h5><i class="fa fa-tachometer fa-3x"></i><br /><?= __('Manage')?></h5>
					<p class="small"><?= __('Partners strategically aligned across all geographic areas to meet business and sales objectives.')?></p>
					<p class="small"><?= __('Partner dashboards get complete visibility into partner program. View and manage partner profiles, contracts, and performance so they can run your channel objectively and efficiently.')?></p>
					<p class="small"><?= __('Drive revenue through joint accountability with a detailed campaign plan for each partner.')?></p>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<h5><i class="fa fa-puzzle-piece fa-3x"></i><br /><?= __('Enable')?></h5>
					<p class="small"><?= __('Communicate about upcoming events, training and product releases.')?></p>
					<p class="small"><?= __('Provide the channel partners with access to sales tools, marketing collateral and information, and training and enablement tools.')?></p>
					<p class="small"><?= __('Increase knowledge sharing among partners and get feedback to help improve your products and services.')?></p>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<h5><i class="fa fa-users fa-3x"></i><br /><?= __('Engage')?></h5>
					<p class="small"><?= __('Distribute leads to your partners and manage the lifecycle – start to finish.')?></p>
					<p class="small"><?= __('Grow partner revenue by preventing channel conflict and managing approvals, collaboration and forecasting for each channel programs.')?></p>
					<p class="small"><?= __('Drive partner marketing efforts with a simple and streamlined Market development fund management process.')?></p>
				</div>
				
				<div class="clearfix visible-xs-block"></div>
				
				<div class="col-md-12">
					<p class="text-center"><a href="#" title="Contact us" class="btn btn-primary btn-xlg"><?= __('See all features')?></a></p>
				</div>
				
			</div> <!-- /.row -->
			
			<div class="row grey split-col">

				<div class="col-md-5">
				
					<h4 class="text-left"><?= __('The latest from our \'blog')?></h4>
					<p class="blog-links"><?= __('Subscribe to our RSS feed')?> <i class="fa fa-rss"></i>&nbsp;&nbsp;&nbsp;<?= __('Subscribe to our e-Newsletter')?> <i class="fa fa-envelope"></i></p>
					
					<div class="row">
					
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
							<?= $this->Html->image('frontend/img_blog1.png',['alt'=>'Test blog image'])?>
						</div>
						
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
							<h5 class="text-left"><?= __('How CRM can help your business grow')?></h5>
							<p><?= __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quam augue, ornare porttitor sapien vel, gravida ultricies dui.')?></p>
						</div>
						
					</div>
					
					<div class="row">
					
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
							<?= $this->Html->image('frontend/img_blog2.png',['alt'=>'Test blog image'])?>
						</div>
						
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
							<h5 class="text-left"><?= __('How CRM can help your business grow')?></h5>
							<p><?= __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quam augue, ornare porttitor sapien vel, gravida ultricies dui.')?></p>
						</div>
						
					</div>

					<div class="row">
					
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
							<?= $this->Html->image('frontend/img_blog3.png',['alt'=>'Test blog image'])?>
						</div>
						
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
							<h5 class="text-left"><?= __('How CRM can help your business grow')?></h5>
							<p><?= __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quam augue, ornare porttitor sapien vel, gravida ultricies dui.')?></p>
						</div>
						
					</div>
					
					<div class="row">
					
						<a href="#" title="See our full 'blog index" class="btn btn-primary pull-right"><?= __('Full \'blog index')?></a>
					
					</div>

				</div>
				
				<div class="col-md-5 col-md-offset-2">
				
					<h4 class="text-left"><?= __('We\'d love to hear from you')?></h4>
					<p class="blog-links"><?= __('If you\’d like to find out more about our services please complete the form and we\’ll get back to you within 24 hours.  Alternatively, you can call us on 01234 567 890, Monday to Friday 9:00am - 6:00pm.')?></p>
					
					<form role="form">
					
						<div class="row">
					
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							
							  <div class="form-group">
							    <label for="name"><?= __('Name')?></label>
							    <input type="text" class="form-control" id="name" placeholder="Name">
							  </div>
							  
							</div>
							
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							
							  <div class="form-group">
							    <label for="position"><?= __('Position/Job Title')?></label>
							    <input type="text" class="form-control" id="position" placeholder="Position/Job Title">
							  </div>
							  
							</div>
							
							<div class="col-md-12">
							
							  <div class="form-group">
							    <label for="company"><?= __('Company')?></label>
							    <input type="text" class="form-control" id="company" placeholder="Company">
							  </div>
								
							</div>
							
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							
							  <div class="form-group">
							    <label for="email"><?= __('E-mail')?></label>
							    <input type="email" class="form-control" id="email" placeholder="E-mail">
							  </div>
							  
							</div>
							
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							
							  <div class="form-group">
							    <label for="phone"><?= __('Phone')?></label>
							    <input type="text" class="form-control" id="phone" placeholder="Phone">
							  </div>
							  
							</div>
							
							<div class="col-md-12">
							
							  <div class="form-group">
							    <label for="subject"><?= __('I\'d like to find out more about')?></label>
										<select class="form-control turnintodropdown">
										  <option><?= __('Please select')?></option>
										  <option><?= __('1')?></option>
										  <option><?= __('2')?></option>
										  <option><?= __('3')?></option>
										  <option><?= __('4')?></option>
										</select>
							  </div>
							  
							</div>
							
							<div class="col-md-12">
							
							  <div class="form-group">
							    <label for="message"><?= __('Any message')?></label>
							    <textarea class="form-control" id="message" placeholder="Please enter any message"></textarea>
							  </div>
							  
							</div>
							
							<div class="col-md-12">
							
							  <button type="submit" class="btn btn-primary pull-right"><?= __('Send it')?></button>
							</div>
						
						</div>
						
					</form>

				</div>

			</div> <!-- /.row -->
			
			<div class="row white">
			
				<div class="col-md-12">
				
					<h4><?= __('Or join us on social media')?></h4>
				
				</div>
				
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				
					<div class="row">
					
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
							<p class="text-center"><i class="fa fa-twitter fa-5x"></i></p>
						</div>
						
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
							<p class="small"><?= __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quam augue, ornare porttitor sapien vel, gravida ultricies dui.')?></p>
							<p class="pull-left small"><?= __('2 hours ago')?></p>
							<a href="#" title="Follow us on Twitter" class="pull-right small"><?= __('Follow us on Twitter')?></a>
						</div>
					
					</div>
				
				</div>
				
				<div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
					<p class="text-center"><i class="fa fa-facebook fa-4x"></i></p>
				</div>
				
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
					<a href="#" title="Find us on Facebook" class="text-center small"><br /><?= __('Find us on Facebook')?></a>
				</div>
				
				<div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
					<p class="text-center"><i class="fa fa-linkedin fa-4x"></i></p>
				</div>
			
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
					<a href="#" title="Connect with us on LinkedIn" class="text-center small"><br /><?= __('Connect on LinkedIn')?></a>
				</div>

			</div>
