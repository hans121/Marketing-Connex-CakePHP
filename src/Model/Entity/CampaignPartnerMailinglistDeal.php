<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CampaignPartnerMailinglistDeal Entity.
 */
class CampaignPartnerMailinglistDeal extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'campaign_partner_mailinglist_id' => true,
		'partner_manager_id' => true,
		'closure_date' => true,
		'product_sold' => true,
		'quantity_sold' => true,
		'campaign_price' => true,
		'deal_value' => true,
		'status' => true,
		'created_on' => true,
		'modified_on' => true,
	];

}
