<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Financialquarters Model
 */
class FinancialquartersTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('financialquarters');
		$this->displayField('quartertitle');
		$this->primaryKey('id');
		$this->belongsTo('Vendors', [
			'alias' => 'Vendors', 
			'foreignKey' => 'vendor_id'
		]);
		$this->hasMany('Businesplans', [
			'alias' => 'Businesplans', 
			'foreignKey' => 'financialquarter_id'
		]);
		$this->hasMany('Campaigns', [
			'alias' => 'Campaigns', 
			'foreignKey' => 'financialquarter_id'
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
			->add('vendor_id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('vendor_id')
			->add('startdate', 'valid', ['rule' => 'datetime'])
			->allowEmpty('startdate')
			->add('enddate', 'valid', ['rule' => 'datetime'])
			->allowEmpty('enddate')
			->allowEmpty('quartertitle');

		return $validator;
	}

}
