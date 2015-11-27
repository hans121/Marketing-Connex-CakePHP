<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Partner Entity.
 */
class PartnerLead extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'lead_id' => true,
		'partner_id' => true,
		'note' => true,
		'response_time' => true,
		'responsed' => true
	];

}
