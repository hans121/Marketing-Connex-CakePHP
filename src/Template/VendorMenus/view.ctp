<div class="folder view">

	<div class="row table-title">

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<h2><?= __('View folder'); ?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Resources', ['controller'=>'VendorResources', 'action'=>'index']);
					$this->Html->addCrumb('view folder', ['controller' => 'VendorFolders', 'action' => 'view', $folder->id]);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Admins', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
	    <?= $this->Html->link(__('Add folder'), ['action' => 'add'],['class'=>'btn btn-lg pull-right']); ?>
		</div>
		
	</div> <!--row-table-title-->
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

	<div class="row inner header-row ">
		<dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4"><strong><?= h($folder->name) ?></strong></dt>
		<dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
			<?= $this->Form->postLink(__('Delete'), ['controller' => 'VendorFolders', 'action' => 'delete', $folder->id], ['confirm' => __('Are you sure you want to delete?', $folder->id),'class' => 'btn btn-danger pull-right']); ?>
			<?= $this->Html->link(__('Edit'), ['controller' => 'VendorFolders', 'action' => 'edit', $folder->id],['class' => 'btn pull-right']); ?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-sm-5 col-xs-5">
    <?= __('Folder path') ?>
    </dt>
		<dd class="col-sm-5 col-xs-7">
      <i class="fa fa-folder-open-o"></i>          
			<?= h(($folder->parentpath == '0' ? $folder->folderpath : /*$folder->parentpath.*/'/'.$folder->folderpath)) ?>
		</dd>
		<dd class="col-sm-2 hidden-xs">
			<?php
				if ($folder->parent_id > 0) {
				echo $this->Html->link(__('View parent'), ['controller' => 'VendorFolders', 'action' => 'view', $folder->parent_id],['class'=>'btn pull-right']);
				}
			?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-xs-5">
    	<?= __('Folder description') ?>
    </dt>
		<dd class="col-xs-7">
			<?= h($folder->description) ?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-xs-5">
    	<?= __('User') ?>
    </dt>
		<dd class="col-xs-7">
			<?= $folder->has('user') ? $folder->user->title.' '.$folder->user->first_name.' '.$folder->user->last_name : __('Not assigned') ?>
			&nbsp;
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-xs-5">
    	<?= __('User role') ?>
    </dt>
		<dd class="col-xs-7">
			<?= h($folder->user_role) ?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-xs-5">
    	<?= __('Vendor') ?>
    </dt>
		<dd class="col-xs-7">
			<?= $folder->has('vendor') ? $this->Html->link($folder->vendor->company_name, ['controller' => 'Vendors', 'action' => 'view', $folder->vendor->id]) : __('Not assigned') ?>
		</dd>
	</div>

	<div class="row related">
		<div class="col-lg-9 col-md-8 col-sm-6 col-xs-8">
			<h3><?= __('Related Vendors')?><small><?= $this->Html->link(__('View all'), ['controller' => 'Admins', 'action' => 'vendors'],['title'=>'View all Vendors']); ?></small></h3>
		</div>
		
	</div>
			
					
	<?php if (!empty($folder->vendors)):?>
        
	
	<div class="row table-th hidden-xs">	
	                            
		<div class="col-lg-3 col-md-3 col-sm-3">
			<?= __('Company Name'); ?>
		</div>		
		<div class="col-lg-2 col-md-2 col-sm-2">
			<?= __('Website'); ?>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2">
			<?= __('Subscription Package'); ?>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2">
			<?= __('Subscription Type'); ?>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-3">
		</div>
	</div>
	
	<?php foreach ($folder->vendors as $vendors): ?>
	
		<div class="row inner hidden-xs">
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-2"><?= h($vendors->company_name) ?></div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><?= h($vendors->website) ?></div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-1"><?= h($vendors->subscription_package) ?></div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-1"><?= h($vendors->subscription_type) ?></div>
			
		</div>
	
			
	<!-- For mobile view only -->
	<div class="row inner visible-xs">
	
		<div class="col-xs-12 text-center">
			<a data-toggle="collapse" data-parent="#accordion" href="#coupons-1">
				
				<h3><?= __('Company Name'); ?></h3>
				
			</a>						
		</div> <!-- /.col -->
					
		<div id="coupons-1" class="col-xs-12 panel-collapse collapse">
		
			<div class="row inner">
				<div class="col-xs-6"><?= __('Website'); ?></div>
				<div class="col-xs-6"><?= h($vendors->website) ?></div>
			</div>
			<div class="row inner">
				<div class="col-xs-6">
					<?= __('Subscription Package'); ?>
				</div>
				<div class="col-xs-6">
					<?= h($vendors->subscription_package) ?>
				</div>
			</div>
			<div class="row inner">
				<div class="col-xs-6">
					<?= __('Subscription Type'); ?>
				</div>
				<div class="col-xs-6">
					<?= h($vendors->subscription_type) ?>
				</div>
			</div>
			
		
		</div> <!-- /.collapse -->				
				
	</div> <!-- /.row -->
	
	
	<?php endforeach; ?>

	<?php else:?>
	
	
	<div class="row inner withtop">
		<div class="col-sm-12 text-center">
			<?= __('No related vendors found') ?>
		</div>
	</div>
		
		
	<?php endif;?>

<?php
/*
 * Section to show related Resources
 */?>
 
  <div class="row related">
		<div class="col-lg-9 col-md-8 col-sm-6 col-xs-8">
			<h3><?= __('Related Resources')?><small><?= $this->Html->link(__('View all'), ['controller' => 'Resources', 'action' => 'index'],['title'=>'View all Vendors']); ?></small></h3>
		</div>
		
	</div>
			
					
	<?php if (!empty($folder->resources)): ?>
        
	
	<div class="row table-th hidden-xs">	
	                            
		<div class="col-lg-1 col-md-1 col-sm-1">

		</div>
		
		<div class="col-lg-8 col-md-8 col-sm-8">
			<?= __('Name'); ?>
		</div>		
		
    <div class="col-lg-3 col-md-3 col-sm-3">
		</div>
	</div>
	
	<div class="row inner withtop">
		
		<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
			<i class="fa fa-folder-open-o fa-lg"></i>
		</div>
		
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-11">
			<?= $this->Html->link('', ['controller' => 'Resources', 'action' => 'navigate', $folder->id]) ?></i> <?= $this->Html->link($folder->name, ['controller' => 'Resources', 'action' => 'navigate', $folder->id]) ?>
		</div>
		
    <div class="col-lg-3 col-md-3 col-sm-3 hidden-xs">
    </div>

	</div>

	
	<?php 
    $j=0;
    foreach ($folder->resources as $resources):
    $j++;
  ?>
  
  <div class="row inner hidden-xs">
	  
		<div class="col-lg-1 col-md-1 col-sm-1">
			<i class="fa fa-file-o fa-lg"></i>
		</div>
		
		<div class="col-lg-8 col-md-7 col-sm-7">
			<?= h($resources->name) ?>
		</div>
		
    <div class="col-lg-3 col-md-4 col-sm-4">
			<?= $this->Html->link(__('Edit'), ['controller'=>'Resources','action' => 'edit', $resources->folder_id, $resources->id],['class' => 'btn pull-right']); ?>
			<?= $this->Html->link(__('View'), ['controller'=>'Resources','action' => 'view', $resources->id],['class' => 'btn pull-right']); ?>
			<?= $this->Html->link(__('Download'), ['controller'=>'Resources','action' => 'download', $resources->id],['class' => 'btn pull-right']); ?>
    </div>

	  
  </div>
  
	
	<!-- For mobile view only -->
	<div class="row inner filetree visible-xs">

		<div class="col-xs-1">
			<i class="fa fa-file-o fa-lg"></i>
		</div>
		
		<div class="col-xs-11">
			<a data-toggle="collapse" data-parent="#accordion" href="#coupons-<?=$j?>">
				<?= h($resources->name) ?>
			</a>						
		</div> <!-- /.col -->
						
		<div id="coupons-<?=$j?>" class="col-xs-12 panel-collapse collapse">
		
			<div class="row inner">
				<div class="col-xs-5">
					<?= __('Name') ?>
				</div>
				<div class="col-xs-7">
					<?= h($resources->name) ?>
				</div>
			</div>
	
			<div class="row inner">
				<div class="col-xs-5">
					<?= __('Description') ?>
				</div>
				<div class="col-xs-7">
					<?= h($resources->description) ?>
				</div>
			</div>
	
			<div class="row inner">
				<div class="col-xs-12">
					<?= $this->Form->postLink(__('Download'), ['controller'=>'Resources','action' => 'downloadfile', $resources->id], ['class' => 'btn pull-right']); ?>
				</div>
			</div>
		
		</div> <!-- /.collapse -->
				
	</div> <!-- /.row -->
	
	
	<?php endforeach; ?>

	<?php else: ?>
	
	
	<div class="row inner withtop">
		<div class="col-sm-12 text-center">
			<?= __('No related resources found') ?>
		</div>
	</div>
		
		
	<?php endif;?>   
	
</div>


 