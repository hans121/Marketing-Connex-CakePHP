<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 */
class AdminRolesTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('admin_roles');
		$this->primaryKey('id');
		$this->displayField('role');
		
		$this->belongsTo('Admins', [
				'foreignKey' => 'admin_role_id',
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
			->requirePresence('role', 'create')
			->notEmpty('role')
			->allowEmpty('description');

		return $validator;
	}

}

