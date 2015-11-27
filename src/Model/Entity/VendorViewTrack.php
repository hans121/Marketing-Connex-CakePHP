<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VendorViewTrack Entity.
 */
class VendorViewTrack extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'vendor_id' => true,
		'viewstatus' => true,
		'type' => true,
		'campaign_id' => true,
		'businesplan_id' => true,
		'created_on' => true,
		'modified_on' => true,
		'vendor' => true,
		'campaign' => true,
		'businesplan' => true,
	];

}
