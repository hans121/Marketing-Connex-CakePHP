<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Currency Entity.
 */
class Currency extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'countryname' => true,
		'iso_alpha2' => true,
		'iso_alpha3' => true,
		'iso_numeric' => true,
		'currency_code' => true,
		'currency_name' => true,
		'currrency_symbol' => true,
		'flag' => true,
	];

}
