<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CampaignResource Entity.
 */
class CampaignResource extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'campaign_id' => true,
		'vendor_id' => true,
		'title' => true,
		'filepath' => true,
		'created_on' => true,
		'modified_on' => true,
		'status' => true,
		'campaign' => true,
		'vendor' => true,
	];

}
