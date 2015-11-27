<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PartnerCampaignEmailSettings Model
 */
class PartnerCampaignEmailSettingsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('partner_campaign_email_settings');
		$this->displayField('id');
		$this->primaryKey('id');

		$this->belongsTo('Partners', [
			'foreignKey' => 'partner_id',
		]);
		$this->belongsTo('Campaigns', [
			'foreignKey' => 'campaign_id',
		]);
		$this->belongsTo('EmailTemplates', [
			'foreignKey' => 'email_template_id',
		]);
		$this->belongsTo('PartnerCampaigns', [
			'foreignKey' => 'partner_campaign_id',
		]);
		$this->hasMany('CampaignPartnerMailinglists', [
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
			->add('email_template_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('email_template_id', 'create')
			->notEmpty('email_template_id')
			->requirePresence('from_name', 'create')
			->notEmpty('from_name')
			->requirePresence('from_email', 'create')
			->notEmpty('from_email')
			->allowEmpty('reply_to_email')
			->allowEmpty('subject_option')
			->allowEmpty('tweet_text')
			->allowEmpty('facebook_text')
			->allowEmpty('linkedin_text')
			->allowEmpty('post_tweet')
			->allowEmpty('post_facebook')
			->allowEmpty('post_linkedin')
			->allowEmpty('linkedin_personal')
			->allowEmpty('linkedin_companies')
			->allowEmpty('facebook_pages')
			->allowEmpty('facebook_personal')
			->add('start_date', 'valid', ['rule' => 'datetime'])
			->allowEmpty('start_date')
			->add('sent_date', 'valid', ['rule' => 'datetime'])
			->allowEmpty('sent_date')
			->add('created_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('created_on')
			->add('modified_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('modified_on')
			->allowEmpty('status')
			->add('partner_campaign_id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('partner_campaign_id')
			->allowEmpty('auto_tweet');
		return $validator;
	}

}
