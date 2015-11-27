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

<?php
if($submitted===true) :
?>
<div id="content" class="section-white-fade">
	<div class="container">

    <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
		<?= $this->fetch('content') ?>
		
		<div class="row">
  		
  		<div class="col-centered col-lg-10 col-md-10 col-sm-10">
		
    		<h1 class="text-center"><?= __('Thank you for submitting your details')?></h1>
			<h2 class="text-center">You can look forward to being the first to know when we publish new resources just like this.</h2>
  		</div>
  		
		</div>
		<div class="row">
			<div class="col-sm-4 col-sm-offset-3 ">
		        	<a onClick="_gaq.push(['_trackEvent', 'Challenges Landingpage', 'download', 'after form',, false]);" href="/campaignfiles/marketingconnex_partner_marketing_infographic.pdf" target="_blank"><?= $this->Html->image('infographic.png',['title'=>'infographic','alt'=>'infographic','width'=>'278','height'=>'394','class'=>'img-responsive  center-block'])?></a>
			</div>	
			<div class="col-sm-2  hidden-xs">
	        	 <p style="font-size:18px; padding-top:100px;">
		        	 <a onClick="_gaq.push(['_trackEvent', 'Challenges Landingpage', 'download', 'after form',, false]);" href="/campaignfiles/marketingconnex_partner_marketing_infographic.pdf" target="_blank">
			        	Click image (left) to download the full infographic now 
			     </a></p>
			</div>	
			<div class="col-xs-10 col-xs-offset-1  visible-xs">
	        	 <p style="font-size:18px; ">
		        	 <a onClick="_gaq.push(['_trackEvent', 'Challenges Landingpage', 'download', 'after form',, false]);" href="/campaignfiles/marketingconnex_partner_marketing_infographic.pdf" target="_blank">
			        	Click image (above) to download the full infographic now 
			     </a></p>
			</div>	

		</div>
	</div> <!-- container(class)-->
</div>
<?php
else :
?>

<!--  Load ScrollReveal only on pages required, as clashes with some Bootstrap.js functions -->

<?php echo $this->Html->script('scrollReveal.js-master/scrollReveal.js');?>
<?= $this->fetch('script');?>


<div class="jumbotron" style="color:#000; background:#fff;">
  <div class="container" >
		<h1 class="text-center" style="font-size:40px; margin-bottom: 5px;"><?= __('There are many challenges facing modern partner marketeers,'); ?></h1>
		<h2 class="text-center" style="font-size:40px; "><?= __('but see just how easily you can turn partners into profit?'); ?></h2>
		<div class="clearfix"></div>
		<div class="row" style="padding-top:50px; ">
			<div class="col-md-4">
				<p style="font-size:16px; padding-bottom:0px; line-height: 25px;">
				We, here at MarketingConnex, enable ANY company which is seeking to make the most of their partner 
				channel (whether resellers, agencies, franchises or 
				dealerships), to use the latest technology &amp marketing 
				techiques to be:
				</p>
				<ul class="list-unstyled" >
					<li style="font-size:16px; display: block; ">the vendor of choice / drive competitive advantage </li>
					<li style="font-size:16px; ">faster to market </li>
					<li style="font-size:16px; ">more agile</li>
					<li style="font-size:16px; ">manage their brand through the channel effectively</li>
					<li style="font-size:16px; ">make the most of their marketing spend and </li>
					<li style="font-size:16px; ">reduce costs </li>
				</ul>
				<p style="font-size:16px; ">
					Turning YOUR partners into profit !
				</p>
				<p style="font-size:16px; padding-bottom:10px; line-height: 25px;">
					Find out how we address the key challenges you face today by taking a look at our great new 
					infographic.
				</p>
			</div>
			<div class="col-md-8">
				<div class="row">
			    	<div class="col-md-6">
			        	 <p class="text-center" style="font-size:16px; font-weight: bolder;"><a onClick="_gaq.push(['_trackEvent', 'Challenges Landingpage', 'download', 'before form',, false]);" href="/campaignfiles/marketingconnex_partner_marketing_infographic.pdf" target="_blank">Download the full <br/>infographic here</a></p>
			        	<a onClick="_gaq.push(['_trackEvent', 'Challenges Landingpage', 'download', 'before form',, false]);" href="/campaignfiles/marketingconnex_partner_marketing_infographic.pdf" target="_blank"><?= $this->Html->image('infographic.png',['title'=>'infographic','alt'=>'infographic','width'=>'278','height'=>'394','class'=>'img-responsive  center-block'])?></a>
			        	<p class="text-center" style="font-size:16px; margin-bottom: 0; margin-top: 50px;">share this...</p>

						<div class="addthis_sharing_toolbox text-center" style="margin-top:10px;"></div>

			    	</div>
			    	<div class="col-md-6">
			        	<p style="font-size:16px; line-height: 25px;">
			        	You can download our infographic below
						without subscribing but if you would like 
						to be notified when we produce more items 
						like this, just leave your details below.
						</p>
						
						<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

						<?php echo $this->Form->create($landingpage); ?>

						<?php echo $this->Form->input('firstname',['label'=>__('First name')]); ?>  
						<?php echo $this->Form->input('lastname',['label'=>__('Last name')]); ?>  

						<?php //echo $this->Form->input('email',['label'=>__('Email')]); ?>
						<div class="input email required"><label for="email">Email <span><a href="https://www.marketingconnex.com/pages/privacy" target=“_blank>(privacy policy)</a></span></label><input type="email" name="email" required="required" id="email"></div> 
						 
						<?php echo $this->Form->input('website',['label'=>__('Website URL')]);  ?>    
						<?php echo $this->Form->input('phone',['label'=>__('Phone No')]);?>
						<?php echo $this->Form->input('landingpage',['type'=>'hidden','value'=>$url]);?>
						<?php echo $this->Form->input('info',['type'=>'hidden','value'=>'notify of new infographic']);?>
						<p style="font-size:16px; ">* required fields</p>
						<button type="submit" class="btn btn-success submit" style="background:#57968f; color:#fff; font-size:16px; font-weight: bolder;">Be the first to know<br>(subscribe)</button>
						<?php echo $this->Form->end(); ?>
			    	</div>
			    </div>
			</div>
		</div>
  </div>
</div>
<style type="text/css">
	.input input {
		padding: 5px;
		background-color: #f4f4f4;
		margin: 0;
	}
	.input label {
		margin: 0;
  		padding-top: 10px;
  		font-size:16px;
	}
	.input span{
		color: orange;
	}
	.input span a:hover{
		color: orange;
	}
	.submit {
		background: #57968f;
  		color: #fff;
  		width: 100%;
  		padding: 5px !important;
	}
	.submit:hover {
		opacity: 0.8;
	}
	.list-unstyled {
		color:#333;
		font-weight: normal;
		padding-top:0px;
	}
	.list-unstyled li {
		background: url(/img/bullet-dash.png) 2px 5px no-repeat;
		padding-left:20px;	
	}
</style>
<!--  updated  -->
<?php
endif;
?>
