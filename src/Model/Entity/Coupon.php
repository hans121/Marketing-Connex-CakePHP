<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Coupon Entity.
 */
class Coupon extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'title' => true,
        'coupon_code' => true,
		'type' => true,
		'discount' => true,
		'vendor_id' => true,
		'expiry_date' => true,
		'created_on' => true,
		'modified_on' => true,
		'status' => true,
		'vendors' => true,
	];

}
