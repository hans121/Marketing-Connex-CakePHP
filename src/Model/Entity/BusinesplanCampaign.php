<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BusinesplanCampaign Entity.
 */
class BusinesplanCampaign extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'businesplan_id' => true,
		'campaign_id' => true,
		'created_on' => true,
		'modified_on' => true,
		'status' => true,
		'businesplan' => true,
		'campaign' => true,
	];

}
