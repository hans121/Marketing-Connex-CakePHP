<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Partner Entity.
 */
class Lead extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'vendor_id' => true,
		'first_name' => true,
		'last_name' => true,
		'company' => true,
		'position' => true,
		'phone' => true,
		'email' => true,
		'assigned' => true,
		'note' => true,
		'partner_id' => true,
		'response_time' => true,
		'responsed' => true,
		'response' => true,
		'response_status' => true,
		'response_note' => true,
		'lead_status' => true,
		'assigned_on' => true,
		'accepted_on' => true,
		'expire_on' => true
	];

}
