<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Vendor Entity.
 */
class Vendor extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'company_name' => true,
		'logo_url' => true,
		'logo_path' => true,
		'phone' => true,
		'fax' => true,
		'website' => true,
		'address' => true,
		'country' => true,
		'city' => true,
		'state' => true,
		'postalcode' => true,
		'subscription_package_id' => true,
		'status' => true,
		'coupon_id' => true,
		'language' => true,
		'subscription_type' => true,
		'created_on' => true,
		'modified_on' => true,
		'subscription_expiry_date' => true,
		'last_billed_date' => true,
		'status_change_date' => true,
		'current_bill_end_date' => true,
		'financial_quarter_start_month' => true,
		'currency' => true,
		'vat_no' => true,
		'coupon' => true,
		'subscription_package' => true,
		'invoices' => true,
		'partners' => true,
		'vendor_managers' => true,
		'vendor_payments' => true,
		'financialquarters' => true,
		'campaigns' => true,
		'currency_choice' => true,
		'salesforce_token' => true,
		'salesforce_refresh_token' => true,
		'salesforce_instance_url' => true,
		'salesforce_identity' => true,
	];

}
