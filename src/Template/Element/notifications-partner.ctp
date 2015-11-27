<?php if($partner_new_campaigns > 0) { ?>
  <li>
  	<?= $this->Html->link($partner_new_campaigns.__(' new campaigns available'), ['controller' => 'PartnerCampaigns', 'action' => 'index'],['title' => 'View campaigns']); ?>
  </li>
<?php } ?>
 <?php if($partner_approved_bp > 0) { ?>
  <li>
  	<?= $this->Html->link($partner_approved_bp.__(' new campaign plans approved'), ['controller' => 'Campaignplans', 'action' => 'index'],['title' => 'View campaign plans']); ?>
  </li>
<?php } ?>
 <?php if($partner_denied_bp > 0) { ?>
 	<li>
  	<?= $this->Html->link($partner_denied_bp.__(' new campaign plans declined'), ['controller' => 'Campaignplans', 'action' => 'index'],['title' => 'View campaign plans']); ?>
 	</li>
<?php } ?>
<?php if($new_bp_alert > 0) { ?>
  <li>
  	<?= $this->Html->link(__('You haven\'t submitted a campaign plan for the next quarter'), ['controller' => 'Campaignplans', 'action' => 'index'],['title' => 'Create a campaign plan']); ?>
  </li>
<?php } ?>
