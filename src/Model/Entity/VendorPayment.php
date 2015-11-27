<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VendorPayment Entity.
 */
class VendorPayment extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'vendor_id' => true,
		'reference' => true,
		'subscriptionid' => true,
                'customerProfileId' => true,
                'customerPaymentProfileId' => true,
		'vendor' => true,
	];

}
