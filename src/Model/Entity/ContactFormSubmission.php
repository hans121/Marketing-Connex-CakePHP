<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContactFormSubmission Entity.
 */
class ContactFormSubmission extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'firstname' => true,
		'lastname' => true,
		'position' => true,
		'company' => true,
		'email' => true,
		'phone' => true,
		'info' => true,
		'message' => true,
		'ip_address' => true,
		'browser_agent' => true
	];

}
