<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Partners Model
 */
class PartnerLeadDealsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('partner_lead_deals');
		$this->displayField('product_description');
		$this->primaryKey('id');
		
		$this->belongsTo('PartnerLeads', [
			'foreignKey' => 'partner_lead_id',
		]);
		
		$this->belongsTo('PartnerManagers', [
			'foreignKey' => 'partner_manager_id',
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
			->add('partner_lead_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('partner_lead_id', 'create')
			->notEmpty('partner_lead_id')
			->add('partner_manager_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('partner_manager_id', 'create')
			->notEmpty('partner_manager_id')
			->requirePresence('product_description', 'create')
			->notEmpty('product_description')
			->requirePresence('quantity_sold', 'create')
			->notEmpty('quantity_sold')
			->requirePresence('deal_value', 'create')
			->notEmpty('deal_value')
			->allowEmpty('status')
			->allowEmpty('closure_date');

		return $validator;
	}

}
