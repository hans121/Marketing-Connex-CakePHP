<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Invoice Entity.
 */
class Invoice extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'invoice_type' => true,
		'invoice_date' => true,
		'title' => true,
		'description' => true,
		'invoice_number' => true,
		'comments' => true,
		'vendor_id' => true,
		'vendor' => true,
		'primary_manager' => true,
		'company_name' => true,
		'company_address' => true,
		'company_city' => true,
		'company_state' => true,
		'company_postcode' => true,
		'company_country' => true,
		'customer_service' => true,
		'old_package' => true,
		'old_package_price' => true,
		'billing_period_days' => true,
		'balance_credit' => true,
		'sub_start_date' => true,
		'upgrade_date' => true,
		'days_used' => true,
		'sub_end_date' => true,
		'new_package' => true,
		'package_price' => true,
		'adjusted_package_price' => true,
    'discount' => true,
		'fee' => true,
		'subtotal' => true,
		'vat_number' => true,
		'vat_perc' => true,
		'vat' => true,
		'amount' => true,
		'currency' => true,
		'status' => true,
		'created_on' => true,
		'modified_on' => true,
	];

}
