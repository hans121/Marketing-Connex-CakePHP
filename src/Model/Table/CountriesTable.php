<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Countries Model
 */
class CountriesTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('countries');
		$this->displayField('title');
		$this->primaryKey('iso_alpha_code_2');

	}

/**
 * Default validation rules.
 *
 * @param \Cake\Validation\Validator $validator
 * @return \Cake\Validation\Validator
 */
	public function validationDefault(Validator $validator) {
		$validator
                        ->notEmpty('iso_alpha_code_2')
			->requirePresence('iso_alpha_code_3', 'create')
			->notEmpty('iso_alpha_code_3')
			->requirePresence('title', 'create')
			->notEmpty('title')
			->requirePresence('iso_numeric', 'create')
			->notEmpty('iso_numeric');

		return $validator;
	}

}
