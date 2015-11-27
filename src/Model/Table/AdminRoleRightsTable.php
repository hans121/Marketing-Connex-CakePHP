<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 */
class AdminRoleRightsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('admin_role_rights');
		$this->primaryKey('id');
		
		$this->belongsTo('AdminRoles', [
			'foreignKey' => 'admin_role_id',
		]);
		$this->belongsTo('AdminRights', [
			'foreignKey' => 'admin_right_id',
		]);
	}

/**
 * Default validation rules.
 *
 * @param \Cake\Validation\Validator $validator
 * @return \Cake\Validation\Validator
 */
	public function validationDefault(Validator $validator) {
		$validator
			->add('id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('id', 'create')
			->requirePresence('admin_role_id', 'create')
			->notEmpty('admin_role_id')
			->requirePresence('admin_right_id', 'create')
			->notEmpty('admin_right_id');

		return $validator;
	}

}
