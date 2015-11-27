<script type="text/javascript">

	// Modal Image Viewer Line
	function showImageModal(label,classes,image) {
		$('#fullimageModalLabel').text(label);
		$('#fullimageModalBody').html('<div class="'+classes+'"><div class="browser-mask"><img src="http://'+image+'" class="img-responsive center-block" /></div></div>');
		$('#fullimageModal').modal('show');
	} 

  	// Check Status Line
	var timer = null;
	var maxexec = 0;

	function assignImage(appID,appName,appLongName,appPlatform,appThumb,appImg) {
		if(appThumb.indexOf("http://")!=-1)
		{
			appThumb = appThumb.replace('http://','');
			appImg = appImg.replace('http://','');
		}

		if(appThumb.indexOf("https://")!=-1)
		{
			appThumb = appThumb.replace('https://','');
			appImg = appImg.replace('https://','');
		}
		if(appThumb=='s3.amazonaws.com' || appThumb=='') {
			$('#'+appID+'-preview').html('no preview available');
			$('#'+appID+'-icon').attr('class', 'fa fa-times');
		}
		else
			$.ajax({
			    url: appThumb,
			    type: "GET",
			    async: true,
			    error: function (xhr) {
			    	$('#'+appID+'-preview').html('no preview available');
			    	$('#'+appID+'-icon').attr('class', 'fa fa-times');
			    },
			    success: function (msg) {
			    	$('#'+appID+'-preview').html('<div class="btn" onclick="showImageModal(\''+appLongName+'\',\'fullimage '+appPlatform+' '+appName+'\',\''+appImg+'\')">View</div>');
			    	$('#'+appID+'-icon').attr('class', 'fa fa-check');
			    },
			});
	}

	function checkStatus() {
		$.ajax({
	    url: "<?php echo $this->Url->build([ "controller" => "Campaigns","action" => "browsercheck", $checker['TestID']],true);?>",
	    type: "GET",
	    async: true,
	    success: function (msg) {
  			obj = JSON.parse(msg);
  			res = obj.TestingApplications;
  			completed = 0;
  			percent = 0;
  			total = 0;
  			for(var i in res)
  			{
			    app = res[i];
			    if(app.State=='complete' || app.State=='error')
			    {
			    	completed++;
			    	if(app.State=='complete')
			    	{
				    	var platform = app.PlatformName;
				    		platform = platform.toLowerCase();
				    		platform = platform.replace(' ','-');

				    	var appname = app.ApplicationName;
				    		appname = appname.toLowerCase();
				    		
						//Update Details
						if($('#'+app.Id+'-preview').text()=='Processing...')
							assignImage(app.Id,appname,app.ApplicationLongName,platform,app.FullpageImageThumbNoContentBlocking,app.FullpageImageNoContentBlocking);
					}
					else if(app.State=='error')
					{
						$('#'+app.Id+'-preview').html('no preview available');
						
						$('#'+app.Id+'-icon').attr('class', 'fa fa-times');
					}
			    }

			    total++;
  			}
  			percent = Math.round((completed/total)*100);
  
  			$('#completed').html(completed);
  			$('.percent').html(percent);
  			//$('#hits').html(hits);
  			//$('#passed').html(passed);
  			$('#total').html(total);
  			$('#progressbar').attr('aria-valuenow', percent);
  			$('#progressbar').width(percent + '%');
  
  			maxexec++;
  
          if(obj.State=='complete' || obj.State=='completed' || percent==100  || maxexec==50) //limit running till complete or till maxexec
          {
          	clearInterval(timer);
          	if(obj.State=='complete' || obj.State=='completed' || percent==100)
          	{          		
          		html = "<i class='fa fa-check'></i> Finished browser-testing your email template. Please review the images below";
          	}
          	else
          		html = "<i class='fa fa-exclamation-triangle'></i> "+obj.State+": There seems to be a problem with the browser-testing system. A timeout has occured. Please try again later.  If the problem persists please contact Customer Support";

          	for(var i in res)
  			{
			    app = res[i];
			    if(app.State!='complete')
			    {
					$('#'+app.Id+'-preview').html('no preview available');
					$('#'+app.Id+'-icon').attr('class', 'fa fa-times');
			    }
  			}

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
		//timer = setInterval(function () { checkStatus() },5000); // run every 5 secs
    });
    
</script>


<?php
  $res = $checker['CheckerRes'];
  $completed = 0;
  $percent = 0;
  //$hits = 0;
  //$passed = 0;
  if($total = count($res['TestingApplications']))
  {
  	foreach($res['TestingApplications'] as $app)
  	{
  		if($app['State']=='complete')
  		{
  			$completed++;

  			//if($app['FoundInSpam']==true)
				//$hits++;
			//else
				//$passed++;
  		}
  	}
  	$percent = round(($completed/$total)*100);
  }
?>


<div class="Campaigns view">

	<div class="index row table-title vendor-table-title">

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<h2><?= __('Client Browser Preview'); ?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Campaigns', ['controller' => 'Campaigns', 'action' => 'index']);
					$this->Html->addCrumb('Browser check', ['controller' => 'Campaigns', 'action' => 'browsercheck', $id]);
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
			
			<h3 class="text-center"><?= __('Please wait while we process your template...'); ?></h3>
		
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
            <?= $this->Html->link(__('Re-check').' <i class="fa fa-desktop"></i>', ['controller' => 'Campaigns','action' => 'browsercheck',$id],['escape' => false, 'class' => 'btn pull-right', 'id'=>'spamrecheck']); ?>
            <?= $this->Form->postLink(__('Manage').' <i class="fa fa-wrench"></i>', ['controller' => 'EmailTemplates','action' => 'managemail',$id], ['escape' => false, 'class' => 'btn pull-right']); ?>
			</div>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Browser-testing'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<span id="recommendation">Completed step <span id="completed"><?=$completed?></span><?= ' '.__('of').' '?> <span id="total"><?=$total?></span> <i class="fa fa-circle-o-notch fa-spin"></i></span>
		</dd>
	</div>

	
  <div class="row related">
	
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<h2><?= __('Previews');?></h2>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		</div>
		
	</div>
	
	
	<div class="row inner header-row ">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<strong><?= __('Browser'); ?></strong>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <strong><?= __('Preview'); ?></strong>
		</dd>
	</div>
<?php
	foreach($res['TestingApplications'] as $app):
?>
	<div class="row inner" id="<?=$app['Id']?>">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __($app['ApplicationLongName']); ?>
	    </dt>
		<dd class="col-lg-7 col-md-7 col-sm-7 col-xs-7" id="<?=$app['Id']?>-preview"><?= __('Processing...');?></dd>
		<dd class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-right">
			<i class="fa fa-circle-o-notch fa-spin" id="<?=$app['Id']?>-icon"></i>
		</dd>
	</div>	
<?php
	endforeach;
?>
</div>

<!-- Modal -->
<div class="modal fade hidden-sm hidden-xs" id="fullimageModal" tabindex="-1" role="dialog" aria-labelledby="fullimageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="fullimageModalLabel">Modal title</h4>
      </div>
      <div class="modal-body" id="fullimageModalBody">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>