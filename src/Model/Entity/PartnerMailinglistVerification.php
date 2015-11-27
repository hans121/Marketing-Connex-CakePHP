<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PartnerMailinglistVerification Entity.
 */
class PartnerMailinglistVerification extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'id' => true,
		'partner_id' => true,
		'vendor_id' => true,
		'partner_mailinglist_group_id' => true,
		'first_name' => true,
		'last_name' => true,
		'email' => true,
		'company' => true,
		'industry' => true,
		'city' => true,
		'country' => true,
		'status' => true,
		'info' => true,
		'code' => true,
		'details' => true,
	];

}
