<div class="row table-title partner-table-title">

	<div class="partner-sub-menu clearfix">
	
		<div class="col-md-5 col-sm-4 col-xs-6">
			<h2><?= __('Resources'); ?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Resources', ['controller'=>'PartnerResources', 'action'=>'index']);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Partners', 'action' => 'index'],
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
			
			<?=$this->Form->create(null, ['url' => ['controller' => 'PartnerResources', 'action' => 'search']]) ?>

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
		
	<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<div class="clearfix"></div>
	<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
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

<?php
	if($parentfolder->parent_id!=4) : // not root folder
?>

<div class="row inner withtop">
		
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
    <?= $this->Html->link('<i class="fa fa-level-up fa-lg"></i>', ['action'=>'navigate',$parentfolder->parent_id],['escape' => false, 'title' => 'Go up a level']); ?>
    <?= $this->Html->link(__('/..'), ['action'=>'navigate',$parentfolder->parent_id],['title' => 'Go up a level']); ?>
  </div>
	
</div> <!--/.row.inner-->

<?php
	endif;
?>

<div class="row inner">
	
	<?php
	if($parentfolder->parent_id!=4) : // not root folder
	?>
	<div class="col-md-8 col-sm-6 col-xs-12">
		<i class="fa fa-folder-open-o fa-lg"></i> <?= __($parentfolder->name)?>
	</div>
	<div class="col-md-4 col-sm-5 col-sm-5">
  	<?= $this->Html->link(__('View'), ['controller' => 'PartnerFolders', 'action' => 'view', $parentfolder->id],['class' => 'btn pull-right']) ?>
	</div>
	<?php
	else:
	?>
	<div class="col-md-7 col-sm-6 col-xs-12">
		<i class="fa fa-folder-open-o fa-lg"></i> <?= __('ROOT Folder')?>
	</div>
	<div class="col-md-4 col-sm-5 hidden-xs">
	</div>
	<?php 
	endif;
	?>
</div>

<?php
	if($folders->count())
	foreach($folders as $folder) {
?>

		<div class="row inner">
			
			<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
				<i class="fa fa-folder-o fa-lg"><?= $this->Html->link('', ['controller' => 'PartnerResources', 'action' => 'navigate', $folder->id]) ?></i> <?= $this->Html->link($folder->name, ['controller' => 'PartnerResources', 'action' => 'navigate', $folder->id]) ?>
			</div>

			<div class="col-lg-1 col-md-1 hidden-sm hidden-xs">
			</div>
			
			<div class="col-lg-1 col-md-1 hidden-sm hidden-xs">
			</div>

			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
	    	<?= $this->Html->link(__('View'), ['controller' => 'PartnerFolders', 'action' => 'view', $folder->id],['class' => 'btn pull-right']) ?>
	  	</div>

		</div>
<?php
	}
?>   
	
<!-- Are there any resources in this folder? -->
	
<?php

		if($resources->count()>0) {
			
?>

<!-- Start loop -->

<?php
  $j =0;
  $kb =0;
  foreach ($resources as $resource):
  $j++;
?>
<div class="row inner hidden-xs">
	
	<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
		<i class="fa fa-file-o fa-lg"></i> <?= $this->Html->link(h($resource->name), ['controller'=>'PartnerResources','action' => 'view', $resource->id]); ?>
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

	
	<div class="col-lg-4 col-md-5 col-sm-5 col-xs-5">

		<div class="btn-group pull-right">
			
			<?= $this->Html->link(__('View'), ['controller'=>'PartnerResources','action' => 'view', $resource->id],['class' => 'btn pull-right']); ?>
			<?= $this->Html->link(__('Download'), ['controller'=>'PartnerResources','action' => 'download', $resource->id],['class' => 'btn pull-right']); ?>
			<?= $this->Html->link(__('Report Abuse'), ['controller'=>'PartnerResources','action' => 'report', $resource->id],['class' => 'btn btn-danger pull-right']); ?>
			
		</div>
	
	</div>
	
</div> <!--row-->
		
		
<div class="row inner filetree visible-xs">

	<div class="col-xs-12">
		
		<a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
			<i class="fa fa-file-o fa-lg"></i> <?= $this->Html->link(h($resource->name), ['controller'=>'PartnerResources','action' => 'view', $resource->id]); ?>
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
					<?= $this->Html->link(__('View'), ['controller'=>'PartnerResources','action' => 'view', $resource->id],['class' => 'btn pull-right']); ?>
					<?= $this->Html->link(__('Download'), ['controller'=>'PartnerResources','action' => 'view', $resource->id],['class' => 'btn pull-right']); ?><!-- needs correct controller/action -->
				</div>
				
			</div>
			
		</div>
				
	</div> <!--collapseOne-->
			
</div> <!--row-->


<?php endforeach; ?>


<!-- End loop -->

<div class="row">
	
  <div class="col-md-12 text-center">
    <p class="participants text-grey"><span id="totparticipants"><?= __('Current folder contains').' '.$j.' '; if ($j=='1'){ echo __('file, using').' ';} else {echo __('files, using').' ';}; echo round($kb/1000) .'KB '.__('bytes of storage space');?></p>
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
