<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Country Entity.
 */
class Country extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'iso_alpha_code_2' => true,
                'iso_alpha_code_3' => true,
		'title' => true,
		'iso_numeric' => true,
	];

}
