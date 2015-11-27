					<ul class="mdl-navigation_subnav">
					<li>
					<?= $this->Html->link(__('My Campaigns'), ['controller' => 'PartnerCampaigns', 'action' => 'mycampaignslist']); ?> 
					                                  
					</li>
					<li>
					<?php
					if($partner_new_campaigns > 0) {
					?> 
					<?= $this->Html->link(__('Available Campaigns').' <span class="badge">'.$partner_new_campaigns.'</span>', ['controller' => 'PartnerCampaigns', 'action' => 'availablecampaigns'],array('escape' => FALSE)); ?>
					<?php
					} else {
					?>
					<?= $this->Html->link(__('Available Campaigns'), ['controller' => 'PartnerCampaigns', 'action' => 'availablecampaigns']); ?>
					<?php
					}
					?>
					</li>
					<li>
					<?= $this->Html->link(__('Email Management'), ['controller' => 'PartnerCampaignEmailSettings', 'action' => 'index']); ?> 
					</li>
					<li>
					<?= $this->Html->link(__('Deals'), ['controller' => 'CampaignPartnerMailinglists', 'action' => 'listdeals']); ?> 
					</li>
					<li>
					<?php 
					$partner_bp_alert = $partner_approved_bp + $partner_denied_bp;
					if($partner_bp_alert > 0) {
					?> 
					<?= $this->Html->link(__('Campaign Plans').' <span class="badge">'.$partner_bp_alert.'</span>', ['controller' => 'Campaignplans', 'action' => 'index'],array('escape' => FALSE)); ?>
					<?php
					} else {
					?>
					<?= $this->Html->link(__('Campaign Plans'), ['controller' => 'Campaignplans', 'action' => 'index']); ?>
					<?php
					}
					?>
					</li>
				</ul>