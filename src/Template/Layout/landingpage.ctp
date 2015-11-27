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
?>


<!DOCTYPE html>
<html lang="en" class="no-js">

	<?= $this->Html->charset() ?>
	
	<title>
		<?= $this->fetch('title') ?>
	</title>
	 <meta name="viewport" content="width=device-width, initial-scale=1">

	<?= $this->Html->meta('icon') ?>
	<?php echo $this->Html->css('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css') ?>
	<?php echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js');?>
    <?php echo $this->Html->css('https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');?>
    <?php echo $this->Html->css('https://fonts.googleapis.com/css?family=Roboto:400,300,100,500');?>
     <!-- custom styles -->
   <?php echo $this->Html->css('/css/landingpages/style.min.css');?>
	<?php echo $this->Html->script('http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css');?>
	<?php echo $this->Html->script('bootstrap.min.js');?>
	<?php echo $this->Html->script('modernizr.js');?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
		<?php echo $this->Html->script('https://oss.maxcdn.com/respond/1.4.2/respond.min.js');?>
    <![endif]-->

	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>
	 <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
		
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

	      var e = $(".contact-tel, .contact-ref");
	      e.html("");
	      e.html(formatted_number);
	      
	      e.attr("href", "tel:"+formatted_number);
	      e.attr("title", "Call us on:"+formatted_number);
	    };

	
	$(document).ready(function() {
	
		$("a.download").each(function() {
			var href = $(this).attr("href");
			var target = $(this).attr("target");
			var text = $(this).text();
			$(this).click(function(event) { // when someone clicks these links
				event.preventDefault(); // don't open the link yet
				ga('send', 'event', 'Downloads', 'Clicked', href);
				setTimeout(function() { // now wait 300 milliseconds...
					window.open(href,(!target?"_self":target)); // ...and open the link as usual
				},300);
			});
		});
	
	});
	  </script>

</head>

<body onload="_googWcmGet(callback, '+44 1628 564920');">
    <!-- header -->
    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 col-md-6">
								<?= $this->Html->image('/img/landingpages/10-things/logo.png', [ 'alt'=>'Marketing Connex','class'=>'img-responsive','id'=>'brand-logo-img','url' => '/']);?>						
	                
	            </div>
                <div class="col-sm-6 col-md-6">
                    <div class="header--contact">
	                    <p>
						<a href="tel:+441628564920" title="<?= __('Call us on +44 1628 564 920')?>" id="contact-tel" class="contact-tel">+44 1628 564 920</a><br/>
						<a href="mailto:contact@marketingconnex.com" title="<?= __('Email us on contact@marketingconnex.com')?>" class="contact-email">contact@marketingconnex.com</a>
	                    </p>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- /header -->
    
    <?= $this->fetch('content') ?>         
   

    <footer class="landing--page_footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Ready to turn your partners into profit?</h1>
                    <h2>with the #1 Partner Channel Management platform</h2>
 				<?= $this->Html->link(__('Book a demo'),['controller' => 'Contact','action' => 'index','request' => 'demo'],['escape' => false, 'title' => 'Book a demo','class'=>'btn btn-primary']);?>
            </div>
        </div>
        </div>
    </footer>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- Modernizr -->
    <script src="./assets/js/min/modernizr-2.8-3.min.js"></script>
</body>

</html>    