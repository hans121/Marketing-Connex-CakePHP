<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserPwordReset Entity.
 */
class UserPwordReset extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'username' => true,
		'email' => true,
		'token' => true,
		'expiry_date' => true,
		'created_on' => true,
		'status' => true,
	];

}
