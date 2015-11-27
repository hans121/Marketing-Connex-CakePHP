<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PartnerGroup Entity.
 */
class PartnerGroup extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'vendor_id' => true,
		'name' => true,
		'created_on' => true,
		'modified_on' => true,
		'vendor' => true,
		'partners' => true,
	];

}
