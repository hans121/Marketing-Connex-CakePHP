<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Resource Entity.
 */
class VendorPage extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'menu_id' => true,
		'title' => true,
		'content' => true,
		'user_id' => true,
		'vendor_id' => true,
		'created_on' => true,
		'modified_on' => true,
		'status' => true,
	];

}
