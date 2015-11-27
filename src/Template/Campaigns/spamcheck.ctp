<script type="text/javascript">
  
	var timer = null;
	var maxexec = 0;

	function markNotSpam() {
		$.ajax({
	    url: "<?php echo $this->Url->build([ "controller" => "Campaigns","action" => "marknotspam", $id],true);?>",
	    type: "GET",
	    async: false,
	    success: function (msg) {
  			alert('Campaign email has been marked as passed');
	    },
	    cache: false,
	    contentType: false,
	    processData: false
	  });
	}

	function checkStatus() {
		$.ajax({
	    url: "<?php echo $this->Url->build([ "controller" => "Campaigns","action" => "spamcheck", $checker['TestID']],true);?>",
	    type: "GET",
	    async: false,
	    success: function (msg) {
  			obj = JSON.parse(msg);
  			res = obj.TestingApplications;
  			percentpassed = 0;
  			completed = 0;
  			percent = 0;
  			hits = 0;
  			passed = 0;
  			total = 0;
  			for(var i in res)
  			{
			    app = res[i];
			    if(app.State=='complete')
			    {
			    	completed++;
					if(app.FoundInSpam==true)
						hits++;
					else
						passed++;

					//Update Details
					$('#'+app.Id+'-summary').html((app.FoundInSpam==true?'Failed':'Passed') + (app.SpamScore==0?'':' <small>(with a score of '+app.SpamScore+')</small>') );

					$('#'+app.Id+'-icon').attr('class', (app.FoundInSpam==true?'fa fa-times':'fa fa-check'));

					details = '';

					spamheaders = app.SpamHeaders;
					
	        $('#'+app.Id+'-details').css("display", "none");
	        
					for(var i2 in spamheaders)
					{
						spamhead = spamheaders[i2];
						details += spamhead.Description + " ";
					}
					$('#'+app.Id+'-details').attr('data-content', details);
			    }
			    
  			    if(details > ' ')
  			    {
  	        $('#'+app.Id+'-details').css("display", "inline");
            }

			    total++;
  			}
  			percent = Math.round((completed/total)*100);
  			percentpassed = Math.round((passed/total)*100);
  
  			$('#completed').html(completed);
  			$('.percent').html(percent);
  			$('#hits').html(hits);
  			$('#passed').html(passed);
  			$('#total').html(total);
  			$('#progressbar').attr('aria-valuenow', percent);
  			$('#progressbar').width(percent + '%');
  
  			maxexec++;
  
          if(obj.State=='complete' || obj.State=='completed' || percent==100  || maxexec==500) //limit running till complete or till maxexec
          {
          	clearInterval(timer);
          	if(obj.State=='complete' || obj.State=='completed' || percent==100)
          	{
          		if(hits==0)
          			markNotSpam();          		
          		
          		html = hits==0?"<i class='fa fa-check'></i> Your template has passed the spam check, and is approved for sending":"<i class='fa fa-times'></i> Your template has failed the spam check.  Please edit your template content and check again";
          	}
          	else
          		html = "<i class='fa fa-exclamation-triangle'></i> "+obj.State+": There seems to be a problem with the Spam Check system.  Please try again.  If the problem persists please contact Customer Support";

  	        $('#recommendation').html(html);
  	        $("#spamcheckprogress").css("display", "none");
  	        $("#spamrecheck").css("display", "block");
          }
	    },
	    cache: false,
	    contentType: false,
	    processData: false
	  });
	} 

	$(document).ready(function() {
		//checkStatus();
		timer = setInterval(function () { checkStatus() },5000); // run every 5 secs
    });
    
</script>


<?php
  $res = $checker['CheckerRes'];
  $completed = 0;
  $percent = 0;
  $hits = 0;
  $passed = 0;
  if($total = count($res['TestingApplications']))
  {
  	foreach($res['TestingApplications'] as $app)
  	{
  		if($app['State']=='complete')
  		{
  			$completed++;

  			if($app['FoundInSpam']==true)
				$hits++;
			else
				$passed++;
  		}
  	}
  	$percent = round(($completed/$total)*100);
  }
?>


<div class="Campaigns view">

	<div class="index row table-title vendor-table-title">

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<h2><?= __('Spam check'); ?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Campaigns', ['controller' => 'Campaigns', 'action' => 'index']);
					$this->Html->addCrumb('Spam check', ['controller' => 'Campaigns', 'action' => 'spamcheck', $id]);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Vendors', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		</div>
		
	</div> <!--row-table-title-->

	<div class="row" id="spamcheckprogress">

		<div class="col-xs-10 col-xs-offset-1">
  		
      <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
			
			<h3 class="text-center"><?= __('Please wait while we check your template...'); ?></h3>
		
			<div class="progress spamchecker">
			  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="<?=$percent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$percent?>%" id="progressbar">
			    <span class="sr-only"><span class="percent"><?=$percent?></span>% <?= __('Complete');?></span>
			    <span class="percent"><?=$percent?></span>%
			  </div>
			</div>
	
		</div>
	
	</div>
	
	
	<div class="row inner header-row ">
		<dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4">
			<strong><?= __('Your email template'); ?></strong>
		</dt>
		<dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
			<div class="btn-group pull-right">
            <?= $this->Html->link(__('Re-check').' <i class="fa fa-shield"></i>', ['controller' => 'Campaigns','action' => 'spamcheck',$id],['escape' => false, 'class' => 'btn pull-right', 'id'=>'spamrecheck']); ?>
            <?= $this->Form->postLink(__('Manage').' <i class="fa fa-wrench"></i>', ['controller' => 'EmailTemplates','action' => 'managemail',$id], ['escape' => false, 'class' => 'btn pull-right']); ?>
			</div>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Spam check'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<span id="recommendation">Completed step <span id="completed"><?=$completed?></span><?= ' '.__('of').' '?> <span id="total"><?=$total?></span> <i class="fa fa-circle-o-notch fa-spin"></i></span>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Passed'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8" id="passed">
			<?=$passed?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Failed'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8" id="hits">
			<?=$hits?>
		</dd>
	</div>
	
  <div class="row related">
	
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<h2><?= __('Result analysis');?></h2>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		</div>
		
	</div>
	
	
	<div class="row inner header-row ">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<strong><?= __('Spam filter'); ?></strong>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <strong><?= __('Result'); ?></strong>
		</dd>
	</div>
<?php
$res = $checker['CheckerRes'];
	foreach($res['TestingApplications'] as $app):
?>
	<div class="row inner" id="<?=$app['Id']?>">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __($app['ApplicationLongName']); ?> 
  			<a class="popup" data-toggle="popover" title="<?=$app['ApplicationLongName']?>" data-content="processing..." id="<?=$app['Id']?>-details">
    			<i class="fa fa-info-circle"></i>
  			</a>

	    </dt>
		<dd class="col-lg-7 col-md-7 col-sm-7 col-xs-7" id="<?=$app['Id']?>-summary">
			<?= __('Processing...');?>
		</dd>
		<dd class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-right">
			<i class="fa fa-circle-o-notch fa-spin" id="<?=$app['Id']?>-icon"></i>
		</dd>
	</div>	
<?php
	endforeach;
?>
</div>
