<?php
	$cakeDescription = $portal_settings['site_name'].' - '.$portal_settings['site_description'];
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
	
		<?php //php echo $this->Html->css('bootstrap.min.css'); ?>
		<?php echo $this->Html->css('formValidation.min.css');?>
		<?php //php echo $this->Html->css('cake.generic.css');?>
		<?php echo $this->Html->css('jquery-ui.css');?>
		<?php echo $this->Html->css('jquery-ui.structure.css');?>
		<?php echo $this->Html->css('jquery-ui.theme.css');?>
		<?php echo $this->Html->css('jquery-ui-timepicker-addon.css');?>
		<?php echo $this->Html->css('https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900');?>
	  	<?php echo $this->Html->css('https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');?>
		<?php echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js');?>
		<?php echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js');?>
		<?php echo $this->Html->script('jquery-ui-timepicker-addon.js');?>
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
		<?php echo $this->Html->script('ckeditor/ckeditor.js');?>
		<?php echo $this->Html->script('bootbox.min.js');?>


		
		<!-- Jasny Bootstrap extension -->
		<?php echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css');?>
		<?php echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js');?>
		
		
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
	  

	  	<!-- UI Styles CSS -->
	    <?php echo $this->Html->css('ui/assets/css/min/style.min.css');?>
	    <?php //php echo $this->Html->css('ui/assets/css/min/bootstrap-switch.min.css');?>
	    <?php echo $this->Html->css('http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css');?>
	    <?php echo $this->Html->css('https://fonts.googleapis.com/icon?family=Material+Icons');?>
		<?php echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/css/bootstrap-select.min.css');?>

		<!-- UI Scripts JS -->
		<?php echo $this->Html->script('https://storage.googleapis.com/code.getmdl.io/1.0.0/material.min.js');?>
		<?php echo $this->Html->script('//code.jquery.com/ui/1.11.4/jquery-ui.js');?>
		<?php echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/js/bootstrap-select.min.js');?>
		<?php echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js');?>
		<?php echo $this->Html->script('ui/assets/js/min/bootstrap-switch.min.js');?>



	  
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
	
	</head>
	
	
	<body
		<?php // set the class based on the user-role
			switch ($admn['User']['role']) {		
		    case 'superadmin':
		?>
				class="admin"					
		<?php
				break;
			  case 'admin':
		?>
				class="admin"					
		<?php
				break;
			  case 'vendor':
		?>
				class="vendor"					
		<?php
			  break;
			  case 'partner':
		?>
				class="partner"					
		<?php
			  break;
			  default:
		?>
				class="frontend"					
		<?php
			  break;
			}
		?>
	>

		<?php // Display notifications for partners
		$tot_pnotifications =   0;
		$tot_vnotifications =   0;
		$tot_pnotifications +=  $partner_new_campaigns+$partner_approved_bp+$partner_denied_bp+$new_bp_alert;
		$tot_vnotifications +=  $vendor_sbmt_bp;
	?>
	 <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <header class="mdl-layout__header">
            <div class="mdl-layout__header-row">
                <!-- Title -->
                <span class="mdl-layout-title"></span>
                <!-- Add spacer, to align navigation to the right -->
				<?php
				switch ($admn['User']['role']) {		

				case 'vendor':
				?>

				<div class="mdl-layout-spacer"></div>

				<?php
				if(isset($admn['User'])) {
				$loginname = $admn['User']['first_name'].' '.$admn['User']['last_name'];
				?>
				<div class="dropdown">
				<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				<?= $loginname = '<i class="icon ion-person"></i> '. $admn['User']['first_name'].' '.$admn['User']['last_name'];;?>
				<span class="caret"></span>
				</button>
				<ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
				<li>
				<?= $this->Html->link('<i class="icon ion-gear-b"></i> '.__('Settings'), ['controller' => 'Users', 'action' => 'myaccount'],['escape' => false, 'title' => 'Settings']);?></li>
				<!--<li>
				<?= $this->Html->link('<i class="icon ion-help"></i> '.__('Help'), ['controller' => 'Help', 'action' => 'index'],['class'=>'nav-help', 'escape' => false, 'title' => 'Help']); ?></li>-->
				<li>
				<?= $this->Html->link('<i class="icon ion-unlocked"></i> '.__('Sign out'), ['controller' => 'Users', 'action' => 'logout'],['escape' => false, 'title' => 'Sign out']); ?>
			    </li>
				<li><?= $this->Html->link('<i class="icon ion-archive"></i> '.__('Export data').' '.$this->Html->tag('span',__('',false)), ['action' => 'export'], ['escape' => false, 'title' => 'Export dashboard data']); ?>
				</li>
				<li><?= $this->Html->link('<i class="icon ion-person-stalker"></i> '.__('Company Profile'), ['controller' => 'Vendors', 'action' => 'profile'], ['escape' => false]); ?>
				</li>
				</ul>
				</div>

                <?php } ?>

				<?php
				break;

				case 'partner':
				?>


				<?php /* Section to display notifications for partners */
				if(isset($admn['User']['role']) && $admn['User']['role'] == 'partner' && $tot_pnotifications > 0) { ?>

				<div class="dropdown notifications">
				<a class="dropdown-toggle" data-toggle="dropdown" data-target="#"><i class="icon ion-ios-bell-outline"></i> <span class="badge"><?= $tot_pnotifications?></span></a>
				<ul class="dropdown-menu" aria-labelledby="dLabel">
				<?php echo $this->element('notifications-partner'); ?>	
				</ul>
				</div>

				<?php } ?>
				<div class="mdl-layout-spacer"></div>

				<?php
				if(isset($admn['User'])) {
				$loginname = $admn['User']['first_name'].' '.$admn['User']['last_name'];
				?>
				<div class="dropdown">
				<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				<?= $loginname = '<i class="icon ion-person"></i> '. $admn['User']['first_name'].' '.$admn['User']['last_name'];;?>
				<span class="caret"></span>
				</button>
				<ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
				<li>
				<?= $this->Html->link('<i class="icon ion-gear-b"></i> '.__('Settings'), ['controller' => 'Users', 'action' => 'myaccount'],['escape' => false, 'title' => 'Settings']);?></li>
				<!--
				<li>
				<?= $this->Html->link('<i class="icon ion-help"></i> '.__('Help'), ['controller' => 'Help', 'action' => 'index', 'class'=>'nav-help', 'escape' => false]); ?>
				</li>
				-->
				<li>
				<?= $this->Html->link('<i class="icon ion-unlocked"></i> '.__('Sign out'), ['controller' => 'Users', 'action' => 'logout'],['escape' => false, 'title' => 'Sign out']); ?>
			    </li>
				<li><?= $this->Html->link('<i class="icon ion-archive"></i> '.__('Export data').' '.$this->Html->tag('span',__('',false)), ['controller'=>'Partners', 'action' => 'export'], ['escape' => false, 'title' => 'Export dashboard data']); ?>
				</li>
				</ul>
				</div>

                <?php } ?>

				<?php
				break;
				}
				?>
                <!-- /header sub nav -->
            </div>
        </header>
        <!-- nav drawer case select output-->
        <?php
			
		$admn = $this->Session->read('Auth');
				 
		switch ($admn['User']['role']) {
		case 'vendor':
		?>
        <!-- vendor -->
		<?= $this->element('new-ui/headers/nav--header_vendor'); ?>

		<?php
		break;
		case 'partner':
		?>
		<!-- partner -->
		<?= $this->element('new-ui/headers/nav--header_partner'); ?>

		<?php 
		break;
		}
		?>
        <!-- /nav drawer -->
        <!-- /nav drawer -->
        <main class="mdl-layout__content">
            <div class="page-content">
                <!-- Your content goes here -->
    			<?= $this->Flash->render();?>
					<?= $this->fetch('content');?>
				<?= $this->element('new-ui/footers/footer--admin'); ?>

            </div>
        </main>

    </div>
	

			

			
	</body>

</html>
