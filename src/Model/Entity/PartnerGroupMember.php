<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PartnerGroup Entity.
 */
class PartnerGroupMember extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'id'=>true,
		'group_id' => true,
		'partner_id' => true,
	];

}
