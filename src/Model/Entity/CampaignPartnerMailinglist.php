<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CampaignPartnerMailinglist Entity.
 */
class CampaignPartnerMailinglist extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'partner_id' => true,
		'campaign_id' => true,
		'vendor_id' => true,
		'partner_campaign_id' => true,
		'first_name' => true,
		'last_name' => true,
		'email' => true,
		'mandrillemailid' => true,
		'participate_campaign' => true,
		'subscribe' => true,
		'status' => true,
		'created_on' => true,
		'modified_on' => true,
		'partner_campaign_email_setting_id' => true,
		'opens' => true,
		'clicks' => true,
		'partner' => true,
		'campaign' => true,
		'vendor' => true,
		'partner_campaign' => true,
		'partner_campaign_email_setting' => true,
		'company' => true,
		'industry' => true,
		'city' => true,
		'country' => true,
	];

}
