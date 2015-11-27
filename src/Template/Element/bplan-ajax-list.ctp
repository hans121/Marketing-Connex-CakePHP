<!-- Are there any campaign plans? -->
<?php
	if(count($businesplans)>0)
	{
?>

<div class="row table-th hidden-xs">	
	
	<div class="clearfix"></div>
  <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
    <?= $this->Paginator->sort('id','ID') ?>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
    <?= $this->Paginator->sort('partner_id') ?>
  </div>
  <div class="col-lg-1 col-md-1 col-sm-2 col-xs-1">
    <?= $this->Paginator->sort('financialquarter_id','Financial Quarter') ?>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-2 col-xs-3">
    <?= $this->Paginator->sort('campaign','Campaign Name') ?>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
    <?= $this->Paginator->sort('status') ?>
  </div>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
		
	</div>
	
</div> <!--row-table-th-->
	
<!-- Start loop -->


<?php 
		$j =0;
		foreach ($businesplans as $businesplan):
		$j++;
	?>
	
	<div class="row inner hidden-xs">
		
    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
	    
			<?= $this->Number->format($businesplan->id) ?>
			<?php
				if (h($businesplan->status) == 'Submit') {
					if(!in_array($businesplan->id,$myviewedbplnsarray)) {
			?>
        <span class="badge pull-left"><?=__('New')?></span>&nbsp;
      <?php
		    	}
		    }
	    ?>
       
		</div>
		
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
			<?= h($businesplan['partner']->company_name)?>
		</div>
		
		<div class="col-lg-1 col-md-1 col-sm-2 col-xs-1">
			<?= h($businesplan->financialquarter->quartertitle)?>
		</div>
		
		<div class="col-lg-3 col-md-3 col-sm-2 col-xs-1">
			
	    <?php
	      if(isset($businesplan['businesplan_campaigns'][1])) {
	        echo __('Multi');
			?>
			
			<script>
				$(function () {
				  $('[data-toggle="popover"]').popover()
				})				
			</script>
			
			<span role="button" data-toggle="popover" data-container="#ajaxresults" data-trigger="hover" title="<?= __('Campaigns selected')?>" data-placement="bottom" data-content="<?php foreach($businesplan['businesplan_campaigns'] as $bpmulti) { echo $bpmulti['campaign']->name.'. '; } ?>"><i class="fa fa-info-circle"></i></span>
			
			<?php
	      } else {
					$cmpname = '';
					if(isset($businesplan['businesplan_campaigns']['campaign']->name)) {
						$cmpname = $businesplan['businesplan_campaigns']['campaign']->name;
				} else {
					foreach($businesplan['businesplan_campaigns'] as $bpc) {
				  	$cmpname = $bpc['campaign']->name;
					} 
				}
	      echo $cmpname;
	      }
	    ?>
    
		</div>
		
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
			<?php if (h($businesplan->status) == 'Approved') { ?>
				<i class="fa fa-check"></i> <?= __('Approved')?>
			<?php } else if (h($businesplan->status) == 'Denied') { ?>
				<i class="fa fa-times"></i> <?= __('Declined')?>
			<?php } else if (h($businesplan->status) == 'Submit') { ?>
				<i class="fa fa-refresh fa-spin"></i> <?= __('Awaiting decision')?>
			<?php } else { ?>
				<?= h($businesplan->status) ?>
			<?php } ?>
     
    </div>

		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
		
			<div class="btn-group pull-right">
				<?php if($businesplan->status == 'Submit'): ?>
        <?= $this->Html->link(__('Deny'), ['action' => 'approveplan', $businesplan->id,'Denied'], ['onclick' => 'return denywithmsg('.$businesplan->id.')','class' => 'btn btn-danger pull-right']); ?>
        <?= $this->Form->postLink(__('Approve'), ['action' => 'approveplan', $businesplan->id,'Approved'], ['confirm' => __('Are you sure you want to approve?', $businesplan->id),'class' => 'btn btn-success pull-right']); ?>
        <?php endif;?>
        <?= $this->Html->link(__('View'), ['controller'=>'VendorCampaignplans','action' => 'view', $businesplan->id],['class' => 'btn btn-default pull-right']); ?>
			</div>
			
		</div>
		
	</div> <!--row-->
		
		
		<div class="row inner visible-xs">
		
			<div class="col-xs-12 text-center">
				
				<a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
					
					<h3><?= h($businesplan['partner']->company_name)?> - <?= h($businesplan->business_case)?></h3>
					
				</a>
				
			</div> <!--col-->

				
			<div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">
			
				<div class="row inner">
				
					<div class="col-xs-6">
						<?= __('Partner')?>
					</div>
					
					<div class="col-xs-6">
						<?= h($businesplan['partner']->company_name)?>
					</div>
				
				</div>
				
        <div class="row inner">
				
					<div class="col-xs-6">
						<?= __('Financial Quarter')?>
					</div>
					
					<div class="col-xs-6">
						<?= h($businesplan->financialquarter->quartertitle)?>
					</div>
				
				</div>
				
        <div class="row inner">
				
					<div class="col-xs-6">
						<?= __('Business Case')?>
					</div>
					
					<div class="col-xs-6">
						<?= h($businesplan->business_case)?>
					</div>
				
				</div>
                               
        <div class="row inner">
				
					<div class="col-xs-6">
						<?= __('Campaigns')?>
					</div>
					
					<div class="col-xs-6">
	          <?php
              if(isset($businesplan['businesplan_campaigns'][1])){
                echo __('Multi');
              }else{
               $cmpname =   '';
               if(isset($businesplan['businesplan_campaigns']['campaign']->name)){
                   $cmpname =   $businesplan['businesplan_campaigns']['campaign']->name;
               }else{
                   foreach($businesplan['businesplan_campaigns'] as $bpc){
                       $cmpname =   $bpc['campaign']->name;
                   } 
               }

              echo $cmpname;
              }
	          ?>
					</div>
				
				</div>
				
				
        <div class="row inner">
				
					<div class="col-xs-6">
						<?= __('Status')?>
					</div>
					
					<div class="col-xs-6">
						 <?= h($businesplan->status) ?>
						 <?php if(!in_array($businesplan->id,$myviewedbplnsarray)){ ?>
                <span class="badge"><?=__('New')?></span>
             <?php } ?>
					</div>
				
				</div>
				
				<div class="row inner">
				
					<div class="col-xs-12">
					
						<div class="btn-group pull-right">
              <?php if($businesplan->status == 'Submit'): ?>
              <?= $this->Form->postLink(__('Deny'), ['action' => 'approveplan', $businesplan->id,'Denied'], ['confirm' => __('Are you sure you want to deny?', $businesplan->id),'class' => 'btn btn-danger pull-right']); ?>
              <?= $this->Form->postLink(__('Approve'), ['action' => 'approveplan', $businesplan->id,'Approved'], ['confirm' => __('Are you sure you want to approve?', $businesplan->id),'class' => 'btn btn-success pull-right']); ?>
              <?php endif;?>
              <?= $this->Html->link(__('View'), ['controller'=>'VendorCampaignplans','action' => 'view', $businesplan->id],['class' => 'btn pull-right']); ?>
						</div>
						
					</div>
					
				</div>
				
			</div>
			
		</div> <!--row-->
	
	
<!-- End loop -->

			
<?php
  
  endforeach;

	} else {
			
	?>
		
	<div class="row inner withtop">
			
		<div class="col-sm-12 text-center">
			<?=	 __('No Campaign Plans matching your search criteria found') ?>
		</div>
		
	</div> <!--/.row.inner-->
	
	<?php
	
	}
	
?>


