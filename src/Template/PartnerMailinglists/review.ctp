<div class="businesplans view">

<div class="row table-title partner-table-title">

	<div class="partner-sub-menu clearfix">
	
		<div class="col-md-12 col-xs-12">
			<h2><?= __('Mailing list contact')?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Mailing List', ['controller' => 'PartnerMailinglists', 'action' => 'index']);
					$this->Html->addCrumb('review contacts', ['controller' => 'PartnerMailinglists', 'action' => 'review']);
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
			<div class="canvas-holder">
				<canvas id="chart-area"></canvas>
			</div>
	    </div>
	</div>
	<div class="row submit-bar">
		<div class="col-md-12">
			<?= $this->Html->link(__('Cancel Upload'), ['action'=>'addcsv',$grp_id],['class' => 'pull-left btn btn-lg btn-cancel']); ?>			
			<?= $this->Html->link(__('Continue'), ['action'=>'verifySave',$grp_id],['class' => 'pull-right btn btn-lg']); ?>
		</div>
	</div>
	
</div>
<script>
	
	/*!	
	 * Chart.js
	 * http://chartjs.org/
	 * Version: 1.0.1-beta.4
	 *
	 * Copyright 2014 Nick Downie
	 * Released under the MIT license
	 * https://github.com/nnnick/Chart.js/blob/master/LICENSE.md
	 */
	 
	/* Campaigns */
	var CampaignStatus = [
		{
			value: <?=$verification_valid?>,
			color:"#AD0061",
			highlight: "#e553a5",
			label: "Valid"
		},
		{
			value: <?=$verification_invalid?>,
			color: "#57968F",
			highlight: "#5AD3D1",
			label: "Invalid"
		},
		{
			value: <?=$verification_suspect?>,
			color: "#FFAC00",
			highlight: "#FFD022",
			label: "Suspect"
		},
		{
			value: <?=$verification_indeterminate?>,
			color: "#888888",
			highlight: "#a6a5a6",
			label: "Indeterminate"
		},
		{
			value: <?=$verification_error?>,
			color: "#ff0000",
			highlight: "#ff6161",
			label: "Error"
		}
	];
	var helpers = Chart.helpers;
	var ctx = document.getElementById("chart-area").getContext("2d");
	var CampaignDoughnut = new Chart(ctx).Doughnut(CampaignStatus, {
		responsive : true,
		animateScale : true,
		segmentStrokeColor : "#fff",
		segmentStrokeWidth : 2,
		tooltipTemplate : "<%if (label){%><%=label%> (<%}%><%= value %>)",
		tooltipTitleFontFamily : "'Roboto', sans-serif",
		tooltipTitleFontSize : 8,
		legendTemplate : "<div class=\"pull-left\"><ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span> <%if(segments[i].label){%><%=segments[i].label%><%}%> (<%=segments[i].value%>)<%if(segments[i].value){%> - <a href=\"<?php echo $this->Url->build([ "controller" => "PartnerMailinglists","action" => "verifyDownload"],true);?>/<%=segments[i].label.toLowerCase()%>\" class=\"text-primary\">Download Report</a><%}%></li><%}%></ul></div>"
		}
	);
	
	var legendHolder = document.createElement('div');
	
	legendHolder.innerHTML = CampaignDoughnut.generateLegend();
	
	// Include a html legend template after the module doughnut itself
	helpers.each(legendHolder.firstChild.childNodes, function (legendNode, index) {
	  helpers.addEvent(legendNode, 'mouseover', function () {
	    var activeSegment = CampaignDoughnut.segments[index];
	    activeSegment.save();
	    CampaignDoughnut.showTooltip([activeSegment]);
	    activeSegment.restore();
	  });
	});
	helpers.addEvent(legendHolder.firstChild, 'mouseout', function () {
	    CampaignDoughnut.draw();
	});
	
	CampaignDoughnut.chart.canvas.parentNode.parentNode.appendChild(legendHolder.firstChild);
	
</script>