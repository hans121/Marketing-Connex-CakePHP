<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PartnerCampaign Entity.
 */
class PartnerCampaign extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'partner_id' => true,
		'campaign_id' => true,
		'status' => true,
		'created_on' => true,
		'modified_on' => true,
		'businesplan_id' => true,
		'partner' => true,
		'campaign' => true,
		'businesplan' => true,
        'partner_campaign_email_settings' => true,
	];

}
