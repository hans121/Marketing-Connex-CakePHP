<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LeadResponseNote Entity.
 */
class LeadResponseNote extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'lead_id' => true,
		'partner_id' => true,
		'response_note' => true,
		'response' => true,
		'response_status' => true
	];

}
