<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SubscriptionPackage Entity.
 */
class SubscriptionPackage extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'name' => true,
		'annual_price' => true,
		'monthly_price' => true,
		'signup_fee' => true,
		'duration' => true,
		'no_partners' => true,
		'storage' => true,
		'no_emails' => true,
		'resource_library' => true,
		'portal_cms' => true,
		'joint_business' => true,
		'lead_distribution' => true,
		'MDF' => true,
		'deal_registration' => true,
		'partner_recruit' => true,
		'training' => true,
		'Socialmedia' => true,
		'multilingual' => true,
		'partner_incentive' => true,
		'partner_app' => true,
		'created_on' => true,
		'modified_on' => true,
		'status' => true,
                'vendors' => true,
	];

}
