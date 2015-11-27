<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PartnerGroup Entity.
 */
class PartnerGroupResource extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'partner_group_id' => true,
		'resource_id' => true,
	];

}
