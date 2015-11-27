<?php
	if(isset($portal_settings)) {
	  $cakeDescription = $portal_settings['site_name'].' - '.$portal_settings['site_description'];
	} else {
	  $cakeDescription = '';
	}
	$admn = $this->Session->read('Auth');
?>

<!DOCTYPE html>

<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if gt IE 8]><!--> <html>         <!--<![endif]-->

	<head>
	
		<?= $this->Html->charset();?>
		
		<title>
			<?= $cakeDescription ?>:
			<?= $this->fetch('title');?>
		</title>
		
		<?= $this->Html->meta('viewport', 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'); ?>
	
		<?php echo $this->Html->css('bootstrap.min.css');?>
		<?php echo $this->Html->css('formValidation.min.css');?>
		<?php echo $this->Html->css('cake.generic.css');?>
		<?php // echo $this->Html->css('https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css');?>
		<?php echo $this->Html->css('jquery-ui.css');?>
		<?php echo $this->Html->css('jquery-ui.structure.css');?>
		<?php echo $this->Html->css('jquery-ui.theme.css');?>
		<?php echo $this->Html->css('jquery-ui-timepicker-addon.css');?>
		<?php echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js');?>
		<?php echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js');?>
		<?php echo $this->Html->script('jquery-ui-timepicker-addon.js');?>
		<?php echo $this->Html->css('https://fonts.googleapis.com/css?family=Roboto:400,300,500,700');?>
  	<?php echo $this->Html->css('https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');?>
		<?php echo $this->Html->script('bootstrap.min.js');?>
		<?php echo $this->Html->script('formValidation.min.js');?>
		<?php echo $this->Html->script('bootstrap-formvalidation.min.js');?>
		<?php echo $this->Html->script('modernizr.js');?>
		<?php echo $this->Html->script('custom.js');?>
		<?php echo $this->Html->script('respond.min.js');?>
		<?php echo $this->Html->script('selectivizr-min.js');?>
		<?php echo $this->Html->script('jspatch.js');?>
		<?php echo $this->Html->script('jquery.sticky.js');?>
		<?php echo $this->Html->script('pwstrength-bootstrap/pwstrength-bootstrap-1.2.3.min.js');?>
		
		
		<!-- Jasny Bootstrap extension -->
		<?php echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css');?>
		<?php echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js');?>
		
		
		<!-- Google Maps API -->
		<?php echo $this->Html->script('https://maps.googleapis.com/maps/api/js?key=AIzaSyBlNRHavddm2klM2rvZG0_TPOChIFY4Vrg');?>
	
	
		<!-- For Timeline plugin -->
		<?php echo $this->Html->script('jquery.mCustomScrollbar.js');?>
		<?php echo $this->Html->script('jquery.easing.1.3.js');?>
		<?php echo $this->Html->script('jquery.timeline.min.js');?>
		<?php echo $this->Html->script('image.js');?>
		<?php echo $this->Html->script('lightbox.js');?>
		<?php echo $this->Html->css('jquery.timeline.light.css');?>
		<?php // echo $this->Html->css('jquery.timeline.lightbox.css');?>
		<?php echo $this->Html->css('jquery.mCustomScrollbar.css');?>
		<!--[if lt IE 9]>
			<?php echo $this->Html->css('jquery.timeline.ie8fix.css');?>
		<![endif]-->
	
	
		<!-- For Charts.js plugin --> 
		<?php echo $this->Html->script('chart.js-master/chart.js');?>
		<!--[if lte IE 8]>
			<?php echo $this->Html->script('excanvas.js');?>
	  <![endif]-->
	  
	  
		<?= $this->Html->meta('favicon.ico', 'img/favicons/favicon.ico', ['type' => 'icon']); ?>
		<?= $this->Html->meta('favicon-32x32.png', 'img/favicons/favicon-32x32.png', ['type' => 'icon']); ?>
		<?= $this->Html->meta(array('rel' => 'apple-touch-icon-precomposed','sizes' => '144x144','link' => 'img/favicons/apple-touch-icon-144-precomposed.png',));?>
		<?= $this->Html->meta(array('rel' => 'apple-touch-icon-precomposed','sizes' => '256x256','link' => 'img/favicons/apple-touch-icon-256-precomposed.png',));?>
		<?= $this->Html->meta(array('rel' => 'apple-touch-icon-precomposed','sizes' => '512x512','link' => 'img/favicons/apple-touch-icon-512-precomposed.png',));?>
	
	
		<?= $this->fetch('meta');?>
		<?= $this->fetch('css');?>
		<?= $this->fetch('script');?>
	
	
		<!--[if lt IE 9]>
			<link rel="stylesheet" type="text/css" href="/css/ie8-and-down.css" />
		<![endif]-->
		
	  <script>
			$(document).ready(function() {
			  $('.row.inner .col-xs-12.text-center').click(function() {
			    $(this).toggleClass('active');
			  });
			});
			
			$(document).ready(function() {
			  $('.toggle-view').click(function() {
			    $('#mobile-actions').toggleClass('hidden-menu');
			  });
			});
		</script>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-57286022-1', 'auto');
		  ga('send', 'pageview');
		
		</script>	
		<script type="text/javascript">
		(function(a,e,c,f,g,b,d){var h={ak:"947212953",cl:"eHvHCIeN_lsQmaXVwwM"};a[c]=a[c]||function(){(a[c].q=a[c].q||[]).push(arguments)};a[f]||(a[f]=h.ak);b=e.createElement(g);b.async=1;b.src="//www.gstatic.com/wcm/loader.js";d=e.getElementsByTagName(g)[0];d.parentNode.insertBefore(b,d);a._googWcmGet=function(b,d,e){a[c](2,b,h,d,null,new Date,e)}})(window,document,"_googWcmImpl","_googWcmAk","script");

	    var callback = function(formatted_number, mobile_number) {

	      var e = document.getElementById("contact-tel");
	      e.innerHTML = "";
	      e.innerHTML = formatted_number;
		  e.setAttribute('href', "tel:"+formatted_number);
		  e.setAttribute('title', "Call us on:"+formatted_number);
	    };
	  </script>

	</head>
	
	
	<body id="top" class="frontend <?php echo (($this->request->params['controller']==='pages')&& ($this->request->params['action']=='home') )?'frontend-homepage' :'' ?>" onload="_googWcmGet(callback, '+44 1628 564920')" >
	
		<?php // Display notifications for partners
			$tot_pnotifications =   0;
			$tot_vnotifications =   0;
			$tot_pnotifications +=  $partner_new_campaigns+$partner_approved_bp+$partner_denied_bp+$new_bp_alert;
			$tot_vnotifications +=  $vendor_sbmt_bp;
		?>
	
		<div id="container">
			<div id="header">
				<div class="container">
					<div class="row">
						<div class="navbar-header">
						
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mobile-actions">
								
								<?php if(isset($admn['User']['role']) && $admn['User']['role'] == 'partner' && $tot_pnotifications > 0){ ?>
								<div class="mobile-badge badge"><?= $tot_pnotifications?></div>
								<?php }elseif(isset($admn['User']['role']) && $admn['User']['role'] == 'vendor' && $tot_vnotifications > 0){?>
								<div class="mobile-badge badge"><?= $tot_vnotifications?></div>
								<?php } ?>
								
								<span class="sr-only"><?= __('Toggle navigation')?></span>
								<div class="mobile-menu-trigger">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								</div>
				        
							</button>
							
							<h2 class="navbar-brand-logo" id="brand-logo">
								<?= $this->Html->image('logos/logo-marketing-connex.png', [ 'alt'=>'Panovus','width'=>'400','height'=>'150','class'=>'img-responsive','id'=>'brand-logo-img','url' => ['controller' => 'Pages', 'action' => 'home']]);?>						
							</h2>
							
							<div class="contact-details">
								<a href="tel:+441628564920" title="<?= __('Call us on +44 1628 564 920')?>" id="contact-tel" class="contact-tel">+44 1628 564 920</a>
								<a href="mailto:contact@marketingconnex.com" title="<?= __('Email us on contact@marketingconnex.com')?>" class="contact-email">contact@marketingconnex.com</a>
							</div>
					  
				  	</div> <!-- navbar-header -->
	
						
						<div class="collapse navbar-collapse" id="bs-navbar-collapse-1"><!-- Collect the nav links, forms, and other content for toggling -->
						
							<?php // echo $this->element('top-nav'); ?>
							
							<ul class="nav navbar-nav secondary">
							
							<?php
								switch ($admn['User']['role']) {		
							    case 'vendor':
							?>
							
								<li>
									<?= $this->Html->link(__('Help'), ['controller' => 'Help', 'action' => 'index'],['class'=>'nav-help']); ?>
								</li>
							
							<?php
							  	break;
									case 'partner':
							?>
							
								<li>
									<?= $this->Html->link(__('Help'), ['controller' => 'Help', 'action' => 'index'],['class'=>'nav-help']); ?>
								</li>
								
							<?php
								  break;
								}
							?>

		            <?php /* Section to display notifications for partners */
			            if(isset($admn['User']['role']) && $admn['User']['role'] == 'partner' && $tot_pnotifications > 0){ ?>
										<li class="dropdown notifications"><a class="dropdown-toggle" data-toggle="dropdown" data-target="#"><span class="visible-xs">Notifications</span> <i class="fa fa-bell"></i> <span class="badge"><?= $tot_pnotifications?></span></a>
			                <ul class="dropdown-menu">
				                <?php echo $this->element('notifications-partner'); ?>
		                  </ul>
		                </li>
		                
		            <?php /* Section to find vendor notifications */
		              } elseif(isset($admn['User']['role']) && $admn['User']['role'] == 'vendor' && $tot_vnotifications > 0) {?>
		                <li class="dropdown notifications"><a class="dropdown-toggle" data-toggle="dropdown" data-target="#"><span class="visible-xs">Notifications</span> <i class="fa fa-bell"></i> <span class="badge"><?= $tot_vnotifications?></span></a>
			                <ul class="dropdown-menu">
			                <?php echo $this->element('notifications-vendor'); ?>
	                    </ul>
		                </li>
		            <?php } ?>
							<div class="promo-highlight"><li class="active"><?=$this->Html->link(__('Book a demo'), ['request' => 'demo'], ['controller' => 'Contact'],['escape' => false, 'title' => 'Book a demo']);?></li></div>
						  	<li class="active logout-link">
									<?php
										if(isset($admn['User'])) {
										$loginname = 'Signed in as <strong>'.$admn['User']['first_name'].' '.$admn['User']['last_name'].'</strong>';
									?>
									
										<?= $this->Html->link($loginname.' <i class="fa fa-wrench"></i>', ['controller' => 'Users', 'action' => 'myaccount'],['escape' => false, 'title' => 'Settings']);?></strong>
										<?= '|' ?>
										<?= $this->Html->link(__('Sign out').' <i class="fa fa-sign-out"></i>', ['controller' => 'Users', 'action' => 'logout'],['escape' => false, 'title' => 'Sign out']); ?>
		                                                          
									<?php } else { ?> 
										
										<?= $this->Html->link(__('Sign in').' <i class="fa fa-sign-in"></i>', ['controller' => 'Users', 'action' => 'login'],['escape' => false, 'title' => 'Sign in']); ?>
										
									<?php } ?>
								</li>
								
							</ul>
							
						</div> <!-- /.navbar-collapse -->
					</div> <!-- /.row -->
				 </div> <!-- /.container -->
			</div> <!-- /.header -->
				
	
			<!-- Main Navigation -->
			<?= $this->element('nav-header'); ?>
	
	
		</div> <!--container(id)-->
	
			
		<?= $this->fetch('content') ?>
		
			
		<footer id="footer">
			
			<div class="footer-container">
				<div class="container">
					
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left">
							<?= $this->Html->image('logos/logo-marketing-connex-mobile.png',['alt'=>'Panovus','width'=>'250','height'=>'94','class'=>'pull-left img-responsive'])?>
						</div>
						<?//= $this->element('nav-footer'); ?>
					</div>
					
					<div class="copyright-container">
						<?= $this->element('copyright'); ?>
					<!-- Last updated 7b7e99847c344baa7ac839c168099d62a35f8168 -->
					</div>
					
				</div> <!-- container -->
			</div> <!--footer-container-->
	
		</footer>	
			
		
	</body>

</html>
