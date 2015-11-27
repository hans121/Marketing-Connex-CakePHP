<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SubscriptionPackages Model
 */
class SubscriptionPackagesTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('subscription_packages');
		$this->displayField('name');
		$this->primaryKey('id');
                $this->hasMany('Vendors', [
			'foreignKey' => 'subscription_package_id',
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
			->requirePresence('name', 'create')
			->notEmpty('name')
			->add('annual_price', 'valid', ['rule' => 'decimal'])
			->requirePresence('annual_price', 'create')
			->notEmpty('annual_price')
			->add('monthly_price', 'valid', ['rule' => 'decimal'])
			->requirePresence('monthly_price', 'create')
			->notEmpty('monthly_price')
			->add('signup_fee', 'valid', ['rule' => 'decimal'])
			->requirePresence('signup_fee', 'create')
			->allowEmpty('signup_fee')
			->allowEmpty('duration')
			->add('no_partners', 'valid', ['rule' => 'numeric'])
			->allowEmpty('no_partners')
			->allowEmpty('storage')
			->add('no_emails', 'valid', ['rule' => 'numeric'])
			->allowEmpty('no_emails')
			->allowEmpty('resource_library')
			->allowEmpty('portal_cms')
			->allowEmpty('MDF')
			->allowEmpty('deal_registration')
			->allowEmpty('partner_recruit')
			->allowEmpty('training')
			->allowEmpty('Socialmedia')
			->allowEmpty('multilingual')
			->allowEmpty('partner_incentive')
			->allowEmpty('partner_app')
			->add('created_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('created_on')
			->add('modified_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('modified_on')
			->requirePresence('status', 'create')
			->notEmpty('status');

		return $validator;
	}

}
