<div class="actions columns large-2 medium-3">
	<h3><?= __('Actions') ?></h3>
	<ul class="side-nav">
		<li><?= $this->Html->link(__('New Partner Campaign'), ['action' => 'add']) ?></li>
		<li><?= $this->Html->link(__('List Partners'), ['controller' => 'Partners', 'action' => 'index']) ?> </li>
		<li><?= $this->Html->link(__('New Partner'), ['controller' => 'Partners', 'action' => 'add']) ?> </li>
		<li><?= $this->Html->link(__('List Campaigns'), ['controller' => 'Campaigns', 'action' => 'index']) ?> </li>
		<li><?= $this->Html->link(__('New Campaign'), ['controller' => 'Campaigns', 'action' => 'add']) ?> </li>
	</ul>
</div>
<div class="partnerCampaigns index large-10 medium-9 columns">
	<table cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th><?= $this->Paginator->sort('id') ?></th>
			<th><?= $this->Paginator->sort('partner_id') ?></th>
			<th><?= $this->Paginator->sort('campaign_id') ?></th>
			<th><?= $this->Paginator->sort('view_status') ?></th>
			<th><?= $this->Paginator->sort('status') ?></th>
			<th><?= $this->Paginator->sort('created_on') ?></th>
			<th><?= $this->Paginator->sort('modified_on') ?></th>
			<th class="actions"><?= __('Actions') ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($partnerCampaigns as $partnerCampaign): ?>
		<tr>
			<td><?= $this->Number->format($partnerCampaign->id) ?></td>
			<td>
				<?= $partnerCampaign->has('partner') ? $this->Html->link($partnerCampaign->partner->id, ['controller' => 'Partners', 'action' => 'view', $partnerCampaign->partner->id]) : '' ?>
			</td>
			<td>
				<?= $partnerCampaign->has('campaign') ? $this->Html->link($partnerCampaign->campaign->name, ['controller' => 'Campaigns', 'action' => 'view', $partnerCampaign->campaign->id]) : '' ?>
			</td>
			<td><?= h($partnerCampaign->view_status) ?></td>
			<td><?= h($partnerCampaign->status) ?></td>
			<td><?= h($partnerCampaign->created_on) ?></td>
			<td><?= h($partnerCampaign->modified_on) ?></td>
			<td class="actions">
				<?= $this->Html->link(__('View'), ['action' => 'view', $partnerCampaign->id]) ?>
				<?= $this->Html->link(__('Edit'), ['action' => 'edit', $partnerCampaign->id]) ?>
				<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $partnerCampaign->id], ['confirm' => __('Are you sure you want to delete # {0}?', $partnerCampaign->id)]) ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<div class="paginator">
		<ul class="pagination">
		<?php
			echo $this->Paginator->prev('< ' . __('previous'));
			echo $this->Paginator->numbers();
			echo $this->Paginator->next(__('next') . ' >');
		?>
		</ul>
		<p><?= $this->Paginator->counter() ?></p>
	</div>
</div>
