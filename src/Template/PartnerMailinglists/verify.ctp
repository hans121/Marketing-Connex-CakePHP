<script>
var timer;
function verify()
{
	$.ajax({
	    url: "<?php echo $this->Url->build([ "controller" => "PartnerMailinglists","action" => "verify"],true);?>",
	    type: "GET",
	    async: true,
	    cache: false,
	    contentType: false,
	    processData: false,
	    success: function (msg) {
	    //do nothing
	    }
  	});
}
function checkStatus()
{
	$.ajax({
	    url: "<?php echo $this->Url->build([ "controller" => "PartnerMailinglists","action" => "verifyCheck"],true);?>",
	    type: "GET",
	    async: true,
	    cache: false,
	    contentType: false,
	    processData: false,
	    success: function (percent) {
	      	$('#progressbar').attr('aria-valuenow', percent);
		  	$('#progressbar').width(percent + '%');
		  	$('#progressbar').text(percent + '%');
		  	if(percent=='100')
		  	{
		  		clearInterval(timer);
		  		document.location = "<?php echo $this->Url->build([ "controller" => "PartnerMailinglists","action" => "review"],true);?>";
		  	}
	    }
  	});
}
$(document).ready(function(){
	timer = setInterval(function () { checkStatus() },2000); // run every 2 secs
	setTimeout(verify,100);
});
</script>
<div class="businesplans view">

<div class="row table-title partner-table-title">

	<div class="partner-sub-menu clearfix">
	
		<div class="col-md-12 col-xs-12">
			<h2><?= __('Mailing list contact')?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Mailing List', ['controller' => 'PartnerMailinglists', 'action' => 'index']);
					$this->Html->addCrumb('verify contact', ['controller' => 'PartnerMailinglists', 'action' => 'verify']);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Partners', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
	
	</div>
	
</div> <!--row-table-title-->

  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

	<div class="row">   
	    <div class="col-lg-12">
			<div class="progress progress-plain">
			  <div class="progress-bar" id="progressbar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">
			    0%
			  </div>
			</div>
	    </div>
	</div>
	
</div>