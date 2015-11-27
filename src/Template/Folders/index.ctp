<div class="folders index">
			
	<div class="row table-title">
	
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		
			<h2><?= __('Folders List')?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Resources', ['controller'=>'Resources', 'action'=>'index']);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Admins', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
			
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		
			<div class="pull-right btn btn-lg">
			
        <?= $this->Html->link(__('Add new'), ['controller' => 'Folders', 'action' => 'add']); ?>
        
      </div>
      
		</div>
		
	</div> <!--row-table-title-->
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<div class="row table-th hidden-xs">	
		
		<div class="clearfix"></div>
	
		<div class="col-lg-2 col-md-2 col-sm-4 col-xs-2"><?= $this->Paginator->sort('name','Folder Name') ?></div>
		<div class="col-lg-2 col-md-2 hidden-sm col-xs-2"><?= $this->Paginator->sort('user_id','Created By') ?></div>
		<div class="col-lg-1 col-md-1 col-sm-2 col-xs-1"><?= $this->Paginator->sort('user_role') ?></div>
		<div class="col-lg-1 col-md-1 col-sm-2 col-xs-1"><?= $this->Paginator->sort('vendor_id') ?></div>
		<div class="col-lg-3 col-md-3 col-sm-4 col-xs-3 text-right"></div>
		
	</div> <!--row-table-th-->
		
		
	<!-- Start loop -->
	
	
	<?php 
		$j =0;
		foreach ($folders as $folder):
		$j++;
	?>
	
		<div class="row inner hidden-xs">
		
			<div class="col-lg-2 col-md-2 col-sm-4 col-xs-2">
        <?= h($folder->name) ?>
      </div>

			<div class="col-lg-2 col-md-2 hidden-sm col-xs-2">
				<?= $folder->has('user') ? $folder->user->title.' '.$folder->user->full_name : '' ?>
			</div>
			
			<div class="col-lg-1 col-md-1 col-sm-2 col-xs-1">
				<?= h($folder->user_role) ?>
			</div>
			
			<div class="col-lg-1 col-md-1 col-sm-2 col-xs-1">
				<?= $folder->has('vendor') ? $this->Html->link($folder->vendor->company_name, ['controller' => 'Admins', 'action' => 'viewVendor', $folder->vendor->id]) : '' ?>
			</div>
			
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-3 pull-right">
			
				<div class="btn-group pull-right">
					<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $folder->id], ['confirm' => __('Are you sure you want to delete?', $folder->id),'class' => 'btn btn-danger pull-right']); ?>
					<?= $this->Html->link(__('Edit'), ['controller'=>'Folders','action' => 'edit', $folder->id],['class' => 'btn pull-right']); ?>
					<?= $this->Html->link(__('View'), ['controller'=>'Folders','action' => 'view', $folder->id],['class' => 'btn pull-right']); ?>
				</div>
				
			</div>
			
		</div> <!--row-->
		
		
		<div class="row inner visible-xs">
		
			<div class="col-xs-12 text-center">
				
				<a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
					
					<h3><?= h($folder->name) ?></h3>
					
				</a>
				
			</div> <!--col-->

				
			<div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">
			
				<div class="row inner">
				
					<div class="col-xs-6">
						<?= __('Created By')?>
					</div>
					
					<div class="col-xs-6">
						<?= $folder->has('user') ? $folder->user->title.' '.$folder->user->full_name : '' ?>
					</div>
				
				</div>
				
				<div class="row inner">
				
					<div class="col-xs-6">
						<?= __('User Role')?>
					</div>
					
					<div class="col-xs-6">
						<?= h($folder->user_role) ?>
					</div>
				
				</div>
				
				<div class="row inner">
				
					<div class="col-xs-6">
						<?= __('Vendor')?>
					</div>
					
					<div class="col-xs-6">
						<?= $folder->has('vendor') ? $this->Html->link($folder->vendor->company_name, ['controller' => 'Admins', 'action' => 'viewVendor', $folder->vendor->id]) : '' ?>
					</div>
				
				</div>
				
				
				
				
				<div class="row inner">
				
					<div class="col-xs-12">
					
						<div class="btn-group pull-right">
						
							<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $folder->id], ['confirm' => __('Are you sure you want to delete?', $folder->id),'class' => 'btn btn-danger pull-right']); ?>
					<?= $this->Html->link(__('Edit'), ['controller'=>'Folders','action' => 'edit', $folder->id],['class' => 'btn pull-right']); ?>
					<?= $this->Html->link(__('View'), ['controller'=>'Folders','action' => 'view', $folder->id],['class' => 'btn pull-right']); ?>		                                 
						</div>
						
					</div>
					
				</div>
				
			</div>
			
		</div> <!--row-->
	
	
<!-- End loop -->

			
<?php endforeach; ?>


<?php echo $this->element('paginator'); ?>
		
		
</div><!-- /.container -->

	</div> <!-- /#content -->