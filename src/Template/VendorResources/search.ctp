<script>
  
	function bulkdelete(){
		if($("input[name='bulkid[]']:checked").length>0)
			if(confirm('Are you sure you want to delete all checked files?'))
			{

				$('#wait').modal('show');

				var test = {};           // Object
				test['id'] = [];          // Array
				$.each($("input[name='bulkid[]']:checked"), function() {
				  test['id'].push($(this).val());
				});

				$.ajax({
				  url: "<?php echo $this->Url->build([ "controller" => "VendorResources","action" => "bulkdelete"],true);?>",
				  type: "POST",
				  data: 'ids='+test['id'],
				  async: false,
				  success: function (msg) {
			  	if(msg=='SUCCESS')
						alert('The selected resources have been deleted.');
					else if(msg=='INVALID')
						alert('Invalid input');
					else
						alert('The selected resources have been deleted. With ' + msg + ' errors');
					$('#wait').modal('hide');
				   	document.location.reload();
				  }
				});

			}

		return false;
	}
  
</script>

<div class="row table-title partner-table-title">

	<div class="partner-sub-menu clearfix">
	
		<div class="col-md-5 col-sm-4 col-xs-6">
			<h2><?= __('Resources'); ?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Resources', ['controller'=>'VendorResources', 'action'=>'index']);
					$this->Html->addCrumb('Search results', ['controller' => 'VendorResources', 'action' => 'search']);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Vendors', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
		
		<div class="col-md-7 col-sm-8 col-xs-6">
			
		</div>
		
	</div>
	
	<div class="row">
	
		<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 hidden-xs filter-form">
			
			<?=$this->Form->create(null, ['url' => ["controller" => "VendorResources", 'action' => 'search']]) ?>

			<div class="input-group input text">
			
				<?=$this->Form->input('keyword',['value' => $keyword,'placeholder' => 'Filter','class' => 'form-control','label' => '','type'=> 'text']);?>
				
				<span class="input-group-btn">
					<?= $this->Form->button('<span class="glyphicon glyphicon-search"></span>',['class'=> 'btn btn-search btn-primary']); ?>   
				</span>
				
			</div>

			<?=$this->Form->end() ?>
			
		</div>

	</div>
	
</div> <!--row-table-title-->

<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

<div class="row table-th hidden-xs">
		
	<div class="clearfix"></div>
	<div class="col-lg-1 col-md-1 col-sm-1">
	</div>
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
	  <?= $this->Paginator->sort('name','Filename') ?>
	</div>
	<div class="col-lg-1 col-md-1 hidden-sm hidden-xs">
		<?= __('Type'); ?>
	</div>
	<div class="col-lg-1 col-md-1 hidden-sm hidden-xs text-right">
		<?= __('Size'); ?>
	</div>
	<div class="col-lg-1 hidden-md hidden-sm">
		<?= $this->Paginator->sort('vendor_id','Vendor') ?>
	</div>
	<div class="col-lg-4 col-md-5 col-sm-5 col-xs-12">
		
	</div>

</div> <!-- /.row .table-th -->
	
<!-- Are there any resources in this folder? -->
	
<?php

		if($resources->count()>0) {
			
?>

<div class="row inner header-row">
	
	<div class="col-md-1 col-sm-1 hidden-xs">
		
	  <?= $this->Form->checkbox('chk[]',['class'=>'css-checkbox','label'=>false,'id'=>'bulk-selector-master-top','name'=>'bulk-selector-master-top'])?>
	  <label for="bulk-selector-master-top" class="css-checkbox-label"></label>
	
	</div>
	
	<div class="col-md-2 col-sm-3 col-xs-12">
		<?= __('Bulk actions')?>
	</div>
	
	<div class="col-md-9 col-sm-8 col-xs-12 btn-group">
    <?= $this->Html->link(__('Delete'), '#',['class' => 'btn btn-danger pull-right','onclick'=>'return bulkdelete()']); ?>
	</div>
	
</div>

<!-- Start loop -->

<?php
  $j =0;
  $kb =0;
  foreach ($resources as $resource):
  $j++;
?>
<div class="row inner hidden-xs">

	<div class="col-lg-1 col-md-1 col-sm-1">
   <?= $this->Form->checkbox('bulkid[]',['class'=>'css-checkbox bulk-selector','value'=>$resource->id,'label'=>false,'id'=>'bulkid-'.$resource->id])?>
   		<label for="bulkid-<?=$resource->id?>" name="" class="css-checkbox-label"> </label>
  </div>
	
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<i class="fa fa-file-o fa-lg"></i> <?= h($resource->name) ?>
	</div>
	
	<div class="col-lg-1 col-md-1 hidden-sm hidden-xs">
		<?= h($resource->type) ?>
	</div>
	
	<div class="col-lg-1 col-md-1 hidden-sm hidden-xs text-right">
		<?= h(round($resource->size/1000) .'KB') ?>
		<?php $kb = $kb + ($resource->size);?>
	</div>
	
	<div class="col-lg-1 hidden-md hidden-sm">
		<?= $resource->has('vendor') ? $resource->vendor->company_name : 'Unassigned' ?>
	</div>

	
	<div class="col-lg-4 col-md-5 col-sm-5 col-xs-12">

		<div class="btn-group pull-right">
			
			<?= $this->Html->link(__('Delete'), ['action'=>'delete',$resource->folder_id,$resource->id], ['confirm' => __('Are you sure you want to delete?', $resource->id),'class' => 'btn btn-danger pull-right']); ?>
			<?= $this->Html->link(__('Edit'), ['controller'=>'VendorResources','action' => 'edit',$resource->folder_id, $resource->id],['class' => 'btn pull-right']); ?>
			<?= $this->Html->link(__('View'), ['controller'=>'VendorResources','action' => 'view', $resource->id],['class' => 'btn pull-right']); ?>
			<?= $this->Html->link(__('Download'), ['controller'=>'VendorResources','action' => 'download', $resource->id],['class' => 'btn pull-right']); ?><!-- needs correct controller/action -->
			
		</div>
	
	</div>
	
</div> <!--row-->
		
		
<div class="row inner filetree visible-xs">

	<div class="col-xs-12">
		
		<a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
			<i class="fa fa-file-o fa-lg"></i> <?= h($resource->name) ?>
		</a>
		
	</div> <!-- /.col -->

	<div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">

		<div class="row inner">
		
		  <div class="col-xs-5">
		    <?= __('File type'); ?>
		  </div>
		  <div class="col-xs-7">
				<!-- File type -->
		  </div>

		</div>
		
		<div class="row inner">
		
		  <div class="col-xs-5">
		    <?= __('File size'); ?>
		  </div>
		  <div class="col-xs-7">
				<!-- File type -->
		  </div>

		</div>
		
		<div class="row inner">
		
		  <div class="col-xs-5">
		    <?= __('Added by'); ?>
		  </div>
		  <div class="col-xs-7">
				<?= $resource->has('user') ? $resource->user->title.' '.$resource->user->full_name : '' ?>
		  </div>

		</div>
		
		<div class="row inner">
		
		  <div class="col-xs-5">
		    <?= __('Added by'); ?>
		  </div>
		  <div class="col-xs-7">
				<?= $resource->has('vendor') ? $resource->vendor->company_name : '' ?>
		  </div>

		</div>
		
		<div class="row inner">
		
		  <div class="col-xs-5">
		    <?= __('User role'); ?>
		  </div>
		  <div class="col-xs-7">
				<?= $this->Paginator->sort('user_role') ?>	
		  </div>

		</div>
		
		<div class="row inner">
			
		  <div class="col-xs-5">
		    <?= __('Created'); ?>
		  </div>
		  <div class="col-xs-7">
				<!-- Create date -->
		  </div>

		</div>
		
		<div class="row inner">
		
		  <div class="col-xs-5">
		    <?= __('Last modified'); ?>
		  </div>
		  <div class="col-xs-7">
				<!-- Modified date -->
		  </div>

		</div>
		
		<div class="row inner">
			
			<div class="col-xs-12">
			
				<div class="btn-group pull-right">
					<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $resource->folder_id, $resource->id], ['confirm' => __('Are you sure you want to delete?', $resource->id),'class' => 'btn btn-danger pull-right']); ?>
					<?= $this->Html->link(__('Edit'), ['controller'=>'VendorResources','action' => 'edit',$resource->folder_id, $resource->id],['class' => 'btn pull-right']); ?>
					<?= $this->Html->link(__('View'), ['controller'=>'VendorResources','action' => 'view', $resource->id],['class' => 'btn pull-right']); ?>
					<?= $this->Html->link(__('Download'), ['controller'=>'VendorResources','action' => 'view', $resource->id],['class' => 'btn pull-right']); ?><!-- needs correct controller/action -->
				</div>
				
			</div>
			
		</div>
				
	</div> <!--collapseOne-->
			
</div> <!--row-->


<?php endforeach; ?>


<!-- End loop -->
<div class="row inner header-row hidden-xs">
	
	<div class="col-md-1 col-sm-1 col-xs-1">
	  <?= $this->Form->checkbox('chk[]',['class'=>'css-checkbox','label'=>false,'id'=>'bulk-selector-master','name'=>'bulk-selector-master'])?>
	  <label for="bulk-selector-master" class="css-checkbox-label"></label>
	</div>
	
	<div class="col-md-2 col-sm-3 col-xs-11">
		<?= __('Bulk actions')?>
	</div>

	<div class="col-md-9 col-sm-8 col-xs-12 btn-group">
    <?= $this->Html->link(__('Delete'), '#',['class' => 'btn btn-danger pull-right','onclick'=>'return bulkdelete()']); ?>
	</div>
	
</div>

<div class="row">
	
  <div class="col-md-12 text-center">
    <p class="participants text-grey"><span id="totparticipants"><?= __('Showing').' '.$j.' '; if ($j=='1'){ echo __('file, using').' ';} else {echo __('files, using').' ';}; echo round($kb/1000) .'KB '.__('bytes of storage space');?></p>
	</div>
	
</div>

<?php
	
	} else {
	
?>

	<div class="row inner">
			
		<div class="col-sm-12 text-center">
			<?=	 __('No resources found in this folder') ?>
		</div>
		
	</div> <!--/.row.inner-->

<?php
	
	}
	
?>

<?= $this->Form->end(); ?>


<?php echo $this->element('paginator'); ?>


<script type="text/javascript">

	$('#bulk-selector-master').click(function() {
	  if ($(this).is(':checked') == true) {
	      $('.bulk-selector').prop('checked', true);
	      $('#bulk-selector-master-top').prop('checked', true);
	  } else {
	      $('.bulk-selector').prop('checked', false);
	      $('#bulk-selector-master-top').prop('checked', false);
	  }
	});
	$('#bulk-selector-master-top').click(function() {
	  if ($(this).is(':checked') == true) {
	      $('.bulk-selector').prop('checked', true);
	      $('#bulk-selector-master').prop('checked', true);
	  } else {
	      $('.bulk-selector').prop('checked', false);
	      $('#bulk-selector-master').prop('checked', false);
	  }
	});
	
</script>


<!-- Modal -->
<div class="modal fade" id="wait" tabindex="-1" role="dialog" aria-labelledby="Please wait..." aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
      
      	<h4 class="text-center">Please wait</h4>
      	<p class="text-center">Please wait until the process completes</p>
      	
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->			
