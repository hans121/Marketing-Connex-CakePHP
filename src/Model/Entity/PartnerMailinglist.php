<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PartnerMailinglist Entity.
 */
class PartnerMailinglist extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'partner_id' => true,
		'vendor_id' => true,
		'partner_mailinglist_group_id' => true,
		'first_name' => true,
		'last_name' => true,
		'email' => true,
		'mandrillemailid' => true,
		'status' => true,
		'created_on' => true,
		'modified_on' => true,
		'partner' => true,
		'vendor' => true,
		'company' => true,
		'industry' => true,
		'city' => true,
		'country' => true,
		
	];

}
