<?php 
$this->layout = 'admin';
?>

<script>
  
	function bulkdelete(){
		if($("input[name='bulkid[]']:checked").length>0)
			if(confirm('Are you sure you want to delete all checked pages?'))
			{
				var delids = {};           // Object
				delids['id'] = [];          // Array
				$.each($("input[name='bulkid[]']:checked"), function() {
				  delids['id'].push($(this).val());
				});

				$.ajax({
				  url: "<?php echo $this->Url->build([ "controller" => "VendorPages","action" => "bulkdelete"],true);?>",
				  type: "POST",
				  data: 'ids='+delids['id'],
				  async: false,
				  success: function (msg) {
			  	if(msg=='SUCCESS')
						alert('The selected pages have been deleted.');
					else
						alert('The selected pages have been deleted. With ' + msg + ' failed.');
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
			<h2><?= __('Pages'); ?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Pages', ['controller'=>'VendorPages', 'action'=>'index']);
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
			
			<?=$this->Form->create(null, ['url' => ['action' => 'search']]) ?>

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
	<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
	  <?= $this->Paginator->sort('title','Page Title') ?>
	</div>
	<div class="col-lg-2 hidden-md hidden-sm">
		<?= $this->Paginator->sort('status','Publish Status') ?>
	</div>
	<div class="col-lg-4 col-md-5 col-sm-5 col-xs-12">
		
	</div>

</div> <!-- /.row .table-th -->

<?php
	if($pages->count()>0) {
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

<?php
	}
?>

<!-- Are there any pages in this folder? -->
	
<?php

if($pages->count()>0) {
			
?>

<!-- Start loop -->

<?php
	$j =0;
	$kb =0;
	foreach ($pages as $page):
	$j++;
?>
<div class="row inner">

	<div class="col-lg-1 col-md-1 col-sm-1">
   <?= $this->Form->checkbox('bulkid[]',['class'=>'css-checkbox bulk-selector','value'=>$page->id,'label'=>false,'id'=>'bulkid-'.$page->id])?>
   		<label for="bulkid-<?=$page->id?>" name="" class="css-checkbox-label"> </label>
  </div>
	
	<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
		<i class="fa fa-file-o fa-lg"></i> <?= $this->Html->link(h($page->title), ['controller'=>'VendorPages','action' => 'view', $page->id]); ?>
	</div>
	
	<div class="col-md-1 hidden-sm hidden-xs">
		<?= __($page->status=='Y'?'Published':'Private') ?>
	</div>

	
	<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">

		<div class="btn-group pull-right">
			
			<?= $this->Html->link(__('Delete'), ['action'=>'delete',$parentmenu->id,$page->id], ['confirm' => __('Are you sure you want to delete?', $page->id),'class' => 'btn btn-danger pull-right']); ?>
			<?= $this->Html->link(__('Edit'), ['controller'=>'VendorPages','action' => 'edit',$parentmenu->id, $page->id],['class' => 'btn pull-right']); ?>
			
		</div>
	
	</div>
	
</div> <!--row-->

<?php endforeach; ?>

<div class="row inner header-row">
	
	<div class="col-md-1 col-sm-1 hidden-xs">
		
	  <?= $this->Form->checkbox('chk[]',['class'=>'css-checkbox','label'=>false,'id'=>'bulk-selector-master','name'=>'bulk-selector-master'])?>
	  <label for="bulk-selector-master" class="css-checkbox-label"></label>
	
	</div>
	
	<div class="col-md-2 col-sm-3 col-xs-12">
		<?= __('Bulk actions')?>
	</div>
	
	<div class="col-md-9 col-sm-8 col-xs-12 btn-group">
    <?= $this->Html->link(__('Delete'), '#',['class' => 'btn btn-danger pull-right','onclick'=>'return bulkdelete()']); ?>
	</div>
	
</div>

<?php
	
} else {
	
?>

	<div class="row inner">
			
		<div class="col-sm-12 text-center">
			<?=	 __('No pages found') ?>
		</div>
		
	</div> <!--/.row.inner-->

<?php
	
}
	
?>

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