<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Vendors Model
 */
class VendorsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('vendors');
		$this->displayField('company_name');
		$this->primaryKey('id');
		$this->belongsTo('SubscriptionPackages', [
			'alias' => 'SubscriptionPackages',
			'foreignKey' => 'subscription_package_id'
		]);
		$this->belongsTo('Coupons', [
			'alias' => 'Coupons',
			'foreignKey' => 'coupon_id'
		]);
		$this->hasMany('Businesplans', [
			'alias' => 'Businesplans',
			'foreignKey' => 'vendor_id',
                        'dependent' => true,
                        'cascadeCallbacks' => true,
		]);
		$this->hasMany('CampaignPartnerMailinglists', [
			'alias' => 'CampaignPartnerMailinglists',
			'foreignKey' => 'vendor_id'
		]);
		$this->hasMany('CampaignResources', [
			'alias' => 'CampaignResources',
			'foreignKey' => 'vendor_id'
		]);
		$this->hasMany('Campaigns', [
			'alias' => 'Campaigns',
			'foreignKey' => 'vendor_id',
                        'dependent' => true,
                        'cascadeCallbacks' => true,
		]);
		
		$this->hasMany('EmailTemplates', [
			'alias' => 'EmailTemplates',
			'foreignKey' => 'vendor_id'
		]);
		$this->hasMany('Financialquarters', [
			'alias' => 'Financialquarters',
			'foreignKey' => 'vendor_id',
                        'dependent' => true,
                        'cascadeCallbacks' => true,
		]);
		$this->hasMany('Folders', [
			'alias' => 'Folders',
			'foreignKey' => 'vendor_id',
                        'dependent' => true,
                        'cascadeCallbacks' => true,
		]);
		$this->hasMany('Invoices', [
			'alias' => 'Invoices',
			'foreignKey' => 'vendor_id',
                        'dependent' => true,
                        'cascadeCallbacks' => true,
		]);
		$this->hasMany('LandingPages', [
			'alias' => 'LandingPages',
			'foreignKey' => 'vendor_id'
		]);
		$this->hasMany('PartnerGroups', [
			'alias' => 'PartnerGroups',
			'foreignKey' => 'vendor_id',
                        'dependent' => true,
                        'cascadeCallbacks' => true,
		]);
		$this->hasMany('Partners', [
			'alias' => 'Partners',
			'foreignKey' => 'vendor_id',
                        'dependent' => true,
                        'cascadeCallbacks' => true,
		]);
		$this->hasMany('Resources', [
			'alias' => 'Resources',
			'foreignKey' => 'vendor_id',
                        'dependent' => true,
                        'cascadeCallbacks' => true,
		]);
		$this->hasMany('VendorManagers', [
			'alias' => 'VendorManagers',
			'foreignKey' => 'vendor_id',
                        'dependent' => true,
                        'cascadeCallbacks' => true,
		]);
		$this->hasMany('VendorPayments', [
			'alias' => 'VendorPayments',
			'foreignKey' => 'vendor_id',
                        'dependent' => true,
                        'cascadeCallbacks' => true,
		]);
		$this->hasMany('VendorViewTracks', [
			'alias' => 'VendorViewTracks',
			'foreignKey' => 'vendor_id',
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
 * @param \Cake\Validation\Validator $validator instance
 * @return \Cake\Validation\Validator
 */
	public function validationDefault(Validator $validator) {
		$validator
			->add('id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('id', 'create')
			->requirePresence('company_name', 'create')
			->notEmpty('company_name')
			->allowEmpty('logo_url')
			->allowEmpty('logo_path')
			->allowEmpty('phone')
			->allowEmpty('fax')
			->allowEmpty('website')
			->requirePresence('address', 'create')
			->notEmpty('address')
			->requirePresence('country', 'create')
			->notEmpty('country')
			->requirePresence('city', 'create')
			->notEmpty('city')
			->allowEmpty('state')
			->requirePresence('postalcode', 'create')
			->notEmpty('postalcode')
			->add('subscription_package_id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('subscription_package_id')
			->requirePresence('status', 'create')
			->notEmpty('status')
			->add('coupon_id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('coupon_id')
			->allowEmpty('language')
			->requirePresence('subscription_type', 'create')
			->notEmpty('subscription_type')
			->add('created_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('created_on')
			->add('modified_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('modified_on')
                        ->add('subscription_expiry_date', 'valid', ['rule' => 'datetime'])
			->allowEmpty('subscription_expiry_date')
			->add('last_billed_date', 'valid', ['rule' => 'datetime'])
			->allowEmpty('last_billed_date')
			->add('status_change_date', 'valid', ['rule' => 'datetime'])
			->allowEmpty('status_change_date')
			->add('current_bill_end_date', 'valid', ['rule' => 'datetime'])
			->allowEmpty('current_bill_end_date')
			->requirePresence('financial_quarter_start_month', 'create')
			->notEmpty('financial_quarter_start_month')
			->allowEmpty('currency')
			->allowEmpty('vat_no')
			->allowEmpty('currency_choice')
			->allowEmpty('salesforce_token')
			->allowEmpty('salesforce_refresh_token')
			->allowEmpty('salesforce_instance_url')
			->allowEmpty('salesforce_identity');

		return $validator;
	}

}
