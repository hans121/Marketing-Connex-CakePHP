<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 */
class AdminRightsTable extends Table {

	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		$this->table('admin_rights');
		$this->primaryKey('id');
		$this->displayField('controller_label');
		
		$this->belongsTo('AdminRoleRights', [
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
		->requirePresence('controller', 'create')
		->notEmpty('controller')
		->requirePresence('action', 'create')
		->notEmpty('action')
		->allowEmpty('controller_label')
		->allowEmpty('action_label');

		return $validator;
	}

}