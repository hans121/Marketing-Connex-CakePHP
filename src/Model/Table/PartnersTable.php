<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Partners Model
 */
class PartnersTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('partners');
		$this->displayField('company_name');
		$this->primaryKey('id');

		$this->belongsTo('Vendors', [
			'foreignKey' => 'vendor_id',
		]);
        $this->belongsTo('PartnerGroups', [
			'foreignKey' => 'partner_group_id',
		]);
        $this->belongsTo('VendorManagers', [
			'foreignKey' => 'vendor_manager_id',
		]);
		$this->hasMany('PartnerManagers', [
			'foreignKey' => 'partner_id',
		]);
		
		$this->hasMany('PartnerCampaigns', [
			'foreignKey' => 'partner_id',
		]);
		
		$this->hasMany('Businesplans', [
			'foreignKey' => 'partner_id',
		]);
		
		$this->hasMany('PartnerGroupMembers',[
			'foreignKey' => 'partner_id',
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
			->add('vendor_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('vendor_id', 'create')
			->notEmpty('vendor_id')
			->requirePresence('company_name', 'create')
			->notEmpty('company_name')
			->allowEmpty('logo_url')
			->allowEmpty('logo_path')
			->notEmpty('email')
      		->add('email', 'valid', ['rule' => 'email'])
			->allowEmpty('phone')
			->allowEmpty('fax')
			->allowEmpty('website')
			->allowEmpty('twitter')
			->allowEmpty('facebook')
			->allowEmpty('linkedin')
			->add('no_employees', 'valid', ['rule' => 'numeric'])
			->allowEmpty('no_employees')
			->add('no_offices', 'valid', ['rule' => 'numeric'])
			->allowEmpty('no_offices')
			->add('total_a_revenue', 'valid', ['rule' => 'decimal'])
			->allowEmpty('total_a_revenue')
			->requirePresence('address', 'create')
			->notEmpty('address')
			->requirePresence('country', 'create')
			->notEmpty('country')
			->requirePresence('city', 'create')
			->notEmpty('city')
			->allowEmpty('state')
			->requirePresence('postal_code', 'create')
			->notEmpty('postal_code')
			->add('vendor_manager', 'valid', ['rule' => 'numeric'])
			->allowEmpty('vendor_manager')
			->allowEmpty('twitter_oauth_token')
			->allowEmpty('twitter_oauth_token_secret')
			->allowEmpty('linkedin_oauth_token')
			->allowEmpty('linkedin_oauth_token_expiry')
			->allowEmpty('fb_longlived_access_token')			
      		->allowEmpty('partner_group_id');

		return $validator;
	}

}
