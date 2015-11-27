<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UnsubscribedContact Entity.
 */
class UnsubscribedContact extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'partner_id' => true,
		'email' => true,
		'created_on' => true,
		'modified_on' => true,
		'partner' => true,
	];

}
