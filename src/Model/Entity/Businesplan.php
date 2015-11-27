<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Businesplan Entity.
 */
class Businesplan extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'partner_id' => true,
		'financialquarter_id' => true,
		'vendor_id' => true,
		'business_case' => true,
		'target_customers' => true,
		'target_geography' => true,
		'required_amount' => true,
		'expected_result' => true,
		'expected_roi' => true,
		'created_on' => true,
		'modified_on' => true,
		'status' => true,
		'note' => true,
		'partner' => true,
		'financialquarter' => true,
		'vendor' => true,
		'businesplan_campaigns' => true,
	];

}
