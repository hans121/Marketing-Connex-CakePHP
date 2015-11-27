<div class="campaignPartnerMailinglists index">
			
	<div class="row table-title partner-table-title">
	
		<div class="partner-sub-menu clearfix">
		
			<div class="col-md-6 col-sm-4">
				<h2><?= __('Partners')?></h2>
				<div class="breadcrumbs">
					<?php
						$this->Html->addCrumb('Partners', ['controller' => 'Vendors', 'action' => 'partners']);
						$this->Html->addCrumb('upload partners', ['controller' => 'Vendors', 'action' => 'importpartners']);
						echo $this->Html->getCrumbs(' / ', [
						    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
						    'url' => ['controller' => 'Vendors', 'action' => 'index'],
						    'escape' => false
						]);
					?>
				</div>
			</div>
			
			<div class="col-md-6 col-sm-8">
				
				<div class="btn-group pull-right hidden-xs">
  				<?= $this->Html->link(__('CSV Template').' <i class="fa fa-cloud-download"></i>', ['action' => 'getexportcsvtemplate'], ['escape' => false, 'title' => 'Export dashboard data', 'class'=>'pull-right btn btn-lg']); ?> 				
				</div>
				
			</div>
		
		</div>
		
	</div> <!--row-table-title-->
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
    
	<div class="form col-centered col-lg-10 col-md-10 col-sm-10">
			
	   <?= $this->Form->create(null,['type'=>'file']); ?>
	
		<h3><?= __('Upload partners')?></h3>
		
		<fieldset>
	        
			<div class="row table-th">	
				<div class="col-lg-4 col-md-4 col-sm-4">
					<?= __('Select CSV file'); ?>
	                            <?php $csvmsg   =   __("Please download our CSV template to be sure your data is arranged in the correct format. After editing, save it as a 'Windows comma separated (.csv)' file to ensure compatibility.");?>
					<?= '<a class="popup" data-toggle="popover" data-content="'.$csvmsg.'"><i class="fa fa-info-circle"></i></a>';?>
				</div>		
			</div>
			<div class="row inner">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
				</div>
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
					<span class="file-wrapper ">
              <?= $this->Form->input('partnerscsv',['type' =>'file','id' =>'partnerscsv', 'label'=>FALSE]);?>
						<span class="btn pull-right button ">Choose</span>
					</span>
				</div>	
			</div>
	   
	    <?php echo $this->element('form-submit-bar'); ?>
	    
		</fieldset>
		
	  <?= $this->Form->end(); ?>
	  
	</div>
	
</div> <!-- /#content -->
