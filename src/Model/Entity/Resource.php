<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Resource Entity.
 */
class Resource extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'folder_id' => true,
		'name' => true,
		'description' => true,
		'user_id' => true,
		'user_role' => true,
		'vendor_id' => true,
		'created_on' => true,
		'modified_on' => true,
		'status' => true,
		'sourcepath' => true,
		'publicurl' => true,
		'folder' => true,
		'user' => true,
		'vendor' => true,
		'type'	=> true,
		'size'	=> true,
		'assigned'	=> true,
	];

}
