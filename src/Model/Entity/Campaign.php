<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Campaign Entity.
 */
class Campaign extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'vendor_id' => true,
		'financialquarter_id' => true,
		'name' => true,
		'campaign_type' => true,
		'mobile_delivery' => true,
		'target_market' => true,
		'subject_line' => true,
		'html' => true,
		'available_to' => true,
		'include_landing_page' => true,
		'date_created' => true,
		'date_modified' => true,
		'status' => true,
		'sales_value' => true,
		'send_limit' => true,
		'allocated_send' => true,
		'itconsulting' => true,
		'softwaredev' => true,
		'telecom' => true,
		'voip' => true,
		'internet' => true,
		'professional' => true,
		'appshost' => true,
		'storage' => true,
		'disaster' => true,
		'customsystem' => true,
		'wireless' => true,
		'serviceprovider' => true,
		'cloud' => true,
		'primary_color' => true,
		'secondary_color' => true,
		'vendor' => true,
		'financialquarter' => true,
		'campaign_resources' => true,
		'email_templates' => true,
		'landing_pages' => true,
		'partner_view_tracks' => true,
		'vendor_view_tracks' => true,
		'businesplan_campaigns' => true,
                'partner_campaigns' => true,
	];

}
