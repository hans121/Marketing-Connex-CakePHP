<?php 
$this->layout = 'admin--ui';
?>

<?php
$admn = $this->Session->read('Auth');
$my_currency    =   $admn['User']['currency'];
$this->set(compact('my_currency'));
?>



<?php if(isset($admn['User']['role']) && $admn['User']['role'] == 'vendor' && $tot_vnotifications > 0) { ?>

<div class="alert-wrap">
	<div class="alert alert-warning alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4>Items that need your attention</h4>
		<ul>
			<?php echo $this->element('notifications-vendor'); ?>
		</ul>
	</div>
</div>

<?php } ?>


<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

<ul id="sortable">
<?php
	$position = $sort_position->position;
	$listArr = array(
		1=>"charts",
		2=>"topDeals",
		3=>"campaignsActive",
		4=>"registeredPartners",
		5=>"highestPerforming",
		6=>"lowestPerforming",
		7=>"heatmap",
		8=>"partnerLocations",
		9=>"fundingApproved"
	);
	if($position) {
		$position  = explode(",",$position);
		
		foreach($position as $pos){
			echo "<li id='position-{$pos}'>".$this->element("dashboardWidgets/{$listArr[$pos]}")."</li>";
		}
	}else {
		foreach($listArr as $id=>$element){
			echo "<li id='position-{$id}'>".$this->element("dashboardWidgets/{$element}")."</li>";
		}
	}
?>
</ul>
<script>
  $(function() {
    $( "#sortable" ).sortable({
		update: function(event, ui){
			var dataString = $(this).sortable('serialize');
			
			$.ajax ({
				type: "POST",
				url: "<?php echo $this->Url->build([ "controller" => "Vendors","action" => "index"],true);?>",
				data: dataString,
				cache: false,
				success: function(data){
					//alert(dataString);
				}
			});
		}
	});
    $( "#sortable" ).disableSelection();
  });
</script>