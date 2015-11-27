<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Campaigns Model
 */
class CampaignsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('campaigns');
		$this->displayField('name');
		$this->primaryKey('id');

		$this->belongsTo('Vendors', [
			'foreignKey' => 'vendor_id',
		]);
		$this->belongsTo('Financialquarters', [
			'foreignKey' => 'financialquarter_id',
		]);
		$this->hasMany('BusinesplanCampaigns', [
			'foreignKey' => 'campaign_id',
		]);
		$this->hasMany('CampaignPartnerMailinglists', [
			'foreignKey' => 'campaign_id',
		]);
		$this->hasMany('CampaignResources', [
			'foreignKey' => 'campaign_id',
		]);
		$this->hasMany('EmailTemplates', [
			'foreignKey' => 'campaign_id',
		]);
		$this->hasMany('LandingPages', [
			'foreignKey' => 'campaign_id',
		]);
		$this->hasMany('PartnerViewTracks', [
			'foreignKey' => 'campaign_id',
		]);
                $this->hasMany('PartnerCampaigns', [
			'foreignKey' => 'campaign_id',
		]);
		$this->hasMany('VendorViewTracks', [
			'foreignKey' => 'campaign_id',
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
			->add('financialquarter_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('financialquarter_id', 'create')
			->notEmpty('financialquarter_id')
			->requirePresence('name', 'create')
			->notEmpty('name')
			->allowEmpty('campaign_type')
			->allowEmpty('mobile_delivery')
			->allowEmpty('target_market')
			->allowEmpty('subject_line')
			->allowEmpty('html')
			->allowEmpty('available_to')
			->allowEmpty('include_landing_page')
			->add('date_created', 'valid', ['rule' => 'datetime'])
			->allowEmpty('date_created')
			->add('date_modified', 'valid', ['rule' => 'datetime'])
			->allowEmpty('date_modified')
			->requirePresence('status', 'create')
			->notEmpty('status')
			->add('sales_value', 'valid', ['rule' => 'decimal'])
			->requirePresence('sales_value', 'create')
			->notEmpty('sales_value')
			->add('send_limit', 'valid', ['rule' => 'numeric'])
			->requirePresence('send_limit', 'create')
			->notEmpty('send_limit')
			->add('allocated_send', 'valid', ['rule' => 'numeric'])
			->allowEmpty('allocated_send')
			->allowEmpty('itconsulting')
			->allowEmpty('softwaredev')
			->allowEmpty('telecom')
			->allowEmpty('voip')
			->allowEmpty('internet')
			->allowEmpty('professional')
			->allowEmpty('appshost')
			->allowEmpty('storage')
			->allowEmpty('disaster')
			->allowEmpty('customsystem')
			->allowEmpty('wireless')
			->allowEmpty('serviceprovider')
			->allowEmpty('cloud')
			->allowEmpty('primary_color')
			->allowEmpty('secondary_color');

		return $validator;
	}

}
