<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Businesplans Model
 */
class BusinesplansTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('businesplans');
		$this->displayField('business_case');
		$this->primaryKey('id');

		$this->belongsTo('Partners', [
			'foreignKey' => 'partner_id',
		]);
		$this->belongsTo('Financialquarters', [
			'foreignKey' => 'financialquarter_id',
		]);
		$this->belongsTo('Vendors', [
			'foreignKey' => 'vendor_id',
		]);
		$this->hasMany('BusinesplanCampaigns', [
			'foreignKey' => 'businesplan_id',
                        'dependent' => true,
                        'cascadeCallbacks' => true,
		]);
                $this->addBehavior('Timestamp', [
                        'events' => [
                        'Model.beforeSave' => [
                        'created_on' => 'new',
                        'modified_on' => 'always',
                        ]

                    ]   
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
			->add('partner_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('partner_id', 'create')
			->notEmpty('partner_id')
			->add('financialquarter_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('financialquarter_id', 'create')
			->notEmpty('financialquarter_id')
			->add('vendor_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('vendor_id', 'create')
			->notEmpty('vendor_id')
			->allowEmpty('business_case')
			->allowEmpty('target_customers')
			->allowEmpty('target_geography')
			->add('required_amount', 'valid', ['rule' => 'decimal'])
			->allowEmpty('required_amount')
			->add('expected_result', 'valid', ['rule' => 'numeric'])
			->allowEmpty('expected_result')
			->add('expected_roi', 'valid', ['rule' => 'decimal'])
			->allowEmpty('expected_roi')
			->add('created_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('created_on')
			->add('modified_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('modified_on')
			->requirePresence('vendor_id', 'create')
			->allowEmpty('note')
			->notEmpty('status');

		return $validator;
	}

}
