<div class="actions columns large-2 medium-3">
	<h3><?= __('Actions') ?></h3>
	<ul class="side-nav">
		<li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $partnerCampaign->id], ['confirm' => __('Are you sure you want to delete # %s?', $partnerCampaign->id)]) ?></li>
		<li><?= $this->Html->link(__('List Partner Campaigns'), ['action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('List Partners'), ['controller' => 'Partners', 'action' => 'index']) ?> </li>
		<li><?= $this->Html->link(__('New Partner'), ['controller' => 'Partners', 'action' => 'add']) ?> </li>
		<li><?= $this->Html->link(__('List Campaigns'), ['controller' => 'Campaigns', 'action' => 'index']) ?> </li>
		<li><?= $this->Html->link(__('New Campaign'), ['controller' => 'Campaigns', 'action' => 'add']) ?> </li>
	</ul>
</div>
<div class="partnerCampaigns form large-10 medium-9 columns">
<?= $this->Form->create($partnerCampaign) ?>
	<fieldset>
		<legend><?= __('Edit Partner Campaign'); ?></legend>
	<?php
		echo $this->Form->input('partner_id', ['options' => $partners]);
		echo $this->Form->input('campaign_id', ['options' => $campaigns]);
		echo $this->Form->input('view_status');
		echo $this->Form->input('status');
		echo $this->Form->input('created_on');
		echo $this->Form->input('modified_on');
	?>
	</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>
