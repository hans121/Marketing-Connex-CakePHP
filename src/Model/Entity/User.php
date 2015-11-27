<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity.
 */
class User extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'username' => true,
		'email' => true,
		'password' => true,
		'created_on' => true,
		'modified_on' => true,
		'status' => true,
		'role' => true,
		'first_name' => true,
		'last_name' => true,
		'job_title' => true,
		'title' => true,
		'phone' => true,
		'partner_managers' => true,
		'vendor_managers' => true,
		
	];
        protected function _setPassword($password) {
            return (new DefaultPasswordHasher)->hash($password);
        }
        protected function _getFullName() {
            return $this->_properties['first_name'] . '  ' .$this->_properties['last_name'];
        }


}
