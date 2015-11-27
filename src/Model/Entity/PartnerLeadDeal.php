<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Partner Entity.
 */
class PartnerLeadDeal extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'partner_lead_id' => true,
		'partner_manager_id' => true,
		'product_description' => true,
		'quantity_sold' => true,
		'deal_value' => true,
		'status' => true,
		'closure_date' => true
	];

}
