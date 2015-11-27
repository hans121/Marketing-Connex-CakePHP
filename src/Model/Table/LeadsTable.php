<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Partners Model
 */
class LeadsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('leads');
		$this->displayField('first_name');
		$this->primaryKey('id');
		
		$this->belongsTo('Partners', [
			'foreignKey' => 'partner_id',
		]);
		
		$this->belongsTo('Vendors', [
			'foreignKey' => 'vendor_id',
		]);
			
		$this->hasOne('LeadDeals', [
			'foreignKey' => 'lead_id'
		]);
		
		$this->hasMany('LeadResponseNotes', [
			'foreignKey' => 'lead_id'
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
			->add('vendor_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('vendor_id', 'create')
			->notEmpty('vendor_id')
			->requirePresence('first_name', 'create')
			->notEmpty('first_name')
			->requirePresence('last_name', 'create')
			->notEmpty('last_name')
			->requirePresence('email', 'create')
			->notEmpty('email')
			->add('email', 'valid', ['rule' => 'email'])
			->allowEmpty('company')
			->allowEmpty('phone')
			->allowEmpty('position')
			->allowEmpty('assigned')
			->allowEmpty('note')
			->allowEmpty('partner_id')
			->allowEmpty('response_time')
			->allowEmpty('responsed')
			->allowEmpty('response')
			->allowEmpty('response_status')
			->allowEmpty('response_note')
			->allowEmpty('lead_status')
			->allowEmpty('assigned_on')
			->allowEmpty('accepted_on')
			->allowEmpty('expire_on');

		return $validator;
	}

}
