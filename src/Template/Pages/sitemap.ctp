<?php
	$i=0;
	$sub_packages   = array();
	foreach ($packages as $package): 
    if($i < 4)
      $sub_packages[$i]   =   $package;
    $i++;
	endforeach;
?>

<div id="content" class="section-white-fade">
	<div class="container">

    <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
		<?= $this->fetch('content') ?>
		
		<h1 class="text-center"><?= __('Site Map')?></h1>
			
	</div> <!-- container(class)-->
</div>
