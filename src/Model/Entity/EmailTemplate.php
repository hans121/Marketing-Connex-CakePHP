<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmailTemplate Entity.
 */
class EmailTemplate extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'vendor_id' => true,
		'campaign_id' => true,
		'use_templates' => true,
		'custom_template' => true,
		'template_override' => true,
		'master_template_id' => true,
		'subject_text' => true,
		'subject_option1' => true,
		'subject_option2' => true,
		'subject_option3' => true,
		'created_on' => true,
		'modified_on' => true,
		'status' => true,
		'campaign' => true,
		'master_template' => true,
		'spam' => true,
	];

}
