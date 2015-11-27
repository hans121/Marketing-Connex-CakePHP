<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VendorSortablePosition Entity.
 */
class VendorSortablePosition extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'vendor_id' => true,
		'position' => true
		
	];

}
