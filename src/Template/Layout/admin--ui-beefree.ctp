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
	
		<?php echo $this->Html->css('https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900');?>
	  	<?php echo $this->Html->css('https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');?>
		<?php echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js');?>
		<?php echo $this->Html->script('bootstrap.min.js');?>
		<?php echo $this->Html->script('modernizr.js');?>
		<?php echo $this->Html->script('respond.min.js');?>
		<?php echo $this->Html->script('selectivizr-min.js');?>


		
		
	 

	  	<!-- UI Styles CSS -->
	    <?php echo $this->Html->css('ui/assets/css/min/style.min.css');?>
	    <?php echo $this->Html->css('http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css');?>
	    <?php echo $this->Html->css('https://fonts.googleapis.com/icon?family=Material+Icons');?>
		<?php echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/css/bootstrap-select.min.css');?>
		<?php echo $this->Html->css('beefree.css');?>

		<!-- UI Scripts JS -->
		<?php echo $this->Html->script('https://storage.googleapis.com/code.getmdl.io/1.0.0/material.min.js');?>
		<?php echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/js/bootstrap-select.min.js');?>


	  
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

	
	 <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <header class="mdl-layout__header">
            <div class="mdl-layout__header-row">
                <!-- Title -->
                <span class="mdl-layout-title"></span>
                <!-- Add spacer, to align navigation to the right -->
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
				<?= $this->Html->link(__('Settings'), ['controller' => 'Users', 'action' => 'myaccount'],['escape' => false, 'title' => 'Settings']);?></li>
				<li>
				<?= $this->Html->link(__('Help'), ['controller' => 'Help', 'action' => 'index'],['class'=>'nav-help']); ?></li>
				<li>
				<?= $this->Html->link(__('Sign out'), ['controller' => 'Users', 'action' => 'logout'],['escape' => false, 'title' => 'Sign out']); ?></li>
				</ul>
				</div>

                <?php } ?>
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
                <!-- Your content goes here -->
    			<?= $this->Flash->render();?>
					<?= $this->fetch('content');?>
				<?= $this->element('new-ui/footers/footer--admin'); ?>

    </div>
	

			

			
	</body>

</html>
