<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PartnerMailinglistSegmentRule Entity.
 */
class PartnerMailinglistSegmentRule extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'id' => true,
		'partner_mailinglist_segment_id' => true,
		'logic' => true,
		'variable' => true,
		'operand' => true,
		'value' => true,
		'priority' => true,
	];

}
