<script type="text/javascript">
  function ajxcampaign(){
    var dataString = 'qtid='+$('#financialquarter-id').val()+'&bpid=<?= $businesplan->id?>';
    $.ajax ({
      type: "POST",
      url: "<?php echo $this->Url->build([ "controller" => "Businessplans","action" => "getcampaignsofquarter"],true);?>",
      data: dataString,
      cache: false,
      success: function(html)
      {
        $('#campaigngroups').html(html);
        $('#campaigngroups select').selectpicker();   
      }
    });
  }
  function ajaxcalcroi(){
    var dataString = 'campaigns='+$('#campaign-id').val()+'&expresult='+$('#expected-result').val();
    $.ajax ({
    type: "POST",
    url: "<?php echo $this->Url->build([ "controller" => "Businessplans","action" => "getreqamnt"],true);?>",
    data: dataString,
    cache: false,
    success: function(html)
    {
      $('#reqamt').html(html);
    }
	});
  }
  $(document).ready(function() {
    $('#campaigngroups').change(function() {
        ajaxcalcroi();
    });
    $('#expected-result').change(function() {
        ajaxcalcroi();
    });
    $('#financialquarter-id').change(function() {
        ajxcampaign();
    });
         
  });
</script>

<?= $this->Form->create($businesplan); ?>

	<div class="row table-title partner-table-title">
	
		<div class="partner-sub-menu clearfix">
		
			<div class="col-md-5 col-sm-5">
				<?php echo $this->Form->input('financialquarter_id', ['options' => $financialquarters,'data-live-search' => true]);?>
			</div>
			
			<div class="col-md-5 col-sm-5">
				<?php echo $this->element('checkbox-quarter-campaigns');?>	
			</div>
		
		</div>
		
	</div> <!--row-table-title-->


<div class="campaigns form col-centered col-lg-10 col-md-10 col-sm-10">
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
  
	<h2><?= __('Your campaign plan application')?></h2>
	<div class="breadcrumbs">
		<?php
			$this->Html->addCrumb('Campaign Plans', ['controller' => 'Businessplans', 'action' => 'index']);
			$this->Html->addCrumb('edit', ['controller' => 'Businessplans', 'action' => 'edit', $businesplan->id]);
			echo $this->Html->getCrumbs(' / ', [
			    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
			    'url' => ['controller' => 'Partners', 'action' => 'index'],
			    'escape' => false
			]);
		?>
	</div>
   
	<div class="row inner header-row ">
		<dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4">
			<strong><?= h($partner->company_name); ?></strong>
		</dt>
		<dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
			<div class="btn-group pull-right">
	            <?= $this->Html->link(__('Edit'), ['controller'=>'Partners','action' => 'edit', $partner->id],['class' => 'btn pull-right']); ?> 
			</div>
		</dd>
	</div>
    
    
	<fieldset>
	
		<?php
	    $auth =   $this->Session->read('Auth');
	    echo $this->Form->input('business_case');
			echo $this->Form->input('target_customers');
		?>
		
		<h3>Additional details</h3>
    	<!--<div id="reqamt">
	    	<?php //echo $this->Form->input('required_amount',['readOnly'=>true]);?>
	    </div>-->
		<?php
			echo $this->Form->input('target_geography');
			echo $this->Form->input('expected_result');
			//echo $this->Form->input('expected_roi',['label'=>'Expected ROI','value'=>0]);
	    echo $this->Form->input('status',['options'=>['Draft'=>'Draft','Submit'=>'Submit']]);
    ?>
    
   
    <?php echo $this->element('form-submit-bar'); ?>
    
	</fieldset>
	
  <?= $this->Form->end(); ?>
  
</div>

<script type="text/javascript">
	
    ajxcampaign();
    
</script>
