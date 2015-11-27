<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Partners Model
 */
class LeadResponseNotesTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('lead_response_notes');
		$this->displayField('response_note');
		$this->primaryKey('id');
		
		$this->belongsTo('Partners', [
			'foreignKey' => 'partner_id',
		]);
		
		$this->belongsTo('Leads', [
			'foreignKey' => 'lead_id',
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
			->allowEmpty('response_note')
			->allowEmpty('response')
			->allowEmpty('response_status');

		return $validator;
	}

}
