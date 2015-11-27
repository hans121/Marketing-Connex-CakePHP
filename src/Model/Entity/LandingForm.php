<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LandingForm Entity.
 */
class LandingForm extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'landing_page_id' => true,
		'first_name' => true,
		'last_name' => true,
		'email_address' => true,
		'phone' => true,
		'fax' => true,
		'company' => true,
		'job_title' => true,
		'message' => true,
		'created_on' => true,
		'modified_on' => true,
		'status' => true,
		'landing_page' => true,
	];

}
