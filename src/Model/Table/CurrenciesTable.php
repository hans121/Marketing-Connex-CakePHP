<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Currencies Model
 */
class CurrenciesTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('currencies');
		$this->displayField('id');
		$this->primaryKey('id');
	}

/**
 * Default validation rules.
 *
 * @param \Cake\Validation\Validator $validator instance
 * @return \Cake\Validation\Validator
 */
	public function validationDefault(Validator $validator) {
		$validator
			->add('id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('id', 'create')
			->allowEmpty('countryname')
			->allowEmpty('iso_alpha2')
			->allowEmpty('iso_alpha3')
			->add('iso_numeric', 'valid', ['rule' => 'numeric'])
			->allowEmpty('iso_numeric')
			->allowEmpty('currency_code')
			->allowEmpty('currency_name')
			->allowEmpty('currrency_symbol')
			->allowEmpty('flag');

		return $validator;
	}

}
