<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Folder Entity.
 */
class Folder extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'parentpath' => true,
		'user_id' => true,
		'user_role' => true,
		'vendor_id' => true,
		'name' => true,
		'description' => true,
		'folderpath' => true,
		'created_on' => true,
		'modified_on' => true,
		'status' => true,
		'parent_id' => true,
		'user' => true,
		'vendor' => true,
		'resources' => true,
		'assigned' => true,
	];

}
