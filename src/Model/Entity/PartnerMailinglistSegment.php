<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PartnerMailinglistSegment Entity.
 */
class PartnerMailinglistSegment extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'partner_mailinglist_group_id' => true,
		'name' => true,
		'created_on' => true,
		'modified_on' => true,
	];

}
