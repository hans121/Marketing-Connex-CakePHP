<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PartnerMailinglistGroup Entity.
 */
class PartnerMailinglistGroup extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'partner_id' => true,
		'vendor_id' => true,
		'name' => true,
		'is_default' => true,
		'created_on' => true,
		'modified_on' => true,
	];

}
