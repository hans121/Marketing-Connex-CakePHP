<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PartnerManager Entity.
 */
class PartnerManager extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'partner_id' => true,
		'user_id' => true,
		'created_on' => true,
		'modified_on' => true,
		'status' => true,
		'primary_contact' => true,
		'partner' => true,
		'user' => true,
	];

}
