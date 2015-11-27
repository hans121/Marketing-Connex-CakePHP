<?php 
$this->layout = 'admin--ui';
?>



<?php 
$admn = $this->Session->read('Auth');
$my_currency    =   $admn['User']['currency'];
$this->set(compact('my_currency'));
?>

<?php if(isset($admn['User']['role']) && $admn['User']['role'] == 'partner' && $tot_pnotifications > 0) { 
	?>

	<div class="alert-wrap">
		<div class="alert alert-warning alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4>Items that need your attention</h4>
			<ul>
				<?php echo $this->element('notifications-partner'); ?>
			</ul>
		</div>  
	</div>

	<?php 
} 
?>


<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

<?= $this->element('dashboardWidgets/partner/activeCampaigns'); ?>

<?= $this->element('dashboardWidgets/partner/upcomingCampaigns'); ?>

<?= $this->element('dashboardWidgets/partner/partnerManagerLeague'); ?>
