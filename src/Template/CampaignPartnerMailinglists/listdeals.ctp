<script type="text/javascript">
	
  function ajxfltr() {
    var id = $("#campaign").val();
    var dataString = 'campaign_id='+id;
    $.ajax ({
      type: "POST",
      url: "<?php echo $this->Url->build([ "controller" => "CampaignPartnerMailinglists","action" => "ajaxlistdeals"],true);?>",
      data: dataString,
      cache: false,
      success: function(html)
      {
        $('#ajax-list').html(html);
      }
    });
  }
  $(document).ready(function() {
    $('#campaign').change(function() {
      ajxfltr() ;
    });
  });
  
    
    function exportdata(){
        document.location.href =  "<?php echo $this->Url->build([ "controller" => "CampaignPartnerMailinglists","action" => "exportdeals"],true);?>/"+$('#campaign').val();   
    }  
    $(document).ready(function(){
        $('#exprtlst').click(function() {
	    exportdata();
        }); 
    });
    $(document).ready(function() {
    $('#campaign').change(function() {
      ajxfltr() ;
    });
  });

    
</script>


<div class="campaignPartnerMailinglists index">

	<div class="row table-title partner-table-title">

		<div class="partner-sub-menu clearfix">
		
			<div class="col-md-6 col-sm-4">
				<?php echo $this->Form->input('campaign', ['options' => $my_camp_list,'empty'=>'Filter by campaign','data-live-search' => true]);?>
			</div>
			
			<div class="col-md-6 col-sm-8">
				<div class="btn-group pull-right">
					<?= $this->Html->link(__('Register a deal'), ['action'=>'index/1'],['class'=>'btn btn-lg pull-right']); ?>
					<?= $this->Html->link(__('Export List'), '#',['class'=>'pull-right btn btn-lg','id'=>'exprtlst']); ?>

				</div>
			</div>
	
		</div>

	</div> <!--row-table-title-->
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<div id="ajax-list">
		 <?php echo $this->element('deals-ajax-list-all'); ?>
	</div>

</div>
