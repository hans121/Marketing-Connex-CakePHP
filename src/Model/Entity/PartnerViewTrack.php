<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PartnerViewTrack Entity.
 */
class PartnerViewTrack extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'partner_id' => true,
		'viewstatus' => true,
		'type' => true,
		'campaign_id' => true,
		'businesplan_id' => true,
		'created_on' => true,
		'modified_on' => true,
		'partner' => true,
		'campaign' => true,
		'businesplan' => true,
	];

}
