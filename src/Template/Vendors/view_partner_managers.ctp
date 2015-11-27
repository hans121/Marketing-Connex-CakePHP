<div class="partnerManagers view">
	<h2><?= __('Partner Manager'); ?></h2>
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
    
	<dl>
		<dt><?= __('Id'); ?></dt>
		<dd>
			<?= h($partnerManager->id); ?>
			&nbsp;
		</dd>
		<dt><?= __('Partner'); ?></dt>
		<dd>
			<?= $this->Html->link($partnerManager->partner->id, ['controller' => 'Partners', 'action' => 'view', $partnerManager->partner->id]); ?>
			&nbsp;
		</dd>
		<dt><?= __('User'); ?></dt>
		<dd>
			<?= $this->Html->link($partnerManager->user->title, ['controller' => 'Users', 'action' => 'view', $partnerManager->user->id]); ?>
			&nbsp;
		</dd>
		<dt><?= __('Created On'); ?></dt>
		<dd>
			<?= h($partnerManager->created_on); ?>
			&nbsp;
		</dd>
		<dt><?= __('Modified On'); ?></dt>
		<dd>
			<?= h($partnerManager->modified_on); ?>
			&nbsp;
		</dd>
		<dt><?= __('Status'); ?></dt>
		<dd>
			<?= h($partnerManager->status); ?>
			&nbsp;
		</dd>
		<dt><?= __('Primary Contact'); ?></dt>
		<dd>
			<?= h($partnerManager->primary_contact); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?= __('Actions'); ?></h3>
	<ul>
		<li><?= $this->Html->link(__('Edit Partner Manager'), ['action' => 'edit', $partnerManager->id]); ?> </li>
		<li><?= $this->Form->postLink(__('Delete Partner Manager'), ['action' => 'delete', $partnerManager->id], ['confirm' => __('Are you sure you want to delete # %s?', $partnerManager->id)]); ?> </li>
		<li><?= $this->Html->link(__('List Partner Managers'), ['action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Partner Manager'), ['action' => 'add']); ?> </li>
		<li><?= $this->Html->link(__('List Partners'), ['controller' => 'Partners', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Partner'), ['controller' => 'Partners', 'action' => 'add']); ?> </li>
		<li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']); ?> </li>
	</ul>
</div>
