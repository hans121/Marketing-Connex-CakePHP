<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Financialquarter Entity.
 */
class Financialquarter extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'vendor_id' => true,
		'startdate' => true,
		'enddate' => true,
		'quartertitle' => true,
		'vendor' => true,
		'businesplans' => true,
		'campaigns' => true,
	];

}
