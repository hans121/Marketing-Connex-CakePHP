<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Folder Entity.
 */
class LandingPagesFormdata extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'url' => true,
		'serialized_data' => true,
		'created_on' => true,
	];

}
