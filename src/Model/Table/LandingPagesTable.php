<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LandingPages Model
 */
class LandingPagesTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('landing_pages');
		$this->displayField('id');
		$this->primaryKey('id');

		$this->belongsTo('Campaigns', [
			'foreignKey' => 'campaign_id',
		]);
		$this->belongsTo('Vendors', [
			'foreignKey' => 'vendor_id',
		]);
		$this->belongsTo('MasterTemplates', [
			'foreignKey' => 'master_template_id',
		]);
		$this->hasMany('LandingForms', [
			'foreignKey' => 'landing_page_id',
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
			->add('campaign_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('campaign_id', 'create')
			->notEmpty('campaign_id')
			->add('vendor_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('vendor_id', 'create')
			->notEmpty('vendor_id')
			->add('master_template_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('master_template_id', 'create')
			->notEmpty('master_template_id')
			->allowEmpty('banner_bg_image')
			->allowEmpty('banner_text')
			->requirePresence('heading', 'create')
			->notEmpty('heading')
			->allowEmpty('body_text')
			->requirePresence('form_heading', 'create')
			->notEmpty('form_heading')
			->allowEmpty('chk_first_name')
			->allowEmpty('chk_last_name')
			->allowEmpty('chk_email')
			->allowEmpty('chk_phone')
			->allowEmpty('chk_fax')
			->allowEmpty('chk_company')
			->allowEmpty('chk_job_title')
			->allowEmpty('chk_message')
			->allowEmpty('chk_frm_submission')
			->allowEmpty('downloadable_item')
			->allowEmpty('external_links')
			->allowEmpty('footer_text')
			->add('created_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('created_on')
			->add('modified_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('modified_on')
			->allowEmpty('status');

		return $validator;
	}

}
