<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Partners Model
 */
class PartnerLeadsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('partner_leads');
		$this->primaryKey('id');
		
		$this->belongsTo('Leads', [
			'foreignKey' => 'lead_id',
		]);
		
		$this->belongsTo('Partners', [
			'foreignKey' => 'partner_id',
		]);
		
		$this->hasOne('PartnerLeadDeals', [
			'foreignKey' => 'partner_lead_id',
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
			->add('lead_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('lead_id', 'create')
			->notEmpty('lead_id')
			->add('partner_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('partner_id', 'create')
			->notEmpty('partner_id')
			->allowEmpty('note')
			->notEmpty('response_time')
			->allowEmpty('responsed');

		return $validator;
	}

}
