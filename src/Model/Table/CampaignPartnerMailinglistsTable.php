<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CampaignPartnerMailinglists Model
 */
class CampaignPartnerMailinglistsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('campaign_partner_mailinglists');
		$this->displayField('title');
		$this->primaryKey('id');

		$this->hasMany('CampaignPartnerMailinglistDeals', [
			'foreignKey' => 'campaign_partner_mailinglist_id',
		]);
		$this->hasMany('PartnerManagers', [
			'foreignKey' => 'partner_id',
		]);
		$this->belongsTo('Partners', [
			'foreignKey' => 'partner_id',
		]);
		$this->belongsTo('Campaigns', [
			'foreignKey' => 'campaign_id',
		]);
		$this->belongsTo('Vendors', [
			'foreignKey' => 'vendor_id',
		]);
		$this->belongsTo('PartnerCampaigns', [
			'foreignKey' => 'partner_campaign_id',
		]);
		$this->belongsTo('PartnerCampaignEmailSettings', [
			'foreignKey' => 'partner_campaign_email_setting_id',
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
			->add('campaign_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('campaign_id', 'create')
			->notEmpty('campaign_id')
			->add('vendor_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('vendor_id', 'create')
			->notEmpty('vendor_id')
			->add('partner_campaign_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('partner_campaign_id', 'create')
			->notEmpty('partner_campaign_id')
			->requirePresence('first_name', 'create')
			->notEmpty('first_name')
			->requirePresence('last_name', 'create')
			->notEmpty('last_name')
			->add('email', 'valid', ['rule' => 'email'])
			->requirePresence('email', 'create')
			->notEmpty('email')
			->allowEmpty('mandrillemailid')
			->allowEmpty('participate_campaign')
			->allowEmpty('subscribe')
			->allowEmpty('status')
			->add('created_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('created_on')
			->add('modified_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('modified_on')
			->add('partner_campaign_email_setting_id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('partner_campaign_email_setting_id')
			->add('opens', 'valid', ['rule' => 'numeric'])
			->allowEmpty('opens')
			->add('clicks', 'valid', ['rule' => 'numeric'])
			->allowEmpty('company')
			->allowEmpty('industry')
			->allowEmpty('city')
			->allowEmpty('country')
			->allowEmpty('clicks');

		return $validator;
	}

}
