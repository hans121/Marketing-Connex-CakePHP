<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Settings Model
 */
class SettingsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('settings');
		$this->displayField('settingname');
		$this->primaryKey('settingname');

	}

/**
 * Default validation rules.
 *
 * @param \Cake\Validation\Validator $validator
 * @return \Cake\Validation\Validator
 */
	public function validationDefault(Validator $validator) {
		$validator
			->notEmpty('settingname')
			->requirePresence('settingvalue', 'create')
			->allowEmpty('settingvalue');

		return $validator;
	}

}
