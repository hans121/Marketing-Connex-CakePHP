<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 */
class AdminsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('admins');
		$this->primaryKey('id');

		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
		]);
		$this->belongsTo('AdminRoles', [
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
			->requirePresence('user_id', 'create')
			->notEmpty('user_id')
			->requirePresence('admin_role_id', 'create')
			->notEmpty('admin_role_id');

		return $validator;
	}

}
