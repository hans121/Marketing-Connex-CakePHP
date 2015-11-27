<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MasterTemplate Entity.
 */
class MasterTemplate extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'title' => true,
		'content' => true,
		'template_type' => true,
		'status' => true,
		'modified_on' => true,
		'created_on' => true,
	];

}
