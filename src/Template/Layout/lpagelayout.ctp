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
<head>

	<?= $this->Html->charset() ?>
	
	<title>
	
		
		<?= $this->fetch('title') ?>
		
	</title>
	 <meta name="viewport" content="width=device-width, initial-scale=1">

	<?= $this->Html->meta('icon') ?>
	<?php echo $this->Html->css('bootstrap.min.css') ?>
	<?php echo $this->Html->css('bootstrapValidator.min.css') ?>
        <?php echo $this->Html->css('landingpages/bootstrap-customisation.css') ?>
	<?php echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js');?>
        <?php echo $this->Html->css('https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');?>
        <?php echo $this->Html->css('https://fonts.googleapis.com/css?family=Roboto:400,700,300');?>
	<?php echo $this->Html->script('bootstrap.min.js');?>
	<?php echo $this->Html->script('bootstrapValidator.min.js');?>
	<?php echo $this->Html->script('modernizr.js');?>
	<?php echo $this->Html->script('custom.js');?>
	<?php echo $this->Html->script('respond.min.js');?>
	<?php echo $this->Html->script('selectivizr-min.js');?>
	<?php //echo $this->Html->script('checked-polyfill.js');?>
	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>
	 <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
</head>
<body>
    <div id="content"><?= $this->fetch('content') ?></div>         
                </body>

