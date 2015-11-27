<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PartnerCampaignEmailSetting Entity.
 */
class PartnerCampaignEmailSetting extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'partner_id' => true,
		'campaign_id' => true,
		'email_template_id' => true,
		'from_name' => true,
		'from_email' => true,
		'reply_to_email' => true,
		'subject_option' => true,
		'tweet_text' => true,
		'facebook_text' => true,
		'linkedin_text' => true,
		'post_tweet' => true,
		'post_facebook' => true,
		'facebook_pages' => true,
		'facebook_personal' => true,
		'post_linkedin' => true,
		'linkedin_personal' => true,
		'linkedin_companies' => true,
		'start_date' => true,
		'sent_date' => true,
		'created_on' => true,
		'modified_on' => true,
		'status' => true,
		'partner_campaign_id' => true,
		'partner' => true,
		'campaign' => true,
		'email_template' => true,
		'parent_campaign' => true,
		'campaign_partner_mailinglists' => true,
		'auto_tweet' => true,
	];

}
