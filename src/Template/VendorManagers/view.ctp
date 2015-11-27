<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

<div class="vendorManagers view">
	<h2><?= __('Vendor Manager'); ?></h2>
	<dl>
		<dt><?= __('Id'); ?></dt>
		<dd>
			<?= h($vendorManager->id); ?>
			&nbsp;
		</dd>
		<dt><?= __('Vendor'); ?></dt>
		<dd>
			<?= $this->Html->link($vendorManager->vendor->id, ['controller' => 'Vendors', 'action' => 'view', $vendorManager->vendor->id]); ?>
			&nbsp;
		</dd>
		<dt><?= __('User'); ?></dt>
		<dd>
			<?= $this->Html->link($vendorManager->user->title, ['controller' => 'Users', 'action' => 'view', $vendorManager->user->id]); ?>
			&nbsp;
		</dd>
		<dt><?= __('Primary Manager'); ?></dt>
		<dd>
			<?= h($vendorManager->primary_manager); ?>
			&nbsp;
		</dd>
		<dt><?= __('Created On'); ?></dt>
		<dd>
			<?= h($vendorManager->created_on); ?>
			&nbsp;
		</dd>
		<dt><?= __('Modified On'); ?></dt>
		<dd>
			<?= h($vendorManager->modified_on); ?>
			&nbsp;
		</dd>
		<dt><?= __('Status'); ?></dt>
		<dd>
			<?= h($vendorManager->status); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?= __('Actions'); ?></h3>
	<ul>
		<li><?= $this->Html->link(__('Edit Vendor Manager'), ['action' => 'edit', $vendorManager->id]); ?> </li>
		<li><?= $this->Form->postLink(__('Delete Vendor Manager'), ['action' => 'delete', $vendorManager->id], ['confirm' => __('Are you sure you want to delete # %s?', $vendorManager->id)]); ?> </li>
		<li><?= $this->Html->link(__('List Vendor Managers'), ['action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Vendor Manager'), ['action' => 'add']); ?> </li>
		<li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add']); ?> </li>
		<li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']); ?> </li>
	</ul>
</div>
