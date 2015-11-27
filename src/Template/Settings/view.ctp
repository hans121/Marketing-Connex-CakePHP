<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

<div class="settings view">
  
	<h2><?= __('Setting'); ?></h2>
	
	<dl>
		<dt><?= __('Settingname'); ?></dt>
		<dd>
			<?= h($setting->settingname); ?>
			&nbsp;
		</dd>
		<dt><?= __('Settingvalue'); ?></dt>
		<dd>
			<?= h($setting->settingvalue); ?>
			&nbsp;
		</dd>
	</dl>
	
</div>

<div class="actions">
  
	<h3><?= __('Actions'); ?></h3>
	
	<ul>
		<li><?= $this->Html->link(__('Edit Setting'), ['action' => 'edit', $setting->settingname]); ?> </li>
		<li><?= $this->Form->postLink(__('Delete Setting'), ['action' => 'delete', $setting->settingname], ['confirm' => __('Are you sure you want to delete # %s?', $setting->settingname)]); ?> </li>
		<li><?= $this->Html->link(__('List Settings'), ['action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Setting'), ['action' => 'add']); ?> </li>
	</ul>
	
</div>
