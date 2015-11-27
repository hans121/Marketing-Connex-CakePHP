<div class="vendorManagers index">
	<div class="row table-title">
		<h2 class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<?= __('Vendor Managers'); ?>
		</h2>
				
		<btn class="col-lg-3 col-md-3 col-sm-4 col-xs-12 pull-right btn btn-primary">
			<?= $this->Html->link(__('New Vendor Manager'), ['action' => 'addVendorManager']); ?>
		</btn>
				
	</div> <!--row-table-title-->
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<div class="row table-th hidden-xs">	
		<div class="clearfix"></div>	

		<div class="col-xs-1">
			<?= $this->Paginator->sort('vendor_id'); ?>
		</div>
		<div class="col-xs-1">
			<?= $this->Paginator->sort('user_id'); ?>
		</div>
		<div class="col-xs-2">
			<?= $this->Paginator->sort('primary_manager'); ?>
		</div>
		<div class="col-xs-1">
			<?= $this->Paginator->sort('created_on'); ?>
		</div>
		<div class="col-xs-1">
			<?= $this->Paginator->sort('modified_on'); ?>
		</div>
		<div class="col-xs-1">
			<?= $this->Paginator->sort('status'); ?>
		</div>
		<div class="col-xs-5">
			<?= __('Actions'); ?>
		</div>
		
	</div> <!--row-table-th-->
		
	<?php 
     $j =0;
	foreach ($vendorManagers as $vendorManager):
        $j++;
                ?>
	<!-- Start loop -->
		<div class="row inner hidden-xs">
			<div class="col-xs-1">
				<?= $this->Html->link($vendorManager->vendor->id, ['controller' => 'Vendors', 'action' => 'view', $vendorManager->vendor->id]); ?>
			</div>
			<div class="col-xs-1">
				<?= $this->Html->link($vendorManager->user->title, ['controller' => 'Users', 'action' => 'view', $vendorManager->user->id]); ?>
			</div>
			<div class="col-xs-2">
				<?= h($vendorManager->primary_manager); ?>
			</div>
			<div class="col-xs-1">
				<?= h($vendorManager->created_on); ?>
			</div>
			<div class="col-xs-1">
				<?= h($vendorManager->modified_on); ?>;
			</div>
			<div class="col-xs-1">
				<?= h($vendorManager->status); ?>
			</div>
			<div class="col-xs-5">
				<div class="btn-group">
				<?php 
				if($auth_vendor_primary == 'Y'){?>
					<?= $this->Html->link(__('View'), ['action' => 'view', $partnerManager->id],['class' => 'btn pull-right']); ?>
					<?= $this->Html->link(__('Edit'), ['action' => 'edit', $partnerManager->id],['class' => 'btn pull-right']); ?>
					<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $partnerManager->id], ['confirm' => __('Are you sure you want to delete?', $partnerManager->id),'class' => 'btn btn-default']); ?>
					<?php 
					if($partnerManager->primary_contact != 'Y'){
						echo $this->Form->postLink(__('Make Primary'), ['action' => 'changePrimaryPmanager', $partnerManager->id], ['confirm' => __('Are you sure you want to change primary manager?', $partnerManager->id),'class' => 'btn pull-right']);
					}
				} 
				?>
				</div>
			</div>	
		</div> <!--row-->
							
		<div class="row inner visible-xs">
		
			<div class="col-xs-12 text-center">
				
				<a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
					<h3><?= $this->Html->link($vendorManager->user->title, ['controller' => 'Users', 'action' => 'view', $vendorManager->user->id]); ?>
</h3>
				</a>
				
			</div> <!--col-->
				
			<div id="basic<?= $j ?>" class="panel-collapse collapse">
			
				<div class="col-xs-12"><strong><?= __('Full Name:')?></strong> <?= $vendorManager->user->full_name; ?></div>
				
				<div class="col-xs-12"><strong><?= __('Date Created:')?></strong> <?= h($vendorManager->created_on); ?></div>
				
				<div class="col-xs-12"><strong><?= __('Date Modified:')?></strong> <?= h($vendorManager->modified_on); ?></div>
				
				<div class="col-xs-12"><strong><?= __('Status:')?></strong><?= h($vendorManager->status); ?></div>
					
				<div class="col-xs-12">
					<div class="btn-group">
						<?php 
						if($auth_vendor_primary == 'Y'){?>
							<?= $this->Html->link(__('View'), ['action' => 'view', $partnerManager->id],['class' => 'btn pull-right']); ?>
							<?= $this->Html->link(__('Edit'), ['action' => 'edit', $partnerManager->id],['class' => 'btn pull-right']); ?>
							<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $partnerManager->id], ['confirm' => __('Are you sure you want to delete?', $partnerManager->id),'class' => 'btn btn-danger pull-right']); ?>
							<?php 
							if($partnerManager->primary_contact != 'Y'){
								echo $this->Form->postLink(__('Make Primary'), ['action' => 'changePrimaryPmanager', $partnerManager->id], ['confirm' => __('Are you sure you want to change primary manager?', $partnerManager->id),'class' => 'btn pull-right']);
							}
						} 
						?>
					</div><!--nested row-->
					
				</div> <!--col-xs-12-->
							
			</div> <!--collapseOne-->
			
		</div> <!--row-->
			
	<?php endforeach; ?>

	<?php echo $this->element('paginator'); ?>
	
	</div><!--row table-th-->
	
</div> <!-- index?-->
