<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PartnerManagers Model
 */
class PartnerManagersTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('partner_managers');
		$this->displayField('id');
		$this->primaryKey('id');

		$this->hasMany('CampaignPartnerMailinglistDeals', [
			'foreignKey' => 'partner_manager_id'
		]);
		
		$this->belongsTo('Partners', [
			'foreignKey' => 'partner_id',
		]);
		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
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
			->add('user_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('user_id', 'create')
			->notEmpty('user_id')
			->add('created_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('created_on')
			->add('modified_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('modified_on')
			->requirePresence('status', 'create')
			->notEmpty('status')
			->requirePresence('primary_contact', 'create')
			->notEmpty('primary_contact');

		return $validator;
	}

}
