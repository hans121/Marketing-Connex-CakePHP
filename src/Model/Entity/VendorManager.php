<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VendorManager Entity.
 */
class VendorManager extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'vendor_id' => true,
		'user_id' => true,
		'primary_manager' => true,
		'created_on' => true,
		'modified_on' => true,
		'status' => true,
		'vendor' => true,
		'user' => true,
		'litmos_id' => true,
	];

}
